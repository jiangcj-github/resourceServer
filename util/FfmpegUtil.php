<?php

class FfmpegUtil{
    public static function video_info($ffmpeg,$mp4) {
        ob_start();
        passthru($ffmpeg." -i ".$mp4." 2>&1");
        $info = ob_get_contents();
        ob_end_clean();
        // 通过使用输出缓冲，获取到ffmpeg所有输出的内容。
        $ret = array();
        // Duration: 01:24:12.73, start: 0.000000, bitrate: 456 kb/s
        if (preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $info, $match)) {
            $ret["duration"] = $match[1]; // 提取出播放时间
            $ret["duration"]=substr($ret["duration"],0,strpos($ret["duration"],"."));
            $da = explode(":", $match[1]);
            $ret["seconds"] = $da[0] * 3600 + $da[1] * 60 + $da[2]; // 转换为秒
            $ret["start"] = $match[2]; // 开始时间
            $ret["bitrate"] = $match[3]; // bitrate 码率 单位 kb
        }

        // Stream #0.1: Video: rv40, yuv420p, 512x384, 355 kb/s, 12.05 fps, 12 tbr, 1k tbn, 12 tbc
        if (preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $info, $match)) {
            $ret["vcodec"] = $match[1]; // 编码格式
            $ret["vformat"] = $match[2]; // 视频格式
            $ret["resolution"] = $match[3]; // 分辨率
            $a = explode("x", $match[3]);
            $ret["width"] = $a[0];
            $ret["height"] = $a[1];
        }

        // Stream #0.0: Audio: cook, 44100 Hz, stereo, s16, 96 kb/s
        if (preg_match("/Audio: (\w*), (\d*) Hz/", $info, $match)) {
            $ret["acodec"] = $match[1];       // 音频编码
            $ret["asamplerate"] = $match[2];  // 音频采样频率
        }

        if (isset($ret["seconds"]) && isset($ret["start"])) {
            $ret["play_time"] = $ret["seconds"] + $ret["start"]; // 实际播放时间
        }

        $ret["size"] = filesize($mp4); // 文件大小
        return $ret;
    }

    //ffmpeg -i test.asf -f image2 -ss 1 -s 352x240 -y a.jpg
    //-ss必须为第一个参赛，否则速度慢
    public static function video_frame_by_per($ffmpeg,$mp4,$png,$duration,$per,$w,$h){
        $ss=floor($duration/2);
        $ss=$ss*($per/100);
        exec($ffmpeg." -ss ".$ss." -i ".$mp4." -s ".$w."*".$h." -y ".$png);
    }

}
