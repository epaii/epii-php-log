<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/5/8
 * Time: 10:37 AM
 */

namespace epii\log\driver;

use epii\log\EpiiLog;
class EchoDriver implements IDriver
{
    public function log(  $level,   $msg,   $msg_type = "string")
    {
        if($msg_type != 'string'){
            switch ($msg_type){
                case 'json' : $msg = json_decode($msg,true); break;
                case 'serialize' : $msg = unserialize($msg); break;
            }

            echo "<pre>";
            print_r($msg);
            echo "</pre>";
            exit;
        }

        echo $this->getMsgStyle($msg, $level);
        exit;
    }

    private function getMsgStyle($msg, $level)
    {
        $color = '';
        switch ($level){
            case EpiiLog::LEVEL_DEBUG : $color = "#000000"; break;
            case EpiiLog::LEVEL_INFO : $color = "#5BB85D"; break;
            case EpiiLog::LEVEL_ERROR : $color = "#EFAD4D"; break;
            case EpiiLog::LEVEL_WARN : $color = "#D9544F"; break;
            case EpiiLog::LEVEL_NOTICE : $color = "#418BCA"; break;
        }

        if(!$this->isCli()){
            $msg = "<span style='color:{$color};'>" . $msg . "</span>";
        }

        return $msg;
    }

    private function isCli() {
        $type = php_sapi_name();
        if (isset($type) && substr($type, 0, 3) == 'cli') {
            return true;
        } else {
            return false;
        }
    }
}