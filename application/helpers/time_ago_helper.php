<?php

if(!function_exists(‘time_ago’))
{
    function time_ago($datetime, $full = false)
    {
        $today = time();
        $createdday = strtotime($datetime);
        $datediff = abs($today - $createdday);
        $difftext = "";
        // $years = floor($datediff / (365 * 60 * 60 * 24));
        $months = floor(($datediff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($datediff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor($datediff / 3600);
        $minutes = floor($datediff / 60);
        $seconds = floor($datediff);
        //year checker
        // if ($difftext == "") {
        //     if ($years > 1)
        //         $difftext = $years . " years";
        //     elseif ($years == 1)
        //         $difftext = $years . " year";
        // }
        //month checker
        if ($difftext == "") {
            if ($months > 1)
                $difftext = $months . " months";
            elseif ($months == 1)
                $difftext = $months . " month";
        }
        //month checker
        if ($difftext == "") {
            if ($days > 1)
                $difftext = $days . " days";
            elseif ($days == 1)
                $difftext = $days . " day";
        }
        //hour checker
        if ($difftext == "") {
            if ($hours > 1)
                $difftext = $hours . " hours";
            elseif ($hours == 1)
                $difftext = $hours . " hour";
        }
        //minutes checker
        if ($difftext == "") {
            if ($minutes > 1)
                $difftext = $minutes . " minutes";
            elseif ($minutes == 1)
                $difftext = $minutes . " minute";
        }
        //seconds checker
        if ($difftext == "") {
            if ($seconds > 1)
                $difftext = $seconds . " seconds";
            elseif ($seconds == 1)
                $difftext = $seconds . " second";
        }
        return $difftext;
    }
}