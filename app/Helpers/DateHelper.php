<?php

use Carbon\Carbon;

if ( ! function_exists('FullDateFormat')) 
{
    function FullDateFormat($data)
    {
        // Read config data
        $thai_months = config('custom.data_thai_months');

        // Parse data by Carbon library
        $date = Carbon::parse($data);

        // Defined value
        $day = $date->day;
        $month = $thai_months[$date->month];
        $year = $date->year + 543;
        return $date->format("$day $month $year");
    }
}

if ( ! function_exists('ShortDateFormat')) 
{
    function ShortDateFormat($data = null)
    {
        // Read config data
        $thai_months = config('custom.data_thai_shortmonths');

        // Parse data by Carbon library
        $date = ( ! is_null($data)) ? Carbon::parse($data) : Carbon::now();

        // Defined value
        $day = $date->day;
        $month = $thai_months[$date->month];
        $year = $date->year + 543;
        return $date->format("$day $month $year");
    }
}

if ( ! function_exists('DateFormatDDMMYYYY')) 
{
    function DateFormatDDMMYYYY($data = null)
    {
        // Parse data by Carbon library
        $date = ( ! is_null($data)) ? Carbon::parse($data) : Carbon::now();

        // Defined value
        $day = substr("0" . $date->day, -2);
        $month = substr("0" . $date->month, -2);
        $year = $date->year + 543;
        return $date->format("$day/$month/$year");
    }
}

if ( ! function_exists('DateFormat')) 
{
    function DateFormat($data = null, $format = 'DD/MM/YYYY', $convert_buddhist_year = true)
    {
        // Read config data
        $config_fullmonths = config('custom.data_thai_months');
        $config_shortmonths = config('custom.data_thai_shortmonths');

        // Parse data by Carbon library
        $date = ( ! is_null($data)) ? Carbon::parse($data) : Carbon::now();

        // Defined value
        $day = substr("0" . $date->day, -2);
        $month = substr("0" . $date->month, -2);
        $month_fullname = $config_fullmonths[$date->month];
        $month_shortname = $config_shortmonths[$date->month];
        $year = $date->year + ($convert_buddhist_year === true ? 543 : 0);

        switch ($format)
        {
            case 'DD/MM/YYYY':
                $format_date = "$day/$month/$year";
                break;
            case 'MMM YYYY':
                $format_date = "$month_shortname $year";
                break;
            case 'MMMM YYYY':
                $format_date = "$month_fullname $year";
                break;
            default:
                $format_date = "$day/$month/$year";
                break;
        }

        return $date->format($format_date);
    }
}

if ( ! function_exists('getFullMonthThai')) 
{
    function getFullMonthThai($data)
    {
        $data_thai_months = config('custom.data_thai_months');
        return isset($data_thai_months[$data]) ? $data_thai_months[$data] : $data;
    }
}

if ( ! function_exists('getShortMonthThai')) 
{
    function getShortMonthThai($data)
    {
        $data_thai_months = config('custom.data_thai_shortmonths');
        return isset($data_thai_months[$data]) ? $data_thai_months[$data] : $data;
    }
}

if ( ! function_exists('dateAddDays')) 
{
    function dateAddDays($day)
    {
        return Carbon::now()->addDays($day);
    }
}

if ( ! function_exists('dateAddYears')) 
{
    function dateAddYears($year)
    {
        return Carbon::now()->addYears($year);
    }
}