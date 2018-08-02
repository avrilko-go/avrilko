<?php
/**
 * 应用入口文件
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 09:36
 */

//定义应用目录
define('APP_PATH', __DIR__ . '/');

//是否开启调试模式
define('APP_DEBUG', true);

//加载框架核心文件
require APP_PATH . 'fastphp/Fastphp.php';

$config = require APP_PATH . 'config/config.php';

(new \fastphp\Fastphp($config))->run();







