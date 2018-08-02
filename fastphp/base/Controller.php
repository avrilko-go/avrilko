<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 09:58
 */
namespace fastphp\base;

use think\Template;

class Controller
{
    protected $config;
    protected $_action;
    protected $_controller;
    protected $view;

    public function __construct($controller, $action)
    {
        $config = require_once APP_PATH . 'config/config.php';
        $this->config = $config;
        $this->_controller = $controller;
        $this->_action = $action;
        $option = [
            'view_path' => APP_PATH . '/app/views/' . lcfirst($controller),
            'cache_path' => APP_PATH . 'cache/templates_c/'
        ];
        $this ->view = new Template($option);
    }

    public function assign($name, $value='')
    {
        $this->view->assign($name, $value);
    }

    public function display($name=null, $var=[] ,$config=[])
    {
        $file_name = $name ? $name : $this->_action;
        $this->view->display($file_name);
    }

}