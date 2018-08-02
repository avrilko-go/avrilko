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

    public static function pdo()
    {
        if(self::$instance !== null) {
            return self::pdo();
        }

        try {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT,DB_TABLE);
            $option = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC);

            $pdo = new \PDO($dsn, DB_USER, DB_PASS ,$option);
            self::$instance = $pdo;
            return $pdo;
        }catch (\PDOException $exception) {
            throw new \Exception($exception->getMessage());
        }

    }


}