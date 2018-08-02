<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 10:20
 */
namespace app\controllers;

use app\models\Books;
use fastphp\base\Controller;
use fastphp\db\Db;

class IndexController extends Controller
{

    public function say()
    {
        $this->display();
    }
    
    public function index()
    {
        $pdo = Db::instance();
        $data=[
            'title' => '44444413131'
        ];
        $res=$pdo->where('id',1)->update('books',$data);
        var_dump($res);die;
    }

    public function test()
    {
        (new Books())->getOne();
    }


}