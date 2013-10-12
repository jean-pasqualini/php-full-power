<?php

namespace lib;

class errorPhp
{
    const UNKNOW_ERROR = 1;
    CONST UNDEFINED_METHOD = 2;

    public function __construct()
    {

    }

    public function register()
    {
        ini_set('display_errors',0);

        register_shutdown_function('fullPhp\shutdown');

        set_error_handler('fullPhp\shutdown');
    }

    public function detectError($errorString)
    {
        if(false !== strpos($errorString, "Call to undefined method")) return self::UNDEFINED_METHOD;

        return self::UNKNOW_ERROR;
    }

    private function shutdown()
    {
        if(!is_null($e = error_get_last()))
        {
            error_handler($e["type"], $e["message"], $e["file"], $e["line"]);
        }
    }

    private function onError($errno, $errstr, $errfile, $errline)
    {
        echo $errstr.PHP_EOL;

        $error = $this->detectError($errstr);

        if($errstr == self::UNDEFINED_METHOD)
        {
            echo "Detech method call undefined ...";
        }
    }
}