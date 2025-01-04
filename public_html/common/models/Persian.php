<?php

namespace common\models;

use Yii;
use common\models\Msg;

/**
 * This is the model class for table "income_outcome".
 *
 * @property integer $id
 * @property string $date
 * @property string $amount
 * @property string $desc
 * @property integer $type_id
 * @property integer $model
 */
class Persian {

    const months = array(
        1 => 'فرودین',
        2 => 'اردیبهشت',
        3 => 'خرداد',
        4 => 'تیر',
        5 => 'مرداد',
        6 => 'شهریور',
        7 => 'مهر',
        8 => 'آبان',
        9 => 'آذر',
        10 => 'دی',
        11 => 'بهمن',
        12 => 'اسفند'
    );

    static function gregorian_to_jalali($gy, $gm, $gd, $mod = '') {
        $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
        $jy = ($gy <= 1600) ? 0 : 979;
        $gy -= ($gy <= 1600) ? 621 : 1600;
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = (365 * $gy) + ((int) (($gy2 + 3) / 4)) - ((int) (($gy2 + 99) / 100)) + ((int) (($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];
        $jy += 33 * ((int) ($days / 12053));
        $days %= 12053;
        $jy += 4 * ((int) ($days / 1461));
        $days %= 1461;
        $jy += (int) (($days - 1) / 365);
        if ($days > 365)
            $days = ($days - 1) % 365;
        $jm = ($days < 186) ? 1 + (int) ($days / 31) : 7 + (int) (($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
        return ($mod == '') ? array($jy, sprintf("%02d", $jm), sprintf("%02d", $jd)) : $jy . $mod . $jm . $mod . $jd;
    }

    static function jalali_to_gregorian($jy, $jm, $jd, $mod = '') {
        $gy = ($jy <= 979) ? 621 : 1600;
        $jy -= ($jy <= 979) ? 0 : 979;
        $days = (365 * $jy) + (((int) ($jy / 33)) * 8) + ((int) ((($jy % 33) + 3) / 4)) + 78 + $jd + (($jm < 7) ? ($jm - 1) * 31 : (($jm - 7) * 30) + 186);
        $gy += 400 * ((int) ($days / 146097));
        $days %= 146097;
        if ($days > 36524) {
            $gy += 100 * ((int) ( --$days / 36524));
            $days %= 36524;
            if ($days >= 365)
                $days++;
        }
        $gy += 4 * ((int) (($days) / 1461));
        $days %= 1461;
        $gy += (int) (($days - 1) / 365);
        if ($days > 365)
            $days = ($days - 1) % 365;
        $gd = $days + 1;
        foreach (array(0, 31, (($gy % 4 == 0 and $gy % 100 != 0) or ( $gy % 400 == 0)) ? 29 : 28
    , 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gm => $v) {
            if ($gd <= $v)
                break;
            $gd -= $v;
        }

        $gm = sprintf("%02d", $gm); // added by kiamoz
        $gd = sprintf("%02d", $gd); // added by kiamoz


        return($mod == '') ? array($gy, $gm, $gd) : $gy . $mod . $gm . $mod . $gd;
    }

    public static function convert_date_to_en($date) {
        
        $date = Persian::persian_digit_replace($date);

        $time = explode(" ", $date)[1];
        $o_dat_array = explode("/", $date);

        $en_date_array = Persian::jalali_to_gregorian($o_dat_array[0], $o_dat_array[1], $o_dat_array[2]);


        return $en_date_array[0] . "-" . $en_date_array[1] . "-" . $en_date_array[2] . " " . $time;
    }

    public static function convert_date_to_fa($date, $show_time = false) {
        $o_dat_array = explode("-", $date);


        $en_date_array = Persian::gregorian_to_jalali($o_dat_array[0], $o_dat_array[1], $o_dat_array[2]);

        if ($show_time) {
            $o_dat_array_time = explode(" ", $date);
            $time = $o_dat_array_time[1];
        }
        return $en_date_array[0] . "/" . $en_date_array[1] . "/" . $en_date_array[2] . " " . $time;
    }

    public static function get_last_day_of_month($month, $year = null) {

        if ($month <= 6) {
            return 31;
        } else {
            if ($year and $month = 12 and Persian::sLeapYear($year))
                return 29;
            return 30;
        }
    }

    public static function get_current_date() {
        return gregorian_to_jalali(date('Y'), date('m'), date('d'));
    }

    public static function persian_digit_replace($str) {
        $fa = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $en = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($fa, $en, $str);
    }

    public static function getPostHumanTime($id) {
        $m = Msg::findOne($id);
        date_default_timezone_set('Asia/Tehran');
        $time = strtotime($m->date);



        return Persian::humanTiming($time);
    }

    public static function humanTiming($time) {

        date_default_timezone_set('Asia/Tehran');
        //echo date('d M Y H:i:s',time());
        //exit();
        //echo time()."---". $time;
        //exit();
        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'سال ',
            2592000 => 'ماه ',
            604800 => 'هفته ',
            86400 => 'روز ',
            3600 => 'ساعت ',
            60 => ' دقیقه',
            1 => 'ثانیه '
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit)
                continue;
            $numberOfUnits = floor($time / $unit);
            return '<i class="fa fa-clock-o" aria-hidden="true"></i> ' . $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? '' : '');
        }
    }

    public static function sLeapYear($year) {
        $ary = array(1, 5, 9, 13, 17, 22, 26, 30);
        $b = $year % 33;
        if (in_array($b, $ary))
            return true;
        return false;
    }

    public static function get_current_month_report($month = null) {



        $this_persin = Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
        // print_r($this_persin)  . " ";
        $start_miladi = Persian::jalali_to_gregorian($this_persin[0], $month, 1);
        
        //echo $this_persin[0]." ". $month ."<br>";
        
        //  echo $this_persin[0]." ". $month ." ".Persian::get_last_day_of_month($month, $this_persin[0])."<br>";
        
        // print_r($start_miladi)  . " ";
        $end_miladi = Persian::jalali_to_gregorian($this_persin[0], $month, Persian::get_last_day_of_month($month, $this_persin[0]));
        //print_r($end_miladi)  . " ";
        $end = $end_miladi[0] . "-" . $end_miladi[1] . "-" . $end_miladi[2];
        $start = $start_miladi[0] . "-" . $start_miladi[1] . "-" . $start_miladi[2];
        //echo "start".$start."end".$end;
        
        return [$start,$end];
        
      //  return $end . " " . $start;
    }

    public static function get_from_beggining_year($month) {


        $this_persin = Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
        // print_r($this_persin)  . " ";
        $start_miladi = Persian::jalali_to_gregorian($this_persin[0], $month, 1);
        // print_r($start_miladi)  . " ";
        $end_miladi = Persian::jalali_to_gregorian($this_persin[0], $month, Persian::get_last_day_of_month($month, $this_persin[0]));
        //print_r($end_miladi)  . " ";
        $end = $end_miladi[0] . "-" . $end_miladi[1] . "-" . $end_miladi[2];
        $start = $start_miladi[0] . "-" . $start_miladi[1] . "-" . $start_miladi[2];
//        echo "start".$start."end".$end;
        return  $start;
    }

    public static function get_current_month_array() {



        $this_persin = Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
        // print_r($this_persin)  . " ";
        $start_miladi = Persian::jalali_to_gregorian($this_persin[0], $this_persin[1], 1);
        // print_r($start_miladi)  . " ";
        $end_miladi = Persian::jalali_to_gregorian($this_persin[0], $this_persin[1], Persian::get_last_day_of_month($this_persin[1], $this_persin[0]));
        //print_r($end_miladi)  . " ";
        $end = $end_miladi[0] . "-" . $end_miladi[1] . "-" . $end_miladi[2];
        $start = $start_miladi[0] . "-" . $start_miladi[1] . "-" . $start_miladi[2];
        //echo "start".$start."end".$end;
        return $end . " " . $start;
    }

    public static function get_current_month() {



        $this_persin = Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
        //print_r($this_persin)  . " ";
        $start_month = $this_persin[0] . "-" . $this_persin[1] . "-" . 1;
        //echo $start_month;
        $start_miladi = Persian::jalali_to_gregorian($this_persin[0], $this_persin[1], 1);
        //print_r($start_miladi)  . " ";
        $end_miladi = Persian::jalali_to_gregorian($this_persin[0], $this_persin[1], Persian::get_last_day_of_month($this_persin[1], $this_persin[0]));


        $start = $start_miladi[0] . "-" . $start_miladi[1] . "-" . $start_miladi[2];

        return $start;
    }

    public static function get_current_year() {



        $this_persin = Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));

        $start_year = $this_persin[0] . "-" . 1 . "-" . 1;


        $start_miladi = Persian::jalali_to_gregorian($this_persin[0], 1, 1);
        $start = $start_miladi[0] . "-" . $start_miladi[1] . "-" . $start_miladi[2];
        return $start;
    }

    public static function get_prev_month_array() {

        $this_persin = Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'));
        $start_miladi = Persian::jalali_to_gregorian($this_persin[0], $this_persin[1] - 1, 1);
        $end_miladi = Persian::jalali_to_gregorian($this_persin[0], $this_persin[1] - 1, Persian::get_last_day_of_month($this_persin[1], $this_persin[0]));

        $end = $end_miladi[0] . "-" . $end_miladi[1] . "-" . $end_miladi[2];
        $start = $start_miladi[0] . "-" . $start_miladi[1] . "-" . $start_miladi[2];
        return $end . " " . $start;
    }

}
