<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 10:20
 */
namespace app\controllers;

use fastphp\db\Db;

class IndexController {

    public function say()
    {
        echo 1;
    }

    public function hello()
    {
        echo 'hello';
    }

    public function index()
    {
        $pdo = Db::pdo();
        $sql = "select * from books";

        $res = $pdo->query($sql);

    }


}