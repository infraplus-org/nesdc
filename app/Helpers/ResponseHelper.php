<?php

if ( ! function_exists('response_success')) 
{
    function response_success($data)
    {
        return [
            'result' => 'success',
            'message' => $data,
            'class' => 'success',
        ];
    }
}

if ( ! function_exists('response_error')) 
{
    function response_error($data)
    {
        return [
            'result' => 'error',
            'message' => $data,
            'class' => 'danger',
        ];
    }
}
