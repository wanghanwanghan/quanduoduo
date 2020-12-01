<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpModels\Admin\LinkInfo;
use App\HttpService\Common\CreateMysqlTable;

class LinkController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function insertLink()
    {
        $linkType = $this->request()->getRequestParam('linkType') ?? 1;
        $type = $this->request()->getRequestParam('type') ?? 1;
        $image = $this->request()->getRequestParam('image') ?? '';
        $miniAppName = $this->request()->getRequestParam('miniAppName') ?? '';
        $appId = $this->request()->getRequestParam('appId') ?? '';
        $url = $this->request()->getRequestParam('url') ?? '';
        $level = $this->request()->getRequestParam('level') ?? 0;
        $mainTitle = $this->request()->getRequestParam('mainTitle') ?? '';
        $subTitle = $this->request()->getRequestParam('subTitle') ?? '';
        $num = $this->request()->getRequestParam('num') ?? 1;
        $backgroundColor = $this->request()->getRequestParam('backgroundColor') ?? '';
        $source = $this->request()->getRequestParam('source') ?? '';
        $isShow = $this->request()->getRequestParam('isShow') ?? 0;

        $insert = [
            'linkType' => $linkType,
            'type' => $type,
            'image' => $image,
            'miniAppName' => $miniAppName,
            'appId' => $appId,
            'url' => $url,
            'level' => $level,
            'mainTitle' => $mainTitle,
            'subTitle' => $subTitle,
            'num' => $num,
            'backgroundColor' => $backgroundColor,
            'source' => $source,
            'isShow' => $isShow,
        ];

        try
        {
            LinkInfo::create()->data($insert)->save();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$insert,'成功');
    }

    function editLink()
    {
        $id = $this->request()->getRequestParam('id') ?? 1;
        $linkType = $this->request()->getRequestParam('linkType') ?? 1;
        $type = $this->request()->getRequestParam('type') ?? 1;
        $image = $this->request()->getRequestParam('image') ?? '';
        $miniAppName = $this->request()->getRequestParam('miniAppName') ?? '';
        $appId = $this->request()->getRequestParam('appId') ?? '';
        $url = $this->request()->getRequestParam('url') ?? '';
        $level = $this->request()->getRequestParam('level') ?? 0;
        $mainTitle = $this->request()->getRequestParam('mainTitle') ?? '';
        $subTitle = $this->request()->getRequestParam('subTitle') ?? '';
        $num = $this->request()->getRequestParam('num') ?? 1;
        $backgroundColor = $this->request()->getRequestParam('backgroundColor') ?? '';
        $source = $this->request()->getRequestParam('source') ?? '';
        $isShow = $this->request()->getRequestParam('isShow') ?? 0;

        $update = [
            'linkType' => $linkType,
            'type' => $type,
            'image' => $image,
            'miniAppName' => $miniAppName,
            'appId' => $appId,
            'url' => $url,
            'level' => $level,
            'mainTitle' => $mainTitle,
            'subTitle' => $subTitle,
            'num' => $num,
            'backgroundColor' => $backgroundColor,
            'source' => $source,
            'isShow' => $isShow,
        ];

        try
        {
            $info = LinkInfo::create()->where('id',$id)->get();

            $info->update($update);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$update,'成功');
    }

    function selectLink()
    {
        $linkType = $this->request()->getRequestParam('linkType');
        $page = $this->request()->getRequestParam('page') ?? 1;
        $pageSize = $this->request()->getRequestParam('pageSize') ?? 10;

        try
        {
            $info = LinkInfo::create();
            $total = LinkInfo::create();

            if (is_numeric($linkType)) $info = $info->where('linkType',$linkType);
            if (is_numeric($linkType)) $total = $total->where('linkType',$linkType);

            $info = $info->limit($this->exprOffset($page,$pageSize))->all();
            $total = $total->count();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,$this->createPaging($page,$pageSize,$total),$info,'成功');
    }

}