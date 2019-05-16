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
    private $common_post_data;
    private $url;

    private $status = -1;

    public function __construct($url, $common_post_data = [])
    {
        $this->common_post_data = $common_post_data;
        $this->url = $url;



    }

    public function log(string $level, string $msg, string $msg_type = "string")
    {

        if ($this->status===-1)
        {
            $data = array_merge($this->common_post_data, [
                'do_type' => "status",

            ]);


           $this->status =  $this->curlRequest($this->url, false, 'post', $data);
        }



        $data = array_merge($this->common_post_data, [
            'do_type' => "log",
            'log' => $msg,
            'msg_type' => $msg_type,
            'level' => $level
        ]);


        $this->curlRequest($this->url, false, 'post', $data);
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