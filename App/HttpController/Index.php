<?php

namespace App\HttpController;

use App\HttpService\LogService;
use EasySwoole\Http\AbstractInterface\Controller;
use wanghanwanghan\someUtils\control;

class Index extends Controller
{
    function onRequest(?string $action): ?bool
    {
        $uri = $this->request()->getUri()->__toString();

        LogService::getInstance()->log4PHP(parse_url($uri));

        return parent::onRequest($action);
    }

    function writeJson($statusCode = 200, $paging = null, $result = null, $msg = null)
    {
        if (!$this->response()->isEndResponse())
        {
            //整理paging
            if (is_array($paging))
            {
                foreach ($paging as $key => $val)
                {
                    $paging[$key] = (int)$val;
                }
            }

            if (empty($paging)) $paging = null;

            //整理result
            if (empty($result)) $result = null;

            $data = [
                'code' => (int)$statusCode,
                'paging' => $paging,
                'result' => $result,
                'msg' => empty($msg) ? control::getUuid() : $msg
            ];

            $this->response()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            $this->response()->withHeader('Content-type', 'application/json;charset=utf-8');
            $this->response()->withStatus($statusCode);

        }else
        {
            return false;
        }

        return true;
    }

    function writeErr(\Throwable $e, $which = 'comm'): bool
    {
        //给用户看的
        $this->writeJson(9527, null, null, $which . '错误');

        $logFileName = $which . '.log.' . date('Ymd', time());

        //给程序员看的
        $file = $e->getFile();
        $line = $e->getLine();
        $msg = $e->getMessage();

        $content = "[file ==> {$file}] [line ==> {$line}] [msg ==> {$msg}]";

        //返回log写入成功或者写入失败
        return control::writeLog($content, LOG_PATH, 'info', $logFileName);
    }
}