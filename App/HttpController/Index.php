<?php

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;
use wanghanwanghan\someUtils\control;

class Index extends Controller
{
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

    function exprOffset($page, $pageSize): int
    {
        return ($page - 1) * $pageSize;
    }

    function createPaging($page, $pageSize, $total): array
    {
        return [
            'page' => (int)$page,
            'pageSize' => (int)$pageSize,
            'total' => (int)$total,
        ];
    }

    function getRawData($key = '', $default = '')
    {
        $string = $this->request()->getBody()->__toString();

        $arr = jsonDecode($string);

        //raw请求
        if (!empty($arr))
        {
            if (isset($arr[$key]) && $arr[$key] == '')
            {
                return $default;
            }elseif (isset($arr[$key]))
            {
                return $arr[$key];
            }else
            {
                return $default;
            }
        }

        //其他
        return $this->request()->getRequestParam($key) ?? $default;
    }



}