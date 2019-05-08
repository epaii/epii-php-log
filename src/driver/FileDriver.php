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
    public function log(string $level, string $msg, string $msg_type = "string")
    {
        $this->writeFile(date("Ymd"),$msg,$msg_type);
    }

    private function writeFile($file, $msg, $msg_type)
    {
        $path = $this->getVendorDir()."..\\log\\";

        if(!file_exists($path)){
            @mkdir($path,0777,true)  ?  : exit("没有权限,请检查".$path."目录权限") ;
        }

        $file = $path.$file.".txt";

        if($msg_type != 'string'){
            switch ($msg_type){
                case 'json' : $content = json_decode($msg,true); break;
                case 'serialize' : $content = unserialize($msg); break;
            }
            if(!is_array($content)) exit("无法写入文件，数据格式错误");

            file_put_contents($file,"===================/".date("Y-m-d H:i:s")."[".$msg_type."]"."/===================".PHP_EOL, FILE_APPEND | LOCK_EX);
            $this->loopArrayWriteFile($content,$file);
            file_put_contents($file,"===================/End/===================".PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);
        }else{
            $content = $msg;
            file_put_contents($file,"===================/".date("Y-m-d H:i:s")."[".$msg_type."]"."/===================".PHP_EOL, FILE_APPEND | LOCK_EX);
            file_put_contents($file,$content.PHP_EOL , FILE_APPEND);
            file_put_contents($file,"===================/End/===================".PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

    private function loopArrayWriteFile($array, $file, $no = 0)
    {
        $j = $no;
        foreach ($array as $k => $v){
            $space = "";
            for ($i = 0; $i <= $no; $i++){
                $space .= "   ";
            }

            if(is_array($v)){
                file_put_contents($file,$space . $k . " => ".PHP_EOL , FILE_APPEND | LOCK_EX);
                $this->loopArrayWriteFile($v, $file, $j+1);
                continue;
            }

            file_put_contents($file,$space . $k . " => ". $v.PHP_EOL , FILE_APPEND | LOCK_EX);
        }
    }

    private function getVendorDir()
    {
        $files = get_required_files();
        if ($files) {
            foreach ($files as $file) {
                if (substr($file, $pos = -strlen($find = "composer".DIRECTORY_SEPARATOR."ClassLoader.php")) == $find) {
                    return substr($file, 0, $pos - 1)."\\";
                }
            }
        }

        return __DIR__."\\..\\..\\..\\";
    }
}