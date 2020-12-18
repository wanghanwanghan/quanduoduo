<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpModels\Admin\GoodsInfo;

class GoodsController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function insertGoods()
    {
        $image = $this->getRawData('image');
        $appId = $this->getRawData('appId');
        $appDesc = $this->getRawData('appDesc');
        $goodsDesc = $this->getRawData('goodsDesc');
        $originalPrice = $this->getRawData('originalPrice',0);
        $currentPrice = $this->getRawData('currentPrice',0);
        $goodsType = $this->getRawData('type',0);
        $url = $this->getRawData('url');
        $expireTime = $this->getRawData('expireTime',0);
        $isShow = $this->getRawData('isShow',1);
        $level = $this->getRawData('level',1);

        $insert = [
            'image' => $image,
            'appId' => $appId,
            'appDesc' => $appDesc,
            'goodsDesc' => $goodsDesc,
            'originalPrice' => $originalPrice,
            'currentPrice' => $currentPrice,
            'type' => $goodsType,
            'url' => $url,
            'expireTime' => $expireTime,
            'isShow' => $isShow,
            'level' => $level > 255 ? 255 : $level,
        ];

        try
        {
            GoodsInfo::create()->data($insert)->save();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$insert,'成功');
    }

    function deleteGoods()
    {
        $id = $this->getRawData('id');

        if (!is_numeric($id)) return $this->writeJson(201,null,null,'id错误');

        try
        {
            $info = GoodsInfo::create()->where('id',$id)->get();

            $info->update([
                'isShow' => 0
            ]);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,null,'软删除成功');
    }

    function editGoods()
    {
        $id = $this->getRawData('id',1);
        $image = $this->getRawData('image');
        $appId = $this->getRawData('appId');
        $appDesc = $this->getRawData('appDesc');
        $goodsDesc = $this->getRawData('goodsDesc');
        $originalPrice = $this->getRawData('originalPrice',0);
        $currentPrice = $this->getRawData('currentPrice',0);
        $goodsType = $this->getRawData('type',0);
        $url = $this->getRawData('url');
        $expireTime = $this->getRawData('expireTime',0);
        $isShow = $this->getRawData('isShow',1);
        $level = $this->getRawData('level',1);

        $update = [
            'image' => $image,
            'appId' => $appId,
            'appDesc' => $appDesc,
            'goodsDesc' => $goodsDesc,
            'originalPrice' => $originalPrice,
            'currentPrice' => $currentPrice,
            'type' => $goodsType,
            'url' => $url,
            'expireTime' => $expireTime,
            'isShow' => $isShow,
            'level' => $level > 255 ? 255 : $level,
        ];

        try
        {
            $info = GoodsInfo::create()->where('id',$id)->get();

            $info->update($update);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$update,'成功');
    }

    function selectGoods()
    {
        $goodsType = $this->getRawData('goodsType');
        $page = $this->getRawData('page',1);
        $pageSize = $this->getRawData('pageSize',10);
        $isShow = $this->getRawData('isShow',1);

        try
        {
            $info = GoodsInfo::create()->where('isShow',$isShow);
            $total = GoodsInfo::create()->where('isShow',$isShow);

            if (is_numeric($goodsType)) $info = $info->where('type',$goodsType);
            if (is_numeric($goodsType)) $total = $total->where('type',$goodsType);

            $info = $info->limit($this->exprOffset($page,$pageSize),$pageSize)->order('updated_at','desc')->all();
            $total = $total->count();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,$this->createPaging($page,$pageSize,$total),$info,'成功');
    }

}