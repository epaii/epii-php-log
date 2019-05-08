<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/5/8
 * Time: 10:37 AM
 */

namespace epii\log\driver;


class EchoDriver implements IDriver
{

    public function log(string $level, string $msg, string $msg_type = "string")
    {
        // TODO: Implement log() method.
        echo $msg;
    }
}