<?php

if (!function_exists('testHelper')) {

    /**
     * 測試helper function 是否能啟用
     *
     * @return string
     */
    function testHelper()
    {
        return 'ok';
    }
}

if (!function_exists('adminLoginInfo')) {

    function adminLoginInfo()
    {
        if (!Auth::check()) {
            return [];
        }

        return Auth::user();
    }
}