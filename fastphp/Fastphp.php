<?php
/**
 * 应用核心文件
 *
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 09:37
 */
namespace fastphp;

use fastphp\base\ExceptionHandler;

defined('CORE_PATH') or define('CORE_PATH', __DIR__ . '/');

class Fastphp
{
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function run()
    {
        //自动加载
        spl_autoload_register([$this, 'autoLoadClass']);
        //加载全局助手函数
        require_once APP_PATH . 'app/common.php';
        //注册全局异常处理
        $this->registerException();
        //检测开发环境，设置错误输出
        $this->setReporting();
        //检测敏感字符并删除
        $this->removeMagicQuotes();
        //删除全局变量污染
        $this->unregisterGlobals();
        //路由配置(pathinfo方式)
        $this->route();
    }

    public function autoLoadClass($class)
    {
        $classMap = $this->classMap();

        if(isset($classMap[$class])) {
            $file = $classMap[$class];
        } elseif (strpos($class,'\\') !== false) {
            $file = APP_PATH. str_replace('\\' , '/' ,$class) . '.php';
        } else {
            throw new \Exception('类不存在：'.$class);
        }

        if (!is_file($file)) {
            throw new \Exception('类不存在：'.$class);
        }

        include $file;
    }

    public function registerException()
    {
        ExceptionHandler::register();
    }

    public function setReporting()
    {
        if(APP_DEBUG) {
            //开启所有错误提示
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            //屏蔽所有错误提示显示，但是记录到日志
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
        }
    }

    public function removeMagicQuotes()
    {
        if(get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    public function stripSlashesDeep($value)
    {
        return $value = is_array($value) ? array_map([$this,'stripSlashesDeep'],$value) : stripslashes($value);
    }

    public function unregisterGlobals()
    {
        if(ini_get('register_globals')) {
            $array = ['_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES'];
            foreach ($array as $key => $value) {
                foreach ($GLOBALS[$value] as $k => $v) {
                    if($GLOBALS[$k] === $v) {
                        unset($GLOBALS[$k]);
                    }
                }
            }
        }
    }

    public function route()
    {
        $default = $this->config['default'];
        $controllerName = $default['controller'];
        $actionName = $default['action'];
        $params = [];

        $uri = $_SERVER['REQUEST_URI'];
        $position = strpos($uri, '?');
        $uri = $position === false ? $uri : substr($uri, 0 ,$position);
        //移除uri中两侧的'/'
        $uri = trim($uri, '/');

        if($uri) {
            $uriArray = explode('/', $uri);
            $uriArray = array_filter($uriArray);
            $controllerName = ucfirst($uriArray[0]);
            array_shift($uriArray);

            $actionName = $uriArray ? $uriArray[0] : $actionName;
            array_shift($uriArray);

            $params = $uriArray ? $uriArray : [];
        }

        $controller = 'app\\Controllers\\' . $controllerName . 'Controller';

        if(!class_exists($controller)) {
            throw new \Exception('控制器不存在：'.$controllerName);
        }

        if(!method_exists($controller, $actionName)) {
            throw new \Exception('方法不存在：'.$actionName);
        }

        $dispatch = new $controller($controllerName, $actionName);

        call_user_func_array([$dispatch, $actionName],$params);
    }

    //内核文件命名空间映射关系
    protected function classMap()
    {
        return [
            'fastphp\base\Controller' => CORE_PATH . 'base/Controller.php',
            'fastphp\base\ExceptionHandler' => CORE_PATH . 'base/ExceptionHandler.php',
            'fastphp\base\Model' => CORE_PATH . 'base/Model.php',
            'fastphp\base\View' => CORE_PATH . 'base/View.php',
            'fastphp\db\Db' => CORE_PATH . 'db/Db.php',
        ];
    }

}