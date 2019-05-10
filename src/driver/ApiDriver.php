<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-08
 * Time: 16:12
 */

namespace epii\log\driver;


use epii\log\EpiiLog;

class ApiDriver implements IDriver
{
    private $sign;
    private $url;

    public function __construct($url,$sign = '')
    {
        $this->sign = $sign;
        $this->url = $url;
    }

    public function log(string $level, string $msg, string $msg_type = "string")
    {
        $data = [
            'sign' => $this->sign,
            'start' => EpiiLog::$_debug ? 1 : 2,
            'log' => $msg,
            'msg_type' => $msg_type,
            'level' => $level
        ];

        $this->curlRequest($this->url,false,'post',$data);
    }

    private function curlRequest($url, $https = true, $method = "get", $data = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https === true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if ($method === 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}