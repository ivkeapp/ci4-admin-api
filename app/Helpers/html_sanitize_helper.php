<?php

use HTMLPurifier;
use HTMLPurifier_Config;

if (!function_exists('sanitize_html')) {
    function sanitize_html($html)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($html);
    }
}
