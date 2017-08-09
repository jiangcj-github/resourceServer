<?php
require_once("../util/config.php");
require_once("../util/UploadHandler.php");

//設置Ajax跨域請求
header("Access-Control-Allow-Origin: "."*");
//檢查_token
include("isValidToken.php");
//上傳文件限制
if(isset($_FILES["vInput"])){
    //文件名限制
    $name=$_FILES["vInput"]["name"];
    if(preg_match("/^[0-9a-zA-Z_-]+\.mp4$/",$name)<=0){
        die("Invalid File Name");
    }
    //類型限制
    $type=$_FILES["vInput"]["type"];
    if($type!="video/mp4"){
        die("Invalid File Type");
    }
    //大小限制
    $range=$_SERVER["HTTP_CONTENT_RANGE"];
    $range = $range?preg_split("/[^0-9]+/",$range) : null;
    $size = $range ? $range[3]:null;
    if($size>200*1024*1024 || $size<1*1024*1024){
        die("Upload Size:".round($size/1024)."M,Limited:[1M,200M]");
    }
}
//處理上傳
$handler = new UploadHandler(["param_name"=>"vInput"]);




