<?php

if (!function_exists('generateYear')) {
    function generateYear(): string
    {
        $lastYear = idate('Y') - 1;
        $currentYear = date('Y');
        $nextYear = idate('Y') + 1;

        return idate('m') < 4 ? ($lastYear . '-' . $currentYear) : ($currentYear . '-' . $nextYear);
    }
}
