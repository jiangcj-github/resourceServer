<?php
require_once("../util/config.php");

//檢查_token
include("isValidToken.php");
//設置Ajax跨域請求
header("Access-Control-Allow-Origin: "."*");
//
if(!isset($_REQUEST["name"])||!isset($_REQUEST["vid"])){
    die_json(["msg"=>"Invalid Param"]);
}
$name=$_REQUEST["name"];
$name_pre=substr($name,0,strpos($name,"."));
$vid=$_REQUEST["vid"];
//新建data目錄
$base=dirname(dirname($_SERVER["SCRIPT_FILENAME"]));
$tmpDir=$base."/tmp";
$dataDir=$base."/data";
if(!is_dir($dataDir)){
    mkdir($dataDir);
}
chmod($dataDir,0755);
//移動文件至data目錄
$mp4=$tmpDir."/".$name;
$png=$tmpDir."/".$name_pre.".png";
$newMp4=$dataDir."/".$vid.".mp4";
$newPng=$dataDir."/".$vid.".png";
if(file_exists($newMp4)){
    unlink($newMp4);
}
rename($mp4,$newMp4);
if(file_exists($newPng)){
    unlink($newPng);
}
rename($png,$newPng);
//清理tmp目錄
foreach(scandir($tmpDir) as $afile){
    if($afile=="."||$afile=="..") continue;
    if(is_file($tmpDir.'/'.$afile)){
        $mtime=filemtime($tmpDir.'/'.$afile);
        if((new Datetime())->getTimestamp()-$mtime>6*60*60){
            unlink($tmpDir.'/'.$afile);
        }
    }
}
die_json(["ok"=>"ok"]);

