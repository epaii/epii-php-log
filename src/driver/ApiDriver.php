<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-08
 * Time: 16:12
 */

namespace epii\log\driver;

class ApiDriver implements IDriver
{
    private $appid;
    private $secret_key = null;
    private $common_post_data = array();
    private $url = "http://api.log.wszx.cc/?";
    private static $status = -1;


    public function __construct($appid, $secret_key, $server_api = null, $common_post_data = array())
    {
        $this->common_post_data = $common_post_data;
        $this->appid = $appid;
        if ($server_api)
            $this->url = stripos($server_api, "?") > 0 ? $server_api : ($server_api . "?");

        $this->secret_key = $secret_key;
    }

    public function log(  $level,   $msg,   $msg_type = "string")
    {
        if (self::$status == -1) {
            $data = array_merge($this->common_post_data, array(
                'do_type' => "status",
            ));

            $request = json_decode($this->curlRequest($this->url . "&app=getlog@get", false, 'post', $data), true);
            if ($request["code"] == 1) {
                self::$status = $request['data']["status"];
            }

        }

        if (self::$status == 1) {
            $data = array_merge($this->common_post_data, array(
                'do_type' => "log",
                'log' => $msg,
                'msg_type' => $msg_type,
                'level' => $level
            ));

            $this->curlRequest($this->url . "&app=getlog@get", false, 'post', $data);
        }

    }

    private function curlRequest($url, $https = true, $method = "get", $data = array())
    {

        $data["appid"] = $this->appid;
        self::encode($data, $this->secret_key);

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
//        var_dump($data);
//        var_dump($content);
        return $content;
    }

    private static function encode(&$data, $secret_key)
    {

        if (is_array($data)) {
            ksort($data);
            $string = "";
            foreach ($data as $key => $value) {
                $string .= $key . "=" . $value . "&";
            }


            $data["sign"] = md5($string . $secret_key);
            return $data["sign"];

        }
        return null;
    }
}