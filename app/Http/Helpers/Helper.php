<?php

namespace App\Helpers;
use App\Models\Certificate;
use Carbon\Carbon;

class Helper
{
    public static function IDGenerator($calibration_date = '')
    {
        $initial = 1;
        $certificate_no = "CES/";
        $date = !empty($calibration_date) ? $calibration_date : now();

        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        if ($month < 4) {
            $year = $year - 1;
        }
        $start_date = date('Y-m-d', strtotime(($year) . '-04-01'));
        $end_date = date('Y-m-d', strtotime(($year + 1) . '-03-31'));

        $financial_range = array('start_date' => $start_date, 'end_date' => $end_date);

        $current_year = date('y', strtotime($financial_range['start_date']));
        $next_year = date('y', strtotime($financial_range['end_date']));

        $certificate_year = $current_year . "-" . $next_year;

        $start_date = Carbon::createFromFormat('Y-m-d', trim($financial_range['start_date']))->format('Y-m-d');
        $end_date = Carbon::createFromFormat('Y-m-d', trim($financial_range['end_date']))->format('Y-m-d');

        $max_certificate_no = Certificate::select('certificate_no')->whereBetween('calibration_date',  [$start_date, $end_date])->orderBy('calibration_date', 'desc')->first();

        if (!empty($max_certificate_no)) {
            $max_certificate_no = $max_certificate_no->toArray();
        }

        if (!empty($max_certificate_no) && isset($max_certificate_no['certificate_no'])) {
            $certificate_arr = explode('/', $max_certificate_no['certificate_no']);
            $last_certi_no = (int) rtrim(end($certificate_arr), '"]');
            $last_years = rtrim($certificate_arr[1], '\"');
            $certi_no = ($last_years == $certificate_year) ? $last_certi_no + 1 : $initial;
            $formatted_certificate_no = str_pad($certi_no, 4, '0', STR_PAD_LEFT);
            $certificate_no .= $certificate_year . "/" . $formatted_certificate_no;
        } else {
            $certificate_no .= $certificate_year . "/" . str_pad($initial, 4, '0', STR_PAD_LEFT);
        }

        return $certificate_no;
    }
}
