<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelAudit extends CI_Model
{
    private static $table_cache = array();

    private function has_table($table)
    {
        if (!array_key_exists($table, self::$table_cache)) {
            self::$table_cache[$table] = $this->db->table_exists($table);
        }
        return self::$table_cache[$table];
    }

    private function sanitize_payload($payload)
    {
        if ($payload === null) {
            return null;
        }
        if (is_object($payload)) {
            $payload = (array)$payload;
        }
        if (is_array($payload)) {
            foreach ($payload as $k => $v) {
                $lk = strtolower((string)$k);
                if (strpos($lk, 'password') !== false || strpos($lk, 'pass') !== false) {
                    $payload[$k] = '[REDACTED]';
                } elseif (is_array($v) || is_object($v)) {
                    $payload[$k] = $this->sanitize_payload($v);
                }
            }
            return json_encode($payload, JSON_UNESCAPED_UNICODE);
        }
        return (string)$payload;
    }

    public function catat($modul, $aksi, $target_id = null, $ringkasan = '', $data_lama = null, $data_baru = null, $override_actor = null)
    {
        if (!$this->has_table('audit_log')) {
            return false;
        }

        $aktor_id   = $this->session->userdata('id_pegawai');
        $aktor_nama = $this->session->userdata('nama_pegawai');
        $hak_akses  = $this->session->userdata('hak_akses');

        if (is_array($override_actor)) {
            $aktor_id   = isset($override_actor['id']) ? $override_actor['id'] : $aktor_id;
            $aktor_nama = isset($override_actor['nama']) ? $override_actor['nama'] : $aktor_nama;
            $hak_akses  = isset($override_actor['hak_akses']) ? $override_actor['hak_akses'] : $hak_akses;
        }

        $ua = $this->input->user_agent() ? substr((string)$this->input->user_agent(), 0, 250) : null;

        return $this->db->insert('audit_log', array(
            'aktor_id'   => $aktor_id ? (int)$aktor_id : null,
            'aktor_nama' => substr((string)($aktor_nama ?: 'Tamu / Sistem'), 0, 120),
            'hak_akses'  => substr((string)($hak_akses ?: 'guest'), 0, 20),
            'modul'      => substr((string)$modul, 0, 60),
            'aksi'       => substr((string)$aksi, 0, 60),
            'target_id'  => $target_id !== null ? substr((string)$target_id, 0, 64) : null,
            'ringkasan'  => substr((string)$ringkasan, 0, 255),
            'data_lama'  => $this->sanitize_payload($data_lama),
            'data_baru'  => $this->sanitize_payload($data_baru),
            'ip_address' => substr((string)$this->input->ip_address(), 0, 45),
            'user_agent' => $ua
        ));
    }

    public function get_logs($filters = array(), $limit = 150, $offset = 0)
    {
        if (!$this->has_table('audit_log')) {
            return array();
        }

        $this->db->from('audit_log');
        if (!empty($filters['modul'])) {
            $this->db->where('modul', $filters['modul']);
        }
        if (!empty($filters['aksi'])) {
            $this->db->where('aksi', $filters['aksi']);
        }
        if (!empty($filters['search'])) {
            $kw = trim((string)$filters['search']);
            $this->db->group_start()
                ->like('aktor_nama', $kw)
                ->or_like('ringkasan', $kw)
                ->or_like('target_id', $kw)
                ->or_like('ip_address', $kw)
                ->group_end();
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit((int)$limit, (int)$offset);
        return $this->db->get()->result();
    }

    public function get_distinct_modules()
    {
        if (!$this->has_table('audit_log')) {
            return array();
        }
        return $this->db->query("SELECT DISTINCT modul FROM audit_log ORDER BY modul ASC")->result();
    }

    public function get_lockout_remaining($ip_address, $username, $max_attempts = 5, $window_seconds = 300)
    {
        if (!$this->has_table('login_attempts')) {
            return 0;
        }

        $since = date('Y-m-d H:i:s', time() - (int)$window_seconds);

        $row = $this->db->query("
            SELECT COUNT(*) AS fail_count, MAX(attempted_at) AS last_attempt
            FROM login_attempts
            WHERE is_success = 0
              AND attempted_at >= ?
              AND (ip_address = ? OR (username != '' AND username = ?))
        ", array($since, $ip_address, $username))->row();

        if ($row && (int)$row->fail_count >= (int)$max_attempts && !empty($row->last_attempt)) {
            $unlock_at = strtotime($row->last_attempt) + (int)$window_seconds;
            $remaining = $unlock_at - time();
            return max(0, (int)$remaining);
        }

        return 0;
    }

    public function record_login_attempt($ip_address, $username, $is_success)
    {
        if (!$this->has_table('login_attempts')) {
            return false;
        }

        // Bersihkan catatan lebih tua dari 7 hari agar tabel tetap ramping
        $cutoff = date('Y-m-d H:i:s', time() - (7 * 86400));
        $this->db->where('attempted_at <', $cutoff)->delete('login_attempts');

        $this->db->insert('login_attempts', array(
            'ip_address'   => substr((string)$ip_address, 0, 45),
            'username'     => substr((string)$username, 0, 120),
            'is_success'   => $is_success ? 1 : 0,
            'attempted_at' => date('Y-m-d H:i:s')
        ));

        if ($is_success) {
            // Reset histori gagal untuk IP+username ini agar kuota pulih setelah login sukses
            $this->db->where('ip_address', $ip_address)
                ->where('username', $username)
                ->where('is_success', 0)
                ->delete('login_attempts');
        }

        return true;
    }
}
