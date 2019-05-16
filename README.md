[toc]
## Epii_php_Log php 的应用程式日志服务

目前支持

- 通过直接打印查看日志 EchoDriver
- 通过写入文件记录日志 FileDriver
- 通过请求接口向远端存储日志 ApiDriver

### 一，通过直接打印查看日志

*使用方法*

```php
//初始化(全局有效)
EpiiLog::setDebug(true); //开启debug 参数 true为开启 false为关闭
EpiiLog::setLevel(EpiiLog::LEVEL_NOTICE); //设置级别 该级别下不报错
EpiiLog::setDriver((new \epii\log\driver\EchoDriver()); //选择Echo模式
//打印日志
EpiiLog::error(字符串类型支持json字符串,serialize字符串);
```


### 二，通过写入文件记录日志 （这里只描述Api方式，其他方式请参见 [EpiiLog技术文档](https://www.kancloud.cn/rlr123654/epiiadmin-php) ）

*使用方法*

- 1.去管理后台注册项目唯一码
- 2.在项目中初始化
- 3.请求相应接口

示例代码(PHP)

```php
//初始化(全局有效)
<code>
EpiiLog::setDebug(true); //开启debug 参数 true为开启 false为关闭
EpiiLog::setLevel(EpiiLog::LEVEL_NOTICE); //设置级别 该级别下不报错
EpiiLog::setDriver((new \epii\log\driver\ApiDriver('http://api.log.wszx.cc/?app=getlog@get',['sign' => 项目唯一码])));
//发送日志
EpiiLog::error(日志内容类型为string支持json serialize);
</code>
```

### 三，短信服务

*使用方法*

- 1.去管理后台注册项目唯一码
- 2.用POST方式调用接口

~~~
http://sendmsg.wszx.cc/?app=sendmsg@dosend
~~~

参数
- `sign` (必须)项目唯一码
- `phone` (必须)接收短信的手机号
- `creat_type` (必须)短信内容

示例代码(PHP)

```php
$data = array(
    "sign" => "asda2s3cxz2erw3erwerzasda45axc1p", //您的项目唯一码
    "phone" => "18888888888", //发送短信的目标手机号
    "msg" => "您好，您的验证码是123456" //短信内容
);

$ch = curl_init("http://sendmsg.wenshi.wszx.cc/?app=sendmsg@dosend");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$content = curl_exec($ch);
curl_close($ch);
var_dump($content)
```