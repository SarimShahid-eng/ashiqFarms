<?php

if (!function_exists('get_full_time')) {
    function get_full_time($date, $format = 'd, M Y @ h:i A')
    {
        $new_date = new \DateTime($date);
        return $new_date->format($format);
    }
}

if (!function_exists('get_complete_time')) {
    function get_complete_time($date)
    {
        return get_full_time($date) . ' ' . config('app.timezone_name');
    }
}

if (!function_exists('get_date')) {
    function get_date($date)
    {
        return get_full_time($date, 'd, M Y');
    }
}

if (!function_exists('get_price')) {
    function get_price($price, $symbol = null)
    {
        return  number_format($price);
    }
}

if (!function_exists('get_weight')) {
    function get_weight($weight)
    {
        return number_format($weight).' lbs';
    }
}

if (!function_exists("newCount")) {

    function newCount($array)
    {
        if (is_array($array) || is_object($array)) {
            return count($array);
        } else {
            return 0;
        }
    }
}

if (!function_exists('dummy_image')) {
    function dummy_image($type = null)
    {
        switch ($type) {
            case 'categories':
                return asset('admin_assets/images/category_dummy.jpg');
            case 'user':
                return asset('assets/img/dummy_user.png');
            case 'blog':
                return asset('frontend_assets/images/dummy_blog.jpg');
            case 'shipment':
                return asset('frontend_assets/images/shipment_not_image_not_found.png');
            default:
                return asset('assets/img/dummy_user.png');
        }
    }
}

if (!function_exists('check_file')) {
    function check_file($file = null, $type = null)
    {
        if ($file && $file != '' && file_exists($file)) {
            return asset($file);
        } else {
            return dummy_image($type);
        }
    }
}

if (!function_exists('dateTimeInterval')) {
    function dateTimeInterval($start, $end, $asArray = false, $format = 'Y-m-d', $interval = '1 day',  $arr_format = null, $separator = '|')
    {
        $begin = new DateTime($start);
        $end = new DateTime($end);
        if ($arr_format == null) {
            $arr_format = $format;
        }
        $data = array();
        for ($dt = $begin; $dt <= $end; $dt->modify($interval)) {
            $data[$dt->format($arr_format)] = (string) $dt->format($format);
        }
        if ($asArray) {
            return $data;
        } else {
            return implode($separator, $data);
        }
    }
}

if (!function_exists('hashids_encode')) {
    function hashids_encode($str)
    {
        return \Hashids::encode($str);
    }
}

if (!function_exists('hashids_decode')) {
    function hashids_decode($str)
    {
        try {
            return \Hashids::decode($str)[0];
        } catch (Exception $e) {
            return abort(404);
        }
    }
}

if (!function_exists('notification_colors')) {
    function notification_colors($ind)
    {
        $arr = array(
            'default' => ['color' => 'bg-primary', 'icon' => 'fa fa-bell'],
            'violation_resolved' => ['color' => 'bg-success', 'icon' => 'mdi mdi-check'],
            'violation_complain' => ['color' => 'bg-danger', 'icon' => 'fa fa-user'],
        );

        return $arr[$ind] ?? $arr['default'];
    }
}

if (!function_exists('checkCheckedState')) {
    function checkCheckedState($needle, $haystack)
    {
        if (!is_array($haystack)) return;
        return in_array($needle, $haystack) ? 'checked' : '';
    }
}

if (!function_exists('shipment_status')) {
    function shipment_status($status, $all = false)
    {
        $arr = array(
            "pending" => "warning",
            "delivered" => "success",
            "booked" => "info",
            "in_transit" => "warning",
            "picked_up" => "dark",
            "cancelled" => "danger",
            "expired" => "danger",
            "cancellation_in_process" => "danger"
        );
        if($all){
            return array_keys($arr);
        }
        return $arr[$status] ?? 'info';
    }
}

if (!function_exists('get_invoice_status')) {
    function get_invoice_status($status, $all = false)
    {
        $arr = array(
            "paid" => "success",
            "declined" => "danger",
            "refunded" => "primary",
            "pending" => "warning",
        );
        if ($all) {
            return array_keys($arr);
        }
        return $arr[$status] ?? 'pending';
    }
}

if (!function_exists("getLnt")) {

    function getLnt($zip)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($zip) . "&sensor=false&key=AIzaSyC6rO10Gjru-B5FwMey5ikSFnK_eV5SFQk";
        // echo  $url;
        // exit;
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        return $result['results'][0];
    }
}


if (!function_exists("get_accessorial_new")) {
    function get_accessorial_new($f)
    {
        $arr = [];
        $arr = array(
            'RESPU'  => 'Residential Pickup',
            'RESDEL' => 'Residential Delivery',
            'AIRPU'  => 'Airport Pickup',
            'AIRDEL' => 'Airport Delivery',
            'CFSPU'  => 'Container Freight Station Pickup',
            'CFSDEL' => 'Container Freight Station Delivery',
            'CONPU'  => 'Construction Site Pickup',
            'CONDEL' => 'Construction Site Delivery',
            'CNVPU'  => 'Trade Show Pickup',
            'CNVDEL' => 'Trade Show Delivery',
            'LTDPU'  => 'Limited Access Pickup',
            'LTDDEL' => 'Limited Access Delivery',
            'EDUPU'  => 'School Pickup',
            'EDUDEL' => 'School Delivery',
            'FARMDEL' => 'Farm Delivery',
            'FARMPU' => 'Farm Pickup ',
            'GOVDEL' => 'Government Site Delivery',
            'GOVPU' => 'Government Site Pickup',
            'HOTLPU' => 'Hotel Pickup',
            'HOTLDEL' => 'Hotel Delivery',
            'CHRCPU' => 'Church Pickup',
            'CHRCDEL' => 'Church Delivery',
            'LGDEL' => 'Liftgate at Delivery',
            'LGPU' => 'Liftgate Pickup',
            // 'HAZM' => 'Hazardous Material',

        );

        return ($arr[$f]) ??  '';
    }
}


