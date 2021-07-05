<?php

if ( ! function_exists('print_array')) 
{
    function print_array($data)
    {
        echo "<pre style=\"z-index: 1000000; background-color: white;\">";
        print_r($data);
        echo "</pre>";
    }
}

if ( ! function_exists('objectToArray')) 
{
    function objectToArray($data)
    {
        return @json_decode(json_encode($data), true);
    }
}

if ( ! function_exists('array_search_value')) 
{
    function array_search_value($data, $search_val, $search_key)
    {
        if (is_array($data))
        {
            // test again
            $colors = array_column($data, 'code');
            $found_key = array_search('blue', $colors);
            return $found_key;
        }
        elseif (is_object($data))
        {
            foreach ($data as $idx => $_data)
            {
                if (isset($_data->{$search_key}) && $_data->{$search_key} == $search_val)
                {
                    return $idx;
                }
            }
        }
    }
}