<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpModels\Admin\LinkInfo;

class LinkController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function insertLink()
    {
        $linkType = $this->getRawData('linkType',1);
        $type = $this->getRawData('type',1);
        $image = $this->getRawData('image');
        $miniAppName = $this->getRawData('miniAppName');
        $appId = $this->getRawData('appId');
        $url = $this->getRawData('url');
        $level = $this->getRawData('level',0);
        $mainTitle = $this->getRawData('mainTitle');
        $subTitle = $this->getRawData('subTitle');
        $num = $this->getRawData('num',1);
        $backgroundColor = $this->getRawData('backgroundColor');
        $source = $this->getRawData('source');
        $isShow = $this->getRawData('isShow',1);

        $insert = [
            'linkType' => $linkType,
            'type' => $type,
            'image' => $image,
            'miniAppName' => $miniAppName,
            'appId' => $appId,
            'url' => $url,
            'level' => $level > 255 ? 255 : $level,
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
        $id = $this->getRawData('id');

        if (!is_numeric($id)) return $this->writeJson(201,null,null,'id错误');

        try
        {
            $info = LinkInfo::create()->where('id',$id)->get();

            $info->update([
                'isShow' => 0
            ]);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,null,'软删除成功');
    }

    function editLink()
    {
        $id = $this->getRawData('id',1);
        $linkType = $this->getRawData('linkType',1);
        $type = $this->getRawData('type',1);
        $image = $this->getRawData('image');
        $miniAppName = $this->getRawData('miniAppName');
        $appId = $this->getRawData('appId');
        $url = $this->getRawData('url');
        $level = $this->getRawData('level',0);
        $mainTitle = $this->getRawData('mainTitle');
        $subTitle = $this->getRawData('subTitle');
        $num = $this->getRawData('num',1);
        $backgroundColor = $this->getRawData('backgroundColor');
        $source = $this->getRawData('source');

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
        $linkType = $this->getRawData('linkType');
        $page = $this->getRawData('page',1);
        $pageSize = $this->getRawData('pageSize',10);
        $isShow = $this->getRawData('isShow',1);

        try
        {
            $info = LinkInfo::create()->where('isShow',$isShow);
            $total = LinkInfo::create()->where('isShow',$isShow);

            if (is_numeric($linkType)) $info = $info->where('linkType',$linkType);
            if (is_numeric($linkType)) $total = $total->where('linkType',$linkType);

            $info = $info->limit($this->exprOffset($page,$pageSize),$pageSize)->order('level','desc')->all();
            $total = $total->count();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,$this->createPaging($page,$pageSize,$total),$info,'成功');
    }

}