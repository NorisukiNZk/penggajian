<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelAbsensiHarian extends CI_Model
{
    // =====================================================
    // Setting Absensi
    // =====================================================

    /**
     * Ambil setting absensi
     */
    public function get_setting()
    {
        return $this->db->get_where('setting_absensi', array('id' => 1))->row();
    }

    /**
     * Update setting absensi
     */
    public function update_setting($data)
    {
        $this->db->where('id', 1);
        return $this->db->update('setting_absensi', $data);
    }

    // =====================================================
    // Absensi Harian — Pegawai
    // =====================================================

    /**
     * Cek apakah pegawai sudah absen hari ini
     */
    public function get_absensi_hari_ini($nik)
    {
        return $this->db->get_where('absensi_harian', array(
            'nik' => $nik,
            'tanggal' => date('Y-m-d')
        ))->row();
    }

    /**
     * Proses absen masuk
     */
    public function absen_masuk($nik)
    {
        $setting = $this->get_setting();
        $jam_sekarang = date('H:i:s');

        // Proteksi Gerbang Waktu (Backend)
        if ($jam_sekarang < $setting->mulai_absen_masuk || $jam_sekarang > $setting->batas_terlambat_berat) {
            return false; // Di luar jam yang diizinkan
        }

        // Tentukan status otomatis
        $jam_masuk_setting = $setting->jam_masuk;
        $toleransi = $setting->toleransi_menit;

        // Hitung batas toleransi
        $batas_toleransi = date('H:i:s', strtotime($jam_masuk_setting . ' +' . $toleransi . ' minutes'));
        $batas_terlambat_berat = $setting->batas_terlambat_berat;

        if ($jam_sekarang <= $batas_toleransi) {
            $status = 'tepat_waktu';
        } else {
            $status = 'terlambat';
        }

        $keterangan = '';
        if ($status == 'terlambat' && $jam_sekarang > $batas_terlambat_berat) {
            $keterangan = 'Terlambat berat';
        } elseif ($status == 'terlambat') {
            // Hitung selisih menit terlambat
            $selisih = (strtotime($jam_sekarang) - strtotime($batas_toleransi)) / 60;
            $keterangan = 'Terlambat ' . ceil($selisih) . ' menit';
        }

        $data = array(
            'nik'        => $nik,
            'tanggal'    => date('Y-m-d'),
            'jam_masuk'  => $jam_sekarang,
            'status'     => $status,
            'keterangan' => $keterangan
        );

        return $this->db->insert('absensi_harian', $data);
    }

    /**
     * Proses absen pulang
     */
    public function absen_pulang($nik)
    {
        $setting = $this->get_setting();
        $jam_sekarang = date('H:i:s');

        // Proteksi Gerbang Waktu (Backend)
        if ($jam_sekarang < $setting->mulai_absen_pulang) {
            return false; // Belum waktunya pulang
        }

        $data = array(
            'jam_pulang' => $jam_sekarang
        );

        // Tambah keterangan jika pulang awal
        if ($jam_sekarang < $setting->jam_pulang) {
            $absensi = $this->get_absensi_hari_ini($nik);
            $keterangan_lama = $absensi->keterangan;
            $tambahan = 'Pulang awal';
            $data['keterangan'] = $keterangan_lama ? $keterangan_lama . ' | ' . $tambahan : $tambahan;
        }

        $this->db->where('nik', $nik);
        $this->db->where('tanggal', date('Y-m-d'));
        return $this->db->update('absensi_harian', $data);
    }

    /**
     * Riwayat absensi pegawai per bulan
     */
    public function get_absensi_bulan($nik, $bulan, $tahun)
    {
        $this->db->where('nik', $nik);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('absensi_harian')->result();
    }

    // =====================================================
    // Absensi Harian — Admin Monitoring
    // =====================================================

    /**
     * Ambil semua absensi hari ini (monitoring)
     */
    public function get_semua_absensi_hari_ini()
    {
        $this->db->select('data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jabatan, data_pegawai.photo, absensi_harian.jam_masuk, absensi_harian.jam_pulang, absensi_harian.status, absensi_harian.keterangan');
        $this->db->from('data_pegawai');
        $this->db->join('absensi_harian', 'absensi_harian.nik = data_pegawai.nik AND absensi_harian.tanggal = "' . date('Y-m-d') . '"', 'left');
        $this->db->order_by('data_pegawai.nama_pegawai', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Rekap bulanan semua pegawai
     */
    public function get_rekap_bulanan($bulan, $tahun)
    {
        $pegawai_list = $this->db->get('data_pegawai')->result();
        $rekap = array();

        // 1. Hitung Total Hari dalam bulan tersebut (menggunakan date 't' aman dari ekstensi cal_days_in_month)
        $total_hari = date('t', mktime(0, 0, 0, $bulan, 1, $tahun));
        
        // 2. Hitung jumlah hari Minggu (Libur) dalam bulan tersebut
        $jumlah_minggu = 0;
        for ($i = 1; $i <= $total_hari; $i++) {
            $tanggal = $tahun . '-' . $bulan . '-' . sprintf('%02d', $i);
            if (date('N', strtotime($tanggal)) == 7) { // 7 = Minggu
                $jumlah_minggu++;
            }
        }

        // 2b. Ambil Hari Libur Nasional di bulan tersebut yang BUKAN hari Minggu
        $libur_nasional = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'")->result();
        $jumlah_libur_nasional = 0;
        foreach($libur_nasional as $ln) {
            // Jika jatuhnya bukan hari Minggu, maka tambah pengurang hari wajib
            if (date('N', strtotime($ln->tanggal)) != 7) {
                $jumlah_libur_nasional++;
            }
        }
        
        // 3. Total Hari Kerja Wajib dalam Sebulan (Dikurangi Minggu & Libur Nasional)
        $hari_kerja_wajib = $total_hari - $jumlah_minggu - $jumlah_libur_nasional;

        foreach ($pegawai_list as $p) {
            $this->db->where('nik', $p->nik);
            $this->db->where('MONTH(tanggal)', $bulan);
            $this->db->where('YEAR(tanggal)', $tahun);
            $absensi = $this->db->get('absensi_harian')->result();

            $hadir = 0;
            $terlambat = 0;
            $sakit = 0;
            $izin = 0;

            foreach ($absensi as $a) {
                switch ($a->status) {
                    case 'tepat_waktu':
                        $hadir++;
                        break;
                    case 'terlambat':
                        $hadir++;
                        $terlambat++;
                        break;
                    case 'sakit':
                        $sakit++;
                        break;
                    case 'izin':
                        $izin++;
                        break;
                    // Abaikan status alpha dari database jika ada, karena kita hitung secara matematis
                }
            }

            // 4. Hitung Alpha Pintar (Hari Kerja Wajib - Hari Masuk/Izin/Sakit)
            $total_kehadiran_sah = $hadir + $sakit + $izin;
            $alpha_hari_kosong = $hari_kerja_wajib - $total_kehadiran_sah;
            
            // Antisipasi bug jika pegawai masuk di hari minggu (overtime) sehingga total sah lebih besar dari hari wajib
            if ($alpha_hari_kosong < 0) {
                $alpha_hari_kosong = 0;
            }

            // Hitung terlambat yang jadi alpha tambahan
            $setting = $this->get_setting();
            $alpha_dari_terlambat = floor($terlambat / $setting->maks_terlambat_jadi_alpha);

            $rekap[] = array(
                'nik'                  => $p->nik,
                'nama_pegawai'         => $p->nama_pegawai,
                'jabatan'              => $p->jabatan,
                'jenis_kelamin'        => $p->jenis_kelamin,
                'hadir'                => $hadir,
                'terlambat'            => $terlambat,
                'sakit'                => $sakit,
                'izin'                 => $izin,
                'alpha'                => $alpha_hari_kosong,
                'alpha_dari_terlambat' => $alpha_dari_terlambat,
                'total_alpha'          => $alpha_hari_kosong + $alpha_dari_terlambat
            );
        }

        return $rekap;
    }

    /**
     * Sinkronisasi data absensi harian ke tabel data_kehadiran (untuk kompatibilitas gaji)
     */
    public function sinkron_ke_kehadiran($bulan, $tahun)
    {
        $rekap = $this->get_rekap_bulanan($bulan, $tahun);
        $bulantahun = str_pad($bulan, 2, '0', STR_PAD_LEFT) . $tahun;

        foreach ($rekap as $r) {
            // Cek apakah sudah ada data di data_kehadiran
            $existing = $this->db->get_where('data_kehadiran', array(
                'nik'   => $r['nik'],
                'bulan' => $bulantahun
            ))->row();

            // Ambil data pegawai lengkap
            $pegawai = $this->db->get_where('data_pegawai', array('nik' => $r['nik']))->row();

            $data_kehadiran = array(
                'bulan'          => $bulantahun,
                'nik'            => $r['nik'],
                'nama_pegawai'   => $r['nama_pegawai'],
                'jenis_kelamin'  => $r['jenis_kelamin'],
                'nama_jabatan'   => $pegawai ? $pegawai->jabatan : '',
                'hadir'          => $r['hadir'],
                'sakit'          => $r['sakit'],
                'alpha'          => $r['total_alpha']
            );

            if ($existing) {
                $this->db->where('id_kehadiran', $existing->id_kehadiran);
                $this->db->update('data_kehadiran', $data_kehadiran);
            } else {
                $this->db->insert('data_kehadiran', $data_kehadiran);
            }
        }

        return true;
    }

    /**
     * Detail absensi harian 1 pegawai per bulan (untuk admin)
     */
    public function get_detail_pegawai($nik, $bulan, $tahun)
    {
        $this->db->select('absensi_harian.*, data_pegawai.nama_pegawai, data_pegawai.jabatan');
        $this->db->from('absensi_harian');
        $this->db->join('data_pegawai', 'data_pegawai.nik = absensi_harian.nik');
        $this->db->where('absensi_harian.nik', $nik);
        $this->db->where('MONTH(absensi_harian.tanggal)', $bulan);
        $this->db->where('YEAR(absensi_harian.tanggal)', $tahun);
        $this->db->order_by('absensi_harian.tanggal', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Update status absensi oleh admin (misal: set sakit/izin)
     */
    public function update_status($id, $status, $keterangan = '')
    {
        $data = array('status' => $status);
        if ($keterangan) {
            $data['keterangan'] = $keterangan;
        }
        $this->db->where('id', $id);
        return $this->db->update('absensi_harian', $data);
    }

    /**
     * Hitung ringkasan bulan ini untuk dashboard pegawai
     */
    public function get_ringkasan_bulan_ini($nik)
    {
        $bulan = date('m');
        $tahun = date('Y');

        $this->db->where('nik', $nik);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $data = $this->db->get('absensi_harian')->result();

        $ringkasan = array(
            'hadir'     => 0,
            'terlambat' => 0,
            'sakit'     => 0,
            'alpha'     => 0,
            'izin'      => 0
        );

        foreach ($data as $d) {
            switch ($d->status) {
                case 'tepat_waktu':
                    $ringkasan['hadir']++;
                    break;
                case 'terlambat':
                    $ringkasan['hadir']++;
                    $ringkasan['terlambat']++;
                    break;
                case 'sakit':
                    $ringkasan['sakit']++;
                    break;
                case 'alpha':
                    $ringkasan['alpha']++;
                    break;
                case 'izin':
                    $ringkasan['izin']++;
                    break;
            }
        }

        return $ringkasan;
    }
}
