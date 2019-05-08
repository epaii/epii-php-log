<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/5/8
 * Time: 10:21 AM
 */

namespace epii\log;

use epii\log\driver\EchoDriver;
use epii\log\driver\IDriver;

class EpiiLog
{
    const LEVEL_ERROR = "error";
    const LEVEL_WARN = "warn";
    const LEVEL_INFO = "info";
    const LEVEL_NOTICE = "notice";
    const LEVEL_DEBUG = "debug";
    private static $_driver = null;

    public static function setDriver(IDriver $driver)
    {
        self::$_driver = $driver;
    }
    public static function setLevel(int $level)
    {
      //  self::$_driver = $driver;
    }

    public static function getDriver(IDriver $driver = null): IDriver
    {

        return ($driver !== null) ? $driver : ((self::$_driver !== null) ? self::$_driver : (self::$_driver = new EchoDriver()));

    }

    public static function error($object, IDriver $driver = null)
    {
        self::log(self::LEVEL_ERROR, $object, $driver);
    }

    public static function warn($object, IDriver $driver = null)
    {
        self::log(self::LEVEL_WARN, $object, $driver);
    }

    public static function info($object, IDriver $driver = null)
    {
        self::log(self::LEVEL_INFO, $object, $driver);
    }

    public static function notice($object, IDriver $driver = null)
    {
        self::log(self::LEVEL_NOTICE, $object, $driver);
    }

    public static function debug($object, IDriver $driver = null)
    {
        self::log(self::LEVEL_DEBUG, $object, $driver);
    }

    public static function log($level, $object, IDriver $driver = null)
    {
        $info = self::objectInfo($object);
        self::getDriver($driver)->log($level, $info[1], $info[0]);
    }

    private static function objectInfo($object)
    {
        return ["string", $object . ""];
    }
}