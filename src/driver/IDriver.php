<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/5/8
 * Time: 10:22 AM
 */

namespace epii\log\driver;

interface IDriver
{


    public function log( $level,  $msg,  $msg_type = "string");
}