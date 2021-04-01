<?php


namespace App\Utils;


class Helper
{
    public static function dateToThai($date,$is_small=FALSE) {
        if(empty($date)) {
            return '-';
        }
        $date = date('Y-m-d',strtotime($date));
        $splitDateTime = explode(" ",$date);
        $split         = explode("-",$splitDateTime[0]);
        if(count($split)!=3) {
            return '-';
        }
        $day   = $split[2];
        $month = $split[1];
        $year  = $split[0]+543;
        $_m = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
        $m = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
        if($is_small==TRUE) {
            return ((int)$day).' '.$_m[(int)$month].' '.$year;
        }
        return ((int)$day).' '.$m[(int)$month].' '.$year;
    }
}
