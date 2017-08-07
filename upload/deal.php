<?php
require_once("../util/config.php");
require_once("../util/FfmpegUtil.php");
require_once("../util/Random.php");

header("Access-Control-Allow-Origin: "."*");

$name=$_REQUEST["name"];
$name_pre=substr($name,0,strpos($name,"."));

$base=dirname(dirname($_SERVER["SCRIPT_FILENAME"]));
$mp4=$base."/tmp/".$name;
$png=$base."/tmp/".$name_pre.".png";
$ffmpeg=$base."/util/ffmpeg.exe";

$res=FfmpegUtil::video_info($ffmpeg,$mp4);
FfmpegUtil::video_frame_by_per($ffmpeg,$mp4,$png,$res["seconds"],20,200,200);

$res["png"]="http://".$_SERVER["SERVER_NAME"]."/tmp/".$name_pre.".png";

die_json(["ok"=>"ok","data"=>$res]);
//處理上傳結果
