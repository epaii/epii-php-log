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

    public function log(string $level, string $msg, string $msg_type = "string")
    {
        $config = EpiiLog::getConfig();
        if(!$config){
            exit("请完善配置");
        }
        $data = [
            'sign' => $config['sign'],
            'start' => $config['debug'] ? 1 : 2,
            'log' => $msg,
            'msg_type' => $msg_type,
            'level' => $level
        ];
        $url = $config['api_url'];

        $this->curlRequest($url,false,'post',$data);
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
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}