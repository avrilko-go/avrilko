<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 09:58
 */
namespace fastphp\Controller;

class Controller
{
    protected $config;
    protected $_action;
    protected $_controller;
    protected $_view;

    public function __construct($controller, $action)
    {
        $config = require_once APP_PATH . 'config/config.php';
        $this->config = $config;
        $this->_controller = $controller;
        $this->_action = $action;
        $this ->_view = new \Smarty();
        $this->_view->setTemplateDir(APP_PATH . 'app/views/' . $controller . '/');
        $this->_view->setCacheDir(APP_PATH . 'app/cache/templates_c');
        $this->_view->setCompileDir(APP_PATH . 'app/cache/compile');
        $this->_view->setLeftDelimiter('{');
        $this->_view->setRightDelimiter('}');
    }

    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

    public function display($name=null)
    {
        $file_name = $name ? $name : $this->_action;
        $file_path = $this->config['app']['ext'] ? $file_name . '.' . $this->config['app']['ext'] : $file_name . '.html';
        $this->_view->display($file_path);
    }

}