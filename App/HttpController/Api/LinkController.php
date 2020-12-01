<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpModels\Admin\LinkInfo;

class LinkController extends Index
{
    function selectLink()
    {
        $linkType = $this->getRawData('linkType');
        $page = $this->getRawData('page',1);
        $pageSize = $this->getRawData('pageSize',10);

        try
        {
            $info = LinkInfo::create()->where('isShow',1);
            $total = LinkInfo::create()->where('isShow',1);

            if (is_numeric($linkType)) $info = $info->where('linkType',$linkType);
            if (is_numeric($linkType)) $total = $total->where('linkType',$linkType);

            $info = $info->limit($this->exprOffset($page,$pageSize),$pageSize)->order('updated_at','desc')->all();
            $total = $total->count();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,$this->createPaging($page,$pageSize,$total),$info,'成功');
    }


}