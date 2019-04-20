<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *
header('Access-Control-Allow-Origin: http://localhost:9000');
//配置允许发送认证信息 比如cookies（会话机制的前提）
header('Access-Control-Allow-Credentials: true');
header('Content-Type:application/json; charset=utf-8');
// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
