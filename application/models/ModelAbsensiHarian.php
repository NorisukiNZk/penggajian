<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelAbsensiHarian extends CI_Model
{
    // =====================================================
    // Setting Absensi & Evaluasi Hari Libur
    // =====================================================

    public function get_setting()
    {
        $row = $this->db->get_where('setting_absensi', array('id' => 1))->row();
        if ($row && !isset($row->hari_libur_mingguan)) {
            $row->hari_libur_mingguan = '6,7';
        }
        return $row;
    }

    public function update_setting($data)
    {
        if (isset($data['hari_libur_mingguan']) && !$this->db->field_exists('hari_libur_mingguan', 'setting_absensi')) {
            unset($data['hari_libur_mingguan']);
        }
        $this->db->where('id', 1);
        return $this->db->update('setting_absensi', $data);
    }

    public function get_lembur_disetujui_tanggal($nik, $tanggal = null)
    {
        if (empty($nik)) {
            return null;
        }
        $tgl = $tanggal ? $tanggal : date('Y-m-d');
        return $this->db
            ->where('nik', $nik)
            ->where('tanggal_lembur', $tgl)
            ->where('status', 'Disetujui')
            ->order_by('jam_mulai', 'ASC')
            ->get('data_lembur')
            ->row();
    }

    public function cek_hari_libur($tanggal = null)
    {
        $tgl = $tanggal ? $tanggal : date('Y-m-d');
        $setting = $this->get_setting();
        $holidayRow = $this->db->get_where('hari_libur', array('tanggal' => $tgl))->row();
        return Attendance_policy::evaluateHoliday($tgl, $setting, $holidayRow);
    }

    public function get_status_hari_ini($nik = null, $tanggal = null, $jamSekarang = null)
    {
        $tgl = $tanggal ? $tanggal : date('Y-m-d');
        $jam = $jamSekarang ? $jamSekarang : date('H:i:s');
        $setting = $this->get_setting();
        $holidayRow = $this->db->get_where('hari_libur', array('tanggal' => $tgl))->row();
        $approvedOvertime = $nik ? $this->get_lembur_disetujui_tanggal($nik, $tgl) : null;

        return Attendance_policy::evaluateAttendanceGate($tgl, $jam, $setting, $holidayRow, $approvedOvertime);
    }

    // =====================================================
    // Absensi Harian - Pegawai
    // =====================================================

    public function get_absensi_hari_ini($nik)
    {
        return $this->db->get_where('absensi_harian', array(
            'nik' => $nik,
            'tanggal' => date('Y-m-d')
        ))->row();
    }

    public function absen_masuk($nik)
    {
        $setting = $this->get_setting();
        $tanggal = date('Y-m-d');
        $jam_sekarang = date('H:i:s');
        $gate = $this->get_status_hari_ini($nik, $tanggal, $jam_sekarang);

        // Proteksi Hari Libur & Gerbang Waktu (Backend)
        if (!$gate['boleh_absen_masuk']) {
            return false;
        }

        if ($gate['mode_lembur_libur']) {
            $ot = $gate['lembur'];
            $status = 'tepat_waktu';
            $keterangan = 'Lembur ' . $gate['keterangan_libur'] . ' (' . substr($ot['jam_mulai'], 0, 5) . ' - ' . substr($ot['jam_selesai'], 0, 5) . ')';
        } else {
            $jam_masuk_setting = $setting->jam_masuk;
            $toleransi = (int)$setting->toleransi_menit;
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
                $selisih = (strtotime($jam_sekarang) - strtotime($batas_toleransi)) / 60;
                $keterangan = 'Terlambat ' . ceil($selisih) . ' menit';
            }
        }

        $data = array(
            'nik'        => $nik,
            'tanggal'    => $tanggal,
            'jam_masuk'  => $jam_sekarang,
            'status'     => $status,
            'keterangan' => $keterangan
        );

        return $this->db->insert('absensi_harian', $data);
    }

    public function absen_pulang($nik)
    {
        $setting = $this->get_setting();
        $tanggal = date('Y-m-d');
        $jam_sekarang = date('H:i:s');
        $gate = $this->get_status_hari_ini($nik, $tanggal, $jam_sekarang);

        // Proteksi Hari Libur & Gerbang Waktu (Backend)
        if (!$gate['boleh_absen_pulang']) {
            return false;
        }

        $data = array(
            'jam_pulang' => $jam_sekarang
        );

        // Tambah keterangan jika pulang awal (hanya pada hari kerja normal)
        if (!$gate['mode_lembur_libur'] && $jam_sekarang < $setting->jam_pulang) {
            $absensi = $this->get_absensi_hari_ini($nik);
            $keterangan_lama = $absensi ? $absensi->keterangan : '';
            $tambahan = 'Pulang awal';
            $data['keterangan'] = $keterangan_lama ? $keterangan_lama . ' | ' . $tambahan : $tambahan;
        }

        $this->db->where('nik', $nik);
        $this->db->where('tanggal', $tanggal);
        return $this->db->update('absensi_harian', $data);
    }

    public function get_absensi_bulan($nik, $bulan, $tahun)
    {
        $this->db->where('nik', $nik);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('absensi_harian')->result();
    }

    // =====================================================
    // Absensi Harian - Admin Monitoring & Rekap
    // =====================================================

    public function get_semua_absensi_hari_ini()
    {
        $this->db->select('data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jabatan, data_pegawai.photo, absensi_harian.jam_masuk, absensi_harian.jam_pulang, absensi_harian.status, absensi_harian.keterangan');
        $this->db->from('data_pegawai');
        $this->db->join('absensi_harian', 'absensi_harian.nik = data_pegawai.nik AND absensi_harian.tanggal = "' . date('Y-m-d') . '"', 'left');
        $this->db->order_by('data_pegawai.nama_pegawai', 'ASC');
        return $this->db->get()->result();
    }

    public function get_rekap_bulanan($bulan, $tahun, $filter_nik = null)
    {
        if ($filter_nik !== null) {
            $this->db->where('nik', $filter_nik);
        }
        $pegawai_list = $this->db->get('data_pegawai')->result();
        $rekap = array();

        if (empty($pegawai_list)) {
            return $rekap;
        }

        $cur_year = (int)date('Y');
        $cur_month = (int)date('n');
        $req_year = (int)$tahun;
        $req_month = (int)$bulan;

        $is_future = ($req_year > $cur_year) || ($req_year == $cur_year && $req_month > $cur_month);
        $is_current_month = ($req_year == $cur_year && $req_month == $cur_month);

        $total_hari_bulan = (int)date('t', mktime(0, 0, 0, $req_month, 1, $req_year));

        if ($is_future) {
            $hari_evaluasi = 0;
        } elseif ($is_current_month) {
            $hari_evaluasi = min($total_hari_bulan, (int)date('j'));
        } else {
            $hari_evaluasi = $total_hari_bulan;
        }

        $libur_rows = $this->db->query("SELECT tanggal FROM hari_libur WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?", array($req_month, $req_year))->result();
        $libur_set = array();
        foreach ($libur_rows as $lr) {
            $libur_set[$lr->tanggal] = true;
        }

        $this->db->where('MONTH(tanggal)', $req_month);
        $this->db->where('YEAR(tanggal)', $req_year);
        if ($filter_nik !== null) {
            $this->db->where('nik', $filter_nik);
        }
        $absensi_rows = $this->db->get('absensi_harian')->result();
        $absensi_by_nik = array();
        foreach ($absensi_rows as $ar) {
            $absensi_by_nik[$ar->nik][] = $ar;
        }

        $setting = $this->get_setting();
        $weekend_days = Attendance_policy::parseWeekendDays($setting);
        $maks_terlambat = (!empty($setting->maks_terlambat_jadi_alpha) && (int)$setting->maks_terlambat_jadi_alpha > 0) ? (int)$setting->maks_terlambat_jadi_alpha : 3;

        foreach ($pegawai_list as $p) {
            $hari_kerja_map = array();
            if ($hari_evaluasi > 0) {
                for ($i = 1; $i <= $hari_evaluasi; $i++) {
                    $tanggal = sprintf('%04d-%02d-%02d', $req_year, $req_month, $i);

                    if (!empty($p->tanggal_masuk) && $p->tanggal_masuk != '0000-00-00' && $tanggal < $p->tanggal_masuk) {
                        continue;
                    }
                    if (in_array((int)date('N', strtotime($tanggal)), $weekend_days, true)) {
                        continue;
                    }
                    if (isset($libur_set[$tanggal])) {
                        continue;
                    }
                    $hari_kerja_map[$tanggal] = true;
                }
            }
            $hari_kerja_wajib = count($hari_kerja_map);

            $absensi = isset($absensi_by_nik[$p->nik]) ? $absensi_by_nik[$p->nik] : array();

            $hadir = 0;
            $terlambat = 0;
            $sakit = 0;
            $izin = 0;
            $kehadiran_pada_hari_kerja = 0;

            foreach ($absensi as $a) {
                $pada_hari_kerja = isset($hari_kerja_map[$a->tanggal]);
                switch ($a->status) {
                    case 'tepat_waktu':
                        $hadir++;
                        if ($pada_hari_kerja) $kehadiran_pada_hari_kerja++;
                        break;
                    case 'terlambat':
                        $hadir++;
                        $terlambat++;
                        if ($pada_hari_kerja) $kehadiran_pada_hari_kerja++;
                        break;
                    case 'sakit':
                        $sakit++;
                        if ($pada_hari_kerja) $kehadiran_pada_hari_kerja++;
                        break;
                    case 'izin':
                        $izin++;
                        if ($pada_hari_kerja) $kehadiran_pada_hari_kerja++;
                        break;
                }
            }

            $alpha_hari_kosong = max(0, $hari_kerja_wajib - $kehadiran_pada_hari_kerja);
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

    public function get_statistik_hari_kerja($bulan, $tahun)
    {
        $req_year = (int)$tahun;
        $req_month = (int)$bulan;
        $cur_year = (int)date('Y');
        $cur_month = (int)date('n');

        $is_future = ($req_year > $cur_year) || ($req_year == $cur_year && $req_month > $cur_month);
        $is_current_month = ($req_year == $cur_year && $req_month == $cur_month);
        $total_hari_bulan = (int)date('t', mktime(0, 0, 0, $req_month, 1, $req_year));

        if ($is_future) {
            $hari_evaluasi = 0;
        } elseif ($is_current_month) {
            $hari_evaluasi = min($total_hari_bulan, (int)date('j'));
        } else {
            $hari_evaluasi = $total_hari_bulan;
        }

        $setting = $this->get_setting();
        $weekend_days = Attendance_policy::parseWeekendDays($setting);
        $libur_nasional = $this->db->query("SELECT * FROM hari_libur WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?", array($req_month, $req_year))->result();

        $jumlah_akhir_pekan = 0;
        $jumlah_libur = 0;
        $hari_kerja_efektif = 0;

        for ($i = 1; $i <= $total_hari_bulan; $i++) {
            $tanggal = sprintf('%04d-%02d-%02d', $req_year, $req_month, $i);
            if (in_array((int)date('N', strtotime($tanggal)), $weekend_days, true)) {
                $jumlah_akhir_pekan++;
            } else {
                $is_libur = false;
                foreach ($libur_nasional as $ln) {
                    if ($ln->tanggal == $tanggal) {
                        $is_libur = true;
                        break;
                    }
                }
                if ($is_libur) {
                    $jumlah_libur++;
                } else {
                    $hari_kerja_efektif++;
                }
            }
        }

        return array(
            'total_hari'          => $total_hari_bulan,
            'jumlah_minggu'       => $jumlah_akhir_pekan,
            'jumlah_akhir_pekan'  => $jumlah_akhir_pekan,
            'label_akhir_pekan'   => Attendance_policy::formatWeekendLabel($weekend_days),
            'jumlah_libur'        => $jumlah_libur,
            'hari_kerja_efektif'  => $hari_kerja_efektif,
            'hari_evaluasi'       => $hari_evaluasi,
            'is_current_month'    => $is_current_month,
            'is_future'           => $is_future
        );
    }

    public function sinkron_ke_kehadiran($bulan, $tahun)
    {
        $rekap = $this->get_rekap_bulanan($bulan, $tahun);
        $bulantahun = str_pad($bulan, 2, '0', STR_PAD_LEFT) . $tahun;

        foreach ($rekap as $r) {
            $existing = $this->db->get_where('data_kehadiran', array(
                'nik'   => $r['nik'],
                'bulan' => $bulantahun
            ))->row();

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

    public function update_status($id, $status, $keterangan = '')
    {
        $data = array('status' => $status);
        if ($keterangan) {
            $data['keterangan'] = $keterangan;
        }
        $this->db->where('id', $id);
        return $this->db->update('absensi_harian', $data);
    }

    public function get_ringkasan_bulan_ini($nik)
    {
        $bulan = date('m');
        $tahun = date('Y');

        $rekap_pegawai = $this->get_rekap_bulanan($bulan, $tahun, $nik);

        $ringkasan = array(
            'hadir'     => 0,
            'terlambat' => 0,
            'sakit'     => 0,
            'alpha'     => 0,
            'izin'      => 0
        );

        if (!empty($rekap_pegawai)) {
            $r = $rekap_pegawai[0];
            $ringkasan['hadir']     = $r['hadir'];
            $ringkasan['terlambat'] = $r['terlambat'];
            $ringkasan['sakit']     = $r['sakit'];
            $ringkasan['alpha']     = $r['total_alpha'];
            $ringkasan['izin']      = $r['izin'];
        }

        return $ringkasan;
    }
}
