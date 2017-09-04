<?php

//error_reporting(0);

/**
 * 時間設置
 */
date_default_timezone_set("UTC");

/**
 * 返回json
 */
function die_json($data){
    die(json_encode($data));
}