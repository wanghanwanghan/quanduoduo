<?php

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;
use wanghanwanghan\someUtils\control;

class Index extends Controller
{
    public function index()
    {

    }

    protected function writeJson($statusCode = 200, $paging = null, $result = null, $msg = null)
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
}