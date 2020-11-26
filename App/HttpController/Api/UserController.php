<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpModels\Api\LinkClick;
use App\HttpService\Common\CreateMysqlTable;

class UserController extends Index
{
    function clickLink()
    {
        $linkId = $this->request()->getRequestParam('linkId') ?? '';

        if (empty($linkId) || !is_numeric($linkId)) return $this->writeJson();

        try
        {
            LinkClick::create()->data([
                'linkId'=>$linkId
            ])->save();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson();
    }









}