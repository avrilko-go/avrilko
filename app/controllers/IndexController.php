<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 10:20
 */
namespace app\controllers;

use fastphp\base\Controller;
use fastphp\db\Db;

class IndexController extends Controller
{

    public function say()
    {
        $this->assign('content','测试内容');
        $this->display();
    }

    public function hello()
    {

    }

    public function index()
    {
        $pdo = Db::pdo();
        $sql = "select * from books";

        $res = $pdo->query($sql);

    }


}