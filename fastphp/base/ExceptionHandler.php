<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/8/2
 * Time: 13:42
 */
namespace fastphp\base;

class ExceptionHandler
{
    public static function register()
    {
        $config = load_config('app');
        if($config['exception_handle']) {
            set_error_handler([$config['exception_handle'], 'handle']);
        } else {
            set_exception_handler([__CLASS__, 'handle']);
        }
    }

    public static function handle($exception)
    {
        echo '异常提示<=======>'.$exception->getMessage();
        echo '<br>';
        echo '异常文件<=======>'.$exception->getFile();
        echo '<br>';
        echo '异常行数<=======>'.$exception->getLine();
        echo '<br>';
        echo '堆栈信息<=======>'.$exception->getTraceAsString();
    }


}