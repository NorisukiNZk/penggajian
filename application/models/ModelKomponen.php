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

    /**
     * Internal: Hitung komponen berdasarkan tipe
     */
    private function _hitung_komponen($tipe, $nik, $bulan, $gaji_pokok)
    {
        $total = 0;
        $detail = array();

        // Ambil semua komponen aktif dengan tipe tertentu
        $this->db->where('tipe', $tipe);
        $this->db->where('is_aktif', 1);
        $this->db->order_by('nama_komponen', 'ASC');
        $komponen_list = $this->db->get('komponen_gaji')->result();

        foreach ($komponen_list as $k) {
            // Cek apakah ada override untuk pegawai ini
            $override = $this->db->get_where('komponen_gaji_pegawai', array(
                'id_komponen' => $k->id_komponen,
                'nik' => $nik,
                'bulan' => $bulan
            ))->row();

            if ($override) {
                $nominal = $override->nominal_override;
            } else if ($k->is_persentase == 1) {
                // Hitung persentase dari gaji pokok
                $nominal = ($gaji_pokok * $k->nominal) / 100;
            } else {
                $nominal = $k->nominal;
            }

            $total += $nominal;
            $detail[] = array(
                'id_komponen' => $k->id_komponen,
                'nama_komponen' => $k->nama_komponen,
                'tipe' => $k->tipe,
                'nominal' => $nominal,
                'is_persentase' => $k->is_persentase,
                'is_override' => ($override) ? true : false
            );
        }

        return array('total' => $total, 'detail' => $detail);
    }
}
