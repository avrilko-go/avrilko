<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 11:51
 */

function load_config($name)
{
    $config_path = APP_PATH . 'config/config.php';
    $config = include $config_path;
    if(isset($config[$name])) {
        return $config[$name];
    } else {
        return [
            'error' => '未定义该配置'
        ];
    }

}