if (!function_exists("get_booking_fee")) {

    function get_booking_fee($amount)
    {

        $amount_percent  = $amount * 0.16;

        if ($amount_percent < 35) {
            $amount  =  36;
        } else {

            $amount  = $amount_percent;
        }
        $f = get_discount();
        if (isset($f['percentage'])) {
            $f  = $f['percentage'] / 100;
            $f  = $amount * $f;
        } else {
            $f  = $f['flat'];
        };
        return ['book_fee' => $amount, 'discount' => $f];
    }
}
if (!function_exists("get_discount")) {
    function get_discount($type = 'percentage', $value = 50)
    {
        return [$type => $value];
    }
}

if (!function_exists("get_Insurance")) {
    function get_Insurance($value = 12000)
    {
        if ($value == 12000 || $value < 12000) {
            return 35;
        }
        $diff = $value - 12000;
        $total = 0;
        for ($i = 0; $i < $diff; $i += 1000) {
            $total++;
        }
        return  35 + ($total * (3));
    }
}

if (!function_exists("get_profit")) {
    function get_credit_card_fee($f)
    {
        $f = $f * 0.03;
        return $f;
    }
}
if (!function_exists("get_premium_service")) {
    function get_premium_service()
    {
        return 32;
    }
}


if (!function_exists('get_pay_method')) {
    function get_pay_method($status)
    {
        $arr = array(
            "cash" => "Cash",
            "credit_card" => "Credit Card",
            "check" => "Check",
            "paypal" => "PayPal",
            "money_transfer" => "Wire Transfer"
        );

        return $arr[$status] ?? 'info';
    }
}
if (!function_exists("check_lowest_quote")) {
    function check_lowest_quote($lowest_quote, $new_quote)
    {
        if ($lowest_quote < 1) {
            return ['status' => 'true'];
        }

        $difference = 50;
        if ($new_quote < 25) {
            $difference = -2;
        } else if ($new_quote >= 25 && $new_quote < 250) {
            $difference = -5;
        } else if ($new_quote >= 250 && $new_quote < 500) {
            $difference = -10;
        } else if ($new_quote >= 500 && $new_quote < 1500) {
            $difference = -15;
        } else if ($new_quote >= 1500 && $new_quote < 2500) {
            $difference = -35;
        }
        $quote_diff = $new_quote - $lowest_quote;
        if ($quote_diff < 1 && $difference < $quote_diff) {
            return ['status' => 'false', 'difference' => abs($difference)];
        }
        return ['status' => 'true'];
    }
}

if (!function_exists("count_no_of_allowed_quotes")) {
    function count_no_of_allowed_quotes($quote)
    {
        $allowed = 5;
        if ($quote > 0 && $quote < 500) {
            $allowed = 3;
        } else if ($quote >= 500 && $quote < 2500) {
            $allowed = 4;
        }
        return $allowed;
    }
}

function get_miles_from_km($km){
    return number_format($km * 0.621371, 2). " Miles";
}




function get_shipping_class($length, $width, $height, $weightlbs, $qty, $unit) {
     $v = ($length * ($width * $height));
     $TotalWeight_loop = (abs($weightlbs)) * $qty;
     $TotalVolume_loop = ($unit == 'in') ? ($v / 1728) * $qty : $v * $qty; //12in * 12in * 12in = 1728 cu.in
     $TotalDensity_loop = $TotalWeight_loop / $TotalVolume_loop;
    return shipping_class($TotalDensity_loop);

}

function shipping_class($TotalDensity) {
     $ClassVal = 0;
     $TD = $TotalDensity;
     $TD = floor($TD);
    if ($TD < 1) {
        $ClassVal = 400;
    }
    if (($TD >= 1) && ($TD < 2)) {
        $ClassVal = 300;
    }
    if (($TD >= 2) && ($TD < 4)) {
        $ClassVal = 250;
    }
    if (($TD >= 4) && ($TD < 6)) {
        $ClassVal = 175;
    }
    if (($TD >= 6) && ($TD < 8)) {
        $ClassVal = 125;
    }
    if (($TD >= 8) && ($TD < 10)) {
        $ClassVal = 100;

    }
    if (($TD >= 10) && ($TD < 12)) {
        $ClassVal = 92.5;
    }
    if (($TD >= 12) && ($TD < 15)) {
        $ClassVal = 85;

    }
    if (($TD >= 15) && ($TD < 22.5)) {
        $ClassVal = 70;
    }
    if (($TD >= 22.5) && ($TD < 30)) {
        $ClassVal = 65;
    }
    if (($TD >= 30)) {
        $ClassVal = 60;
    }
    return "$ClassVal";
}

if(!function_exists('ordinal')){
    function ordinal($number){
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number . 'th';
        else
            return ($number) ? $number . $ends[$number % 10] : $number;
    }
}


if (!function_exists('containsOnlyNull')) {
    function containsOnlyNull($input)
    {
       return empty(array_filter($input, function ($a) { return $a !== null;}));
    }


}
if (!function_exists('clean')) {


function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 }
}

