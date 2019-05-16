[toc]
## Epii_php_Log (php 的应用程式日志服务)

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
EpiiLog::error(字符串类型支持json字符串,serialize字符串); //支持不同的日志级别 这里仅以error示例
```


### 二，通过写入文件记录日志 

*使用方法*

```php
//初始化(全局有效)
EpiiLog::setDebug(true); //开启debug 参数 true为开启 false为关闭
EpiiLog::setLevel(EpiiLog::LEVEL_NOTICE); //设置级别 该级别下不报错
EpiiLog::setDriver((new \epii\log\driver\FileDriver('./logs/')); //选择File模式，FileDriver初始化中传入需要存放日志的目录
//写入日志
EpiiLog::error(字符串类型支持json字符串,serialize字符串); //支持不同的日志级别 这里仅以error示例
```

### 三，通过请求接口向远端存储日志

*使用方法*

- 1.去管理后台注册项目唯一码
- 2.用POST方式调用接口

```php
//初始化(全局有效)
EpiiLog::setDebug(true); //开启debug 参数 true为开启 false为关闭
EpiiLog::setLevel(EpiiLog::LEVEL_NOTICE); //设置级别 该级别下不报错
EpiiLog::setDriver((new \epii\log\driver\ApiDriver('./logs/',array $data)); //选择Api模式，第一个参数为要远端存储所需要请求的url地址；第二个参数为需要传输的数据(array)
//发起请求
EpiiLog::error(字符串类型支持json字符串,serialize字符串); //支持不同的日志级别 这里仅以error示例
```