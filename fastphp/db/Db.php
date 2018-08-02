<?php
/**
 * 单列模式创建连接数据库
 *
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 09:59
 */
namespace fastphp\db;

class Db
{
    private static $instance = null;

    public static function instance()
    {
        if(self::$instance !== null) {
            return self::$instance;
        }

        try {
            $config = load_config('mysql');
            $instance = new \MysqliDb($config);
            self::$instance = $instance;
            return $instance;
        }catch (\PDOException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }


}