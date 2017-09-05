<?php
require_once("../util/config.php");
require_once("../util/FfmpegUtil.php");

//設置Ajax跨域請求
header("Access-Control-Allow-Origin: "."*");
//檢查_token
include("isValidToken.php");
//
if(!isset($_REQUEST["name"])){
    die_json(["msg"=>"Invalid Param"]);
}
$name=$_REQUEST["name"];
$name_pre=substr($name,0,strpos($name,"."));
//處理上傳結果
$base=dirname(dirname($_SERVER["SCRIPT_FILENAME"]));
$mp4=$base."/tmp/".$name;
$png=$base."/tmp/".$name_pre.".png";
$png_p=$base."/tmp/".$name_pre."_p.png";
$ffmpeg=$base."/util/ffmpeg";
chmod($ffmpeg,0777);

$res=FfmpegUtil::video_info($ffmpeg,$mp4);
FfmpegUtil::video_frame_by_per($ffmpeg,$mp4,$png,$res["seconds"],20,200,200);
FfmpegUtil::video_frame_by_per($ffmpeg,$mp4,$png_p,$res["seconds"],10,400,200);
chmod($png,0777);
chmod($png_p,0777);

$res["png"]="http://".$_SERVER["SERVER_NAME"]."/tmp/".$name_pre.".png";

die_json(["ok"=>"ok","data"=>$res]);

