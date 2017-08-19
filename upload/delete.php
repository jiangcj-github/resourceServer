<?php
require_once("../util/config.php");

//檢查_token
include("isValidAdmin.php");
//設置Ajax跨域請求
header("Access-Control-Allow-Origin: "."*");
//
if(!isset($_REQUEST["vid"])){
    die_json(["msg"=>"Invalid Param"]);
}
$vid=$_REQUEST["vid"];
//刪除文件
$base=dirname(dirname($_SERVER["SCRIPT_FILENAME"]));
$dataDir=$base."/data";
$mp4=$dataDir."/".$vid.".mp4";
$png=$dataDir."/".$vid.".png";
if(file_exists($mp4)){
    unlink($mp4);
}
if(file_exists($png)){
    unlink($png);
}
die_json(["ok"=>"ok"]);

