<?php
if(!isset($_REQUEST["_token"])||!isset($_REQUEST["_time"])){
    die("No Permission");
}
$_token=$_REQUEST["_token"];
//檢查Token
$_time=$_REQUEST["_time"];
$secret="lindakai";
//$ip=$_SERVER["REMOTE_ADDR"];
$ip="127.0.0.1";
$nowTime=(new DateTime())->getTimestamp();
if($nowTime-$_time>60*60*6){
    die("Token Expired");
}
if($_token!=md5($ip.$_time.$secret)){
    die("No Permission1");
}