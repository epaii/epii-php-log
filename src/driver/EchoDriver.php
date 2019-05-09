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
    public function log(string $level, string $msg, string $msg_type = "string")
    {
        if($msg_type != 'string'){
            switch ($msg_type){
                case 'json' : $msg = json_decode($msg,true); break;
                case 'serialize' : $msg = unserialize($msg); break;
            }

            print_r($msg);
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

        $msg = "<span style='color:{$color};'>" . $msg . "</span>";
        return $msg;
    }
}