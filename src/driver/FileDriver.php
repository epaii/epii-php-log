<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-08
 * Time: 14:13
 */

namespace epii\log\driver;


class FileDriver implements IDriver
{
    protected $cache_dir;

    public function __construct($cache_dir = '')
    {
        $this->cache_dir = $cache_dir;
        if(empty($this->cache_dir)){
            $this->cache_dir = __DIR__."\\..\\..\\..\\";
        }
    }

    public function log(string $level, string $msg, string $msg_type = "string")
    {
        $this->writeFile(date("Ymd").".txt",$msg,$msg_type);
    }

    private function writeFile($file, $msg, $msg_type)
    {
        $path = $this->cache_dir;
        if(!file_exists($path)){
            @mkdir($path,0777,true)  ?  : exit("没有权限,请检查".$path."目录权限") ;
        }

        $file = $path.$file;

        if($msg_type != 'string'){
            switch ($msg_type){
                case 'json' : $content = json_decode($msg,true); break;
                case 'serialize' : $content = unserialize($msg); break;
            }
            if(!is_array($content)) exit("无法写入文件，数据格式错误");

            file_put_contents($file,"===================/".date("Y-m-d H:i:s")."[".$msg_type."]"."/===================".PHP_EOL, FILE_APPEND | LOCK_EX);
            ob_start();
            print_r($content);
            file_put_contents($file,ob_get_contents().PHP_EOL , FILE_APPEND);
            ob_end_clean();
            file_put_contents($file,"===================/End/===================".PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);
        }else{
            $content = $msg;
            file_put_contents($file,"===================/".date("Y-m-d H:i:s")."[".$msg_type."]"."/===================".PHP_EOL, FILE_APPEND | LOCK_EX);
            file_put_contents($file,$content.PHP_EOL , FILE_APPEND);
            file_put_contents($file,"===================/End/===================".PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }
}