<?php
if (!function_exists('formatDateTime')) {
    function formatDateTime($date, $time = NULL)
    {
        $date = str_replace('/', '-', $date);
        if (is_null($time)) {
            $date = date('Y-m-d H:i:s', strtotime($date . ' ' . date('H:i:s')));
        } else {
            $date = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
        }

        return $date;
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        $date = str_replace('/', '-', $date);
        $date = date('Y-m-d', strtotime($date));

        return $date;
    }
}

if (!function_exists('formatDate2')) {
    function formatDate2($date)
    {
        $date = str_replace('/', '-', $date);
        $date = date('d-m-Y', strtotime($date));

        return $date;
    }
}

if (!function_exists('revertFormatDate')) {
    function revertFormatDate($date)
    {
        $date = explode("-", $date);
        $converted = $date[2] . "/" . $date[1] . "/" . $date[0];

        return $converted;
    }
}

//untuk mengetahui bulan bulan
if (!function_exists('bulan')) {
    function bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

//format tanggal yyyy-mm-dd
if (!function_exists('tgl_indo')) {
    function tgl_indo($tgl)
    {
        if ($tgl == NULL || $tgl == '0000-00-00 00:00:00') {
            return "-";
        } else {
            $ubah = gmdate($tgl, time() + 60 * 60 * 8);
            $hari = date('Y-m-d', strtotime($ubah));
            $pecah = explode("-", $hari);   //memecah variabel berdasarkan -
            $tanggal = $pecah[2];
            $bulan = bulan($pecah[1]);
            $tahun = $pecah[0];
            return $tanggal . ' ' . $bulan . ' ' . $tahun; //hasil akhir
        }
    }
}

//format tanggal yyyy-mm-dd
if (!function_exists('tgl_dan_jam')) {
    function tgl_dan_jam($tgl)
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $hari = date('Y-m-d', strtotime($ubah));
        $pecah = explode("-", $hari);  //memecah variabel berdasarkan -
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun . " pukul " . date('H:i:s', strtotime($ubah)); //hasil akhir
    }
}

//format tanggal timestamp
if (!function_exists('tgl_indo_timestamp')) {

    function tgl_indo_timestamp($tgl)
    {
        $inttime = date('Y-m-d H:i:s', $tgl); //mengubah format menjadi tanggal biasa
        $tglBaru = explode(" ", $inttime); //memecah berdasarkan spaasi

        $tglBaru1 = $tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
        $tglBaru2 = $tglBaru[1]; //mendapatkan fotmat hh:ii:ss
        $tglBarua = explode("-", $tglBaru1); //lalu memecah variabel berdasarkan -

        $tgl = $tglBarua[2];
        $bln = $tglBarua[1];
        $thn = $tglBarua[0];

        $bln = bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
        $ubahTanggal = "$tgl $bln $thn | $tglBaru2 "; //hasil akhir tanggal

        return $ubahTanggal;
    }
}

if (!function_exists('hari')) {
    function hari($no_hari)
    {
        switch ($no_hari) {
            case '0':
                $hari = 'Minggu';
                break;
            case '1':
                $hari = 'Senin';
                break;
            case '2':
                $hari = 'Selasa';
                break;
            case '3':
                $hari = 'Rabu';
                break;
            case '4':
                $hari = 'Kamis';
                break;
            case '5':
                $hari = 'Jumat';
                break;
            case '6':
                $hari = 'Sabtu';
                break;
            default:
                $hari = 'Salah Format';
                break;
        }

        return $hari;
    }
}

if (!function_exists('bataswaktu')) {
    function bataswaktu()
    {
        $b = time();
        $hour = date("G", $b);
        $waktu = '';

        if ($hour >= 4 && $hour <= 10) {
            $waktu =  "Pagi";
        } elseif ($hour >= 11 && $hour <= 14) {
            $waktu =  "Siang";
        } elseif ($hour >= 15 && $hour <= 18) {
            $waktu =  "Sore";
        } elseif ($hour >= 19 || $hour <= 3) {
            $waktu =  "Malam";
        }

        return $waktu;
    }
}

if (!function_exists('salam')) {
    function salam()
    {
        $waktu = bataswaktu();
        $user = Auth::user()->user_nm;
        $salam = "Selamat " . $waktu . " , " . $user . " !";

        return $salam;
    }
}

if (!function_exists('date_id')) {
    function date_id($date)
    {
        $translate = [
            'April'     => 'April',
            'August'    => 'Agustus',
            'December'  => 'Desember',
            'February'  => 'Februari',
            'Friday'    => 'Jumat',
            'January'   => 'Januari',
            'July'      => 'Juli',
            'June'      => 'Juni',
            'March'     => 'Maret',
            'May'       => 'Mei',
            'Monday'    => 'Senin',
            'November'  => 'November',
            'October'   => 'Oktober',
            'Saturday'  => 'Sabtu',
            'September' => 'September',
            'Sunday'    => 'Minggu',
            'Thursday'  => 'Kamis',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
        ];

        return strtr($date, $translate);
    }
}
