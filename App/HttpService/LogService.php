<?php

namespace App\HttpService;

use EasySwoole\Component\Singleton;
use wanghanwanghan\someUtils\control;

class LogService extends ServiceBase
{
    use Singleton;

    //写log
    function log4PHP($content, $type = 'info', $filename = '')
    {
        (!is_array($content) && !is_object($content)) ?: $content = json_encode($content);

        return control::writeLog($content, LOG_PATH, $type, $filename);
    }
}