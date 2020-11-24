<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpModels\Admin\LinkInfo;
use App\HttpService\Common\CreateMysqlTable;

class LinkController extends Index
{
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

    function deleteLink()
    {
        $id = $this->request()->getRequestParam('id') ?? '';

        if (!is_numeric($id)) return $this->writeJson(201,null,null,'参数错误');

        try
        {
            $info = LinkInfo::create()->where('id',$id)->get();

            $info->update(['isShow'=>0]);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,null,'成功');
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
        try
        {
            $info = LinkInfo::create()->all();

            $info = obj2Arr($info);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$info,'成功');
    }

}