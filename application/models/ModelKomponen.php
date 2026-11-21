<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelKomponen extends CI_Model
{
    // =====================================================
    // CRUD Komponen Gaji
    // =====================================================

    /**
     * Ambil semua komponen gaji
     */
    public function get_all_komponen()
    {
        $this->db->order_by('tipe', 'ASC');
        $this->db->order_by('nama_komponen', 'ASC');
        return $this->db->get('komponen_gaji')->result();
    }

    /**
     * Ambil komponen aktif saja
     */
    public function get_komponen_aktif()
    {
        $this->db->where('is_aktif', 1);
        $this->db->order_by('tipe', 'ASC');
        return $this->db->get('komponen_gaji')->result();
    }

    /**
     * Ambil satu komponen berdasarkan ID
     */
    public function get_komponen_by_id($id)
    {
        return $this->db->get_where('komponen_gaji', array('id_komponen' => $id))->row();
    }

    /**
     * Ambil komponen tunjangan aktif
     */
    public function get_tunjangan_aktif()
    {
        $this->db->where('tipe', 'tunjangan');
        $this->db->where('is_aktif', 1);
        $this->db->order_by('nama_komponen', 'ASC');
        return $this->db->get('komponen_gaji')->result();
    }

    /**
     * Ambil komponen potongan aktif
     */
    public function get_potongan_aktif()
    {
        $this->db->where('tipe', 'potongan');
        $this->db->where('is_aktif', 1);
        $this->db->order_by('nama_komponen', 'ASC');
        return $this->db->get('komponen_gaji')->result();
    }

    /**
     * Tambah komponen baru
     */
    public function insert_komponen($data)
    {
        return $this->db->insert('komponen_gaji', $data);
    }

    /**
     * Update komponen
     */
    public function update_komponen($id, $data)
    {
        $this->db->where('id_komponen', $id);
        return $this->db->update('komponen_gaji', $data);
    }

    /**
     * Hapus komponen (cascade ke komponen_gaji_pegawai)
     */
    public function delete_komponen($id)
    {
        // Hapus override per pegawai dulu
        $this->db->where('id_komponen', $id);
        $this->db->delete('komponen_gaji_pegawai');

        // Hapus komponen
        $this->db->where('id_komponen', $id);
        return $this->db->delete('komponen_gaji');
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function toggle_status($id)
    {
        $komponen = $this->get_komponen_by_id($id);
        if ($komponen) {
            $new_status = ($komponen->is_aktif == 1) ? 0 : 1;
            $this->db->where('id_komponen', $id);
            return $this->db->update('komponen_gaji', array('is_aktif' => $new_status));
        }
        return false;
    }

    // =====================================================
    // Komponen per Pegawai (Override)
    // =====================================================

    /**
     * Ambil semua override komponen untuk pegawai tertentu pada bulan tertentu
     */
    public function get_komponen_pegawai($nik, $bulan)
    {
        $this->db->select('komponen_gaji_pegawai.*, komponen_gaji.nama_komponen, komponen_gaji.tipe');
        $this->db->from('komponen_gaji_pegawai');
        $this->db->join('komponen_gaji', 'komponen_gaji.id_komponen = komponen_gaji_pegawai.id_komponen');
        $this->db->where('komponen_gaji_pegawai.nik', $nik);
        $this->db->where('komponen_gaji_pegawai.bulan', $bulan);
        return $this->db->get()->result();
    }

    /**
     * Simpan override komponen per pegawai
     */
    public function set_komponen_pegawai($data)
    {
        // Cek apakah sudah ada override untuk pegawai+komponen+bulan ini
        $existing = $this->db->get_where('komponen_gaji_pegawai', array(
            'id_komponen' => $data['id_komponen'],
            'nik' => $data['nik'],
            'bulan' => $data['bulan']
        ))->row();

        if ($existing) {
            $this->db->where('id', $existing->id);
            return $this->db->update('komponen_gaji_pegawai', array('nominal_override' => $data['nominal_override']));
        } else {
            return $this->db->insert('komponen_gaji_pegawai', $data);
        }
    }

    /**
     * Hapus override komponen per pegawai
     */
    public function delete_komponen_pegawai($id)
    {
        return $this->db->delete('komponen_gaji_pegawai', array('id' => $id));
    }

    /**
     * Ambil daftar pegawai dengan override untuk komponen tertentu pada bulan tertentu
     */
    public function get_pegawai_komponen($id_komponen, $bulan)
    {
        $this->db->select('data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jabatan, komponen_gaji_pegawai.nominal_override, komponen_gaji_pegawai.id as id_override');
        $this->db->from('data_pegawai');
        $this->db->join('komponen_gaji_pegawai', 
            'komponen_gaji_pegawai.nik = data_pegawai.nik AND komponen_gaji_pegawai.id_komponen = ' . (int)$id_komponen . ' AND komponen_gaji_pegawai.bulan = ' . $this->db->escape($bulan), 
            'left');
        $this->db->order_by('data_pegawai.nama_pegawai', 'ASC');
        return $this->db->get()->result();
    }

    // =====================================================
    // Perhitungan Gaji
    // =====================================================

    /**
     * Hitung total tunjangan dinamis untuk pegawai tertentu
     * @param string $nik NIK pegawai
     * @param string $bulan Periode (MMYYYY)
     * @param int $gaji_pokok Gaji pokok (untuk perhitungan persentase)
     * @return array ['total' => nominal_total, 'detail' => [array of komponen]]
     */
    public function hitung_total_tunjangan($nik, $bulan, $gaji_pokok)
    {
        return $this->_hitung_komponen('tunjangan', $nik, $bulan, $gaji_pokok);
    }

    /**
     * Hitung total potongan dinamis untuk pegawai tertentu
     * @param string $nik NIK pegawai
     * @param string $bulan Periode (MMYYYY)
     * @param int $gaji_pokok Gaji pokok (untuk perhitungan persentase)
     * @return array ['total' => nominal_total, 'detail' => [array of komponen]]
     */
    public function hitung_total_potongan($nik, $bulan, $gaji_pokok)
    {
        return $this->_hitung_komponen('potongan', $nik, $bulan, $gaji_pokok);
    }

    private static $komponen_aktif_cache = null;

    private function _ensure_calculator()
    {
        if (!class_exists('Payroll_calculator', false)) {
            require_once APPPATH . 'libraries/Payroll_calculator.php';
        }
    }

    private function _get_komponen_aktif_grouped()
    {
        if (self::$komponen_aktif_cache === null) {
            $this->db->where('is_aktif', 1);
            $this->db->order_by('nama_komponen', 'ASC');
            $all = $this->db->get('komponen_gaji')->result();
            self::$komponen_aktif_cache = array('tunjangan' => array(), 'potongan' => array());
            foreach ($all as $k) {
                $tipe = strtolower((string)$k->tipe);
                if (isset(self::$komponen_aktif_cache[$tipe])) {
                    self::$komponen_aktif_cache[$tipe][] = $k;
                }
            }
        }
        return self::$komponen_aktif_cache;
    }

    /**
     * Ambil seluruh komponen (tunjangan & potongan) sekaligus untuk sekelompok NIK di 1 bulan
     * sehingga menghindari query N+1 dalam perulangan payroll.
     */
    public function get_batch_komponen_bulan($bulan, $gaji_pokok_by_nik)
    {
        $this->_ensure_calculator();
        $grouped = $this->_get_komponen_aktif_grouped();

        $overrides = array();
        if (!empty($gaji_pokok_by_nik)) {
            $niks = array_keys($gaji_pokok_by_nik);
            $this->db->where('bulan', $bulan);
            $this->db->where_in('nik', $niks);
            $rows = $this->db->get('komponen_gaji_pegawai')->result();
            foreach ($rows as $row) {
                $overrides[$row->nik][(int)$row->id_komponen] = (float)$row->nominal_override;
            }
        }

        $result = array();
        foreach ($gaji_pokok_by_nik as $nik => $gaji_pokok) {
            $tj_detail = array();
            $tj_total = 0;
            foreach ($grouped['tunjangan'] as $k) {
                $ov = isset($overrides[$nik][(int)$k->id_komponen]) ? $overrides[$nik][(int)$k->id_komponen] : null;
                $item = Payroll_calculator::resolveKomponenItem($k, $gaji_pokok, $ov);
                $tj_total += $item['nominal'];
                $tj_detail[] = $item;
            }

            $pot_detail = array();
            $pot_total = 0;
            foreach ($grouped['potongan'] as $k) {
                $ov = isset($overrides[$nik][(int)$k->id_komponen]) ? $overrides[$nik][(int)$k->id_komponen] : null;
                $item = Payroll_calculator::resolveKomponenItem($k, $gaji_pokok, $ov);
                $pot_total += $item['nominal'];
                $pot_detail[] = $item;
            }

            $result[$nik] = array(
                'tunjangan' => array('total' => $tj_total, 'detail' => $tj_detail),
                'potongan'  => array('total' => $pot_total, 'detail' => $pot_detail)
            );
        }

        return $result;
    }

    /**
     * Internal: Hitung komponen berdasarkan tipe (1 query override per pegawai, tanpa N+1)
     */
    private function _hitung_komponen($tipe, $nik, $bulan, $gaji_pokok)
    {
        $this->_ensure_calculator();
        $grouped = $this->_get_komponen_aktif_grouped();
        $komponen_list = isset($grouped[$tipe]) ? $grouped[$tipe] : array();

        $overrides = array();
        if (!empty($komponen_list)) {
            $ov_rows = $this->db->get_where('komponen_gaji_pegawai', array(
                'nik'   => $nik,
                'bulan' => $bulan
            ))->result();
            foreach ($ov_rows as $ov) {
                $overrides[(int)$ov->id_komponen] = (float)$ov->nominal_override;
            }
        }

        $total = 0;
        $detail = array();

        foreach ($komponen_list as $k) {
            $ov_val = isset($overrides[(int)$k->id_komponen]) ? $overrides[(int)$k->id_komponen] : null;
            $item = Payroll_calculator::resolveKomponenItem($k, $gaji_pokok, $ov_val);
            $total += $item['nominal'];
            $detail[] = $item;
        }

        return array('total' => $total, 'detail' => $detail);
    }
}
