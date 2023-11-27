<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ComponentModels extends CI_Model
{

    public function statiscticsCard($count, $caption, $icon, $size)
    {

        switch ($size) {
            case 'big' :
                $ukuran = 'col-lg-6 col-md-6 col-sm-6 col-xs-6';
                break;
            case 'medium' :
                $ukuran = 'col-lg-4 col-md-4 col-sm-4 col-xs-4';
                break;
        }

        $html = '<div class="row stat">
        <div class="' . $ukuran . ' icon-box">
            <i class="' . $icon . '"></i>
        </div>
        <div class="' . $ukuran . ' text-box">
            <div class="wrapper">
                <p class="number">' . $count . '</p>
                <p class="title">Total</p>
                <p class="subtitle">' . $caption . '</p>
            </div>
        </div>
    </div>';

//        $html = '<div class=" ' . $ukuran . '  " style="padding-left: 0px">
//        <div class="statisctics col-md-12 col-sm-12 col-xs-12">
//            <div class="col-md-6 col-sm-6 col-xs-6 icon">
//                <i class=" ' . $icon . ' "></i>
//            </div>
//            <div class="col-md-6 col-sm-6 col-xs-6 text-stat">
//                <div class="text-wrapper">
//                    <p class="number">' . $count . '</p>
//                    <p class="title">Total</p>
//                    <p class="subtitle">' . $caption . '</p>
//                </div>
//            </div>
//        </div>
//    </div>';

        return $html;

    }

    public function statiscticsCardReverse($count, $caption, $icon, $size)
    {

        switch ($size) {
            case 'big' :
                $ukuran = 'col-lg-6 col-md-6 col-sm-6s col-xs-6';
                break;
            case 'medium' :
                $ukuran = 'col-lg-4 col-md-4 col-sm-4 col-xs-4';
                break;
        }

        $html = '<div class="row stat">
        <div class="' . $ukuran . ' icon-box-reverse">
            <i class="' . $icon . '"></i>
        </div>
        <div class="' . $ukuran . ' text-box-reverse">
            <div class="wrapper">
                <p class="number">' . $count . '</p>
                <p class="title">Total</p>
                <p class="subtitle">' . $caption . '</p>
            </div>
        </div>
    </div>';

        return $html;

    }


    public function statiscticsCardSummary($count, $caption, $icon, $link, $size)
    {

        switch ($size) {
            case 'big' :
                $ukuran = 'col-lg-6 col-md-6 col-sm-6 col-xs-6';
                break;
            case 'medium' :
                $ukuran = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
                break;
        }

        $html = '<div style="cursor:pointer;margin-left: 10px;margin-top: 10px;" onclick="' . $link . '" class="row stat">
        <div class="' . $ukuran . ' icon-box-summary">
            <i class="' . $icon . '"></i>
        </div>
        <div class="' . $ukuran . ' text-box-summary">
            <div class="wrapper">
                <p class="number">' . $count . '</p>
                <p class="title">Total</p>
                <p class="subtitle">' . $caption . ' <span class="fa fa-arrow-right right-subtitle"></span></p>
            </div>
        </div>
    </div>';

        return $html;

    }


}

