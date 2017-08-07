<?php

//error_reporting(0);

/**
 * 返回json
 */
function die_json($data){
    die(json_encode($data));
}