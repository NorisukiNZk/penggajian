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

        $cur_year = (int)date('Y');
        $cur_month = (int)date('n');
        $req_year = (int)$tahun;
        $req_month = (int)$bulan;

        $is_future = ($req_year > $cur_year) || ($req_year == $cur_year && $req_month > $cur_month);
        $is_current_month = ($req_year == $cur_year && $req_month == $cur_month);

        // 1. Hitung Batas Hari dalam bulan tersebut
        $total_hari_bulan = (int)date('t', mktime(0, 0, 0, $req_month, 1, $req_year));
        
        if ($is_future) {
            $hari_evaluasi = 0; // Periode masa depan belum berjalan
        } elseif ($is_current_month) {
            $hari_evaluasi = min($total_hari_bulan, (int)date('j')); // Hanya evaluasi hingga hari ini
        } else {
            $hari_evaluasi = $total_hari_bulan; // Sebulan penuh untuk bulan yang telah lampau
        }

        // Ambil Hari Libur Nasional di bulan & tahun tersebut
        $libur_nasional = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?", array($req_month, $req_year))->result();

        // Ambil pengaturan batas toleransi keterlambatan
        $setting = $this->get_setting();
        $maks_terlambat = (!empty($setting->maks_terlambat_jadi_alpha) && (int)$setting->maks_terlambat_jadi_alpha > 0) ? (int)$setting->maks_terlambat_jadi_alpha : 3;

        foreach ($pegawai_list as $p) {
            // Hitung hari kerja wajib yang telah berjalan khusus untuk pegawai ini (memperhatikan tanggal_masuk)
            $hari_kerja_wajib = 0;
            if ($hari_evaluasi > 0) {
                for ($i = 1; $i <= $hari_evaluasi; $i++) {
                    $tanggal = sprintf('%04d-%02d-%02d', $req_year, $req_month, $i);

                    // Jangan bebankan hari sebelum tanggal pegawai resmi mulai bekerja
                    if (!empty($p->tanggal_masuk) && $p->tanggal_masuk != '0000-00-00' && $tanggal < $p->tanggal_masuk) {
                        continue;
                    }

                    // Abaikan hari Minggu
                    if (date('N', strtotime($tanggal)) == 7) {
                        continue;
                    }

                    // Abaikan Hari Libur Nasional
                    $is_libur = false;
                    foreach ($libur_nasional as $ln) {
                        if ($ln->tanggal == $tanggal) {
                            $is_libur = true;
                            break;
                        }
                    }
                    if ($is_libur) {
                        continue;
                    }

                    $hari_kerja_wajib++;
                }
            }

            $this->db->where('nik', $p->nik);
            $this->db->where('MONTH(tanggal)', $req_month);
            $this->db->where('YEAR(tanggal)', $req_year);
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
                }
            }

            // Hitung Alpha Pintar (Hari Kerja Wajib yang sudah lewat - Kehadiran Sah)
            $total_kehadiran_sah = $hadir + $sakit + $izin;
            $alpha_hari_kosong = max(0, $hari_kerja_wajib - $total_kehadiran_sah);

            // Hitung terlambat yang dikonversi jadi penalti alpha
            $alpha_dari_terlambat = floor($terlambat / $maks_terlambat);

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

        // Gunakan fungsi rekap bulanan yang sudah pintar (menghitung alpha secara matematis)
        $semua_rekap = $this->get_rekap_bulanan($bulan, $tahun);
        
        $ringkasan = array(
            'hadir'     => 0,
            'terlambat' => 0,
            'sakit'     => 0,
            'alpha'     => 0,
            'izin'      => 0
        );

        // Cari data pegawai yang bersangkutan
        foreach ($semua_rekap as $rekap) {
            if ($rekap['nik'] == $nik) {
                $ringkasan['hadir']     = $rekap['hadir'];
                $ringkasan['terlambat'] = $rekap['terlambat'];
                $ringkasan['sakit']     = $rekap['sakit'];
                $ringkasan['alpha']     = $rekap['total_alpha'];
                $ringkasan['izin']      = $rekap['izin'];
                break;
            }
        }

        return $ringkasan;
    }
}
