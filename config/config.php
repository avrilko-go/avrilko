<?php
/**
 * 应用配置文件
 *
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 09:43
 */

return [
    'db' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'db' => 'book',
        'username' => 'homestead',
        'password' => 'secret',
    ],
    'default' => [
        'controller' => 'Index', //默认控制器
        'action' => 'index' //默认方法名
    ],
    'app' => [
        'exception_handle' => '', //自定义异常处理
        'ext' => 'html' //自定义模板文件后缀
    ]
];