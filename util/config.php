<?php

//error_reporting(0);

/*調試選項*/
error_reporting(E_ALL);
ini_set("display_errors","on");

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