<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpModels\Admin\GoodsInfo;
use App\HttpModels\Admin\LabelInfo;
use App\HttpModels\Admin\LabelRelationship;
use App\HttpService\LogService;
use EasySwoole\Mysqli\QueryBuilder;
use wanghanwanghan\someUtils\control;

class GoodsController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    private function relationLabel($labelIds, $targetId)
    {
        try
        {
            if (!empty($labelIds) && is_numeric($targetId))
            {
                $labelIds = explode(',',$labelIds);

                $labelRelation = [];

                foreach ($labelIds as $oneLabelId)
                {
                    $labelRelation[] = [
                        'labelId' => $oneLabelId,
                        'targetType' => 'goods',
                        'targetId' => $targetId,
                    ];
                }

                LabelRelationship::create()->destroy(function (QueryBuilder $builder) use ($targetId) {
                    $builder->where('targetId', $targetId)->where('targetType', 'goods');
                });

                LabelRelationship::create()->saveAll($labelRelation);
            }

            if (empty($labelIds) && is_numeric($targetId))
            {
                LabelRelationship::create()->destroy(function (QueryBuilder $builder) use ($targetId) {
                    $builder->where('targetId', $targetId)->where('targetType', 'goods');
                });
            }

        }catch (\Throwable $e)
        {
            $this->writeErr($e,__FUNCTION__);
        }
    }

    function insertGoods()
    {
        $image = $this->getRawData('image');
        $appId = $this->getRawData('appId');
        $appDesc = $this->getRawData('appDesc');
        $goodsDesc = $this->getRawData('goodsDesc');
        $originalPrice = $this->getRawData('originalPrice',0);
        $currentPrice = $this->getRawData('currentPrice',0);
        $labelId = $this->getRawData('labelId');
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
            'url' => $url,
            'expireTime' => $expireTime,
            'isShow' => $isShow,
            'level' => $level > 255 ? 255 : $level,
        ];

        try
        {
            $id = GoodsInfo::create()->data($insert)->save();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        $this->relationLabel($labelId,$id);

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

    function saleGoods()
    {
        $id = $this->getRawData('id');
        $sale = $this->getRawData('sale');

        if (!is_numeric($id)) return $this->writeJson(201,null,null,'id错误');

        try
        {
            $info = GoodsInfo::create()->where('id',$id)->get();

            $info->update([
                'sale' => $sale
            ]);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,null,'成功');
    }

    function editGoods()
    {
        $id = $this->getRawData('id');
        $image = $this->getRawData('image');
        $appId = $this->getRawData('appId');
        $appDesc = $this->getRawData('appDesc');
        $goodsDesc = $this->getRawData('goodsDesc');
        $originalPrice = $this->getRawData('originalPrice',0);
        $currentPrice = $this->getRawData('currentPrice',0);
        $labelId = $this->getRawData('labelId');
        $url = $this->getRawData('url');
        $expireTime = $this->getRawData('expireTime',0);
        $isShow = $this->getRawData('isShow',1);
        $level = $this->getRawData('level',1);
        $sale = $this->getRawData('sale',1);

        $update = [
            'image' => $image,
            'appId' => $appId,
            'appDesc' => $appDesc,
            'goodsDesc' => $goodsDesc,
            'originalPrice' => $originalPrice,
            'currentPrice' => $currentPrice,
            'url' => $url,
            'expireTime' => $expireTime,
            'isShow' => $isShow,
            'level' => $level > 255 ? 255 : $level,
            'sale' => ($sale > 1 || $sale < 0) ? 1 : $sale,
        ];

        try
        {
            $info = GoodsInfo::create()->where('id',$id)->get();

            $info->update($update);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        $this->relationLabel($labelId,$id);

        return $this->writeJson(200,null,$update,'成功');
    }

    function selectGoods()
    {
        $appDesc = $this->getRawData('appDesc');
        $labelId = $this->getRawData('labelId');
        $page = $this->getRawData('page',1);
        $pageSize = $this->getRawData('pageSize',10);
        $isShow = $this->getRawData('isShow');
        $sale = $this->getRawData('sale');

        try
        {
            //先查符合要求的有几个
            $goodsIds = GoodsInfo::create()->alias('goods')->field('goods.id')
                ->join('admin_label_relationship as rel','goods.id = rel.targetId','left');

            empty($appDesc) ?: $goodsIds->where('goods.appDesc',$appDesc);
            empty($labelId) ?: $goodsIds->where('rel.labelId',explode(',',$labelId),'in');
            !is_numeric($isShow) ?: $goodsIds->where('goods.isShow',$isShow);
            !is_numeric($sale) ?: $goodsIds->where('goods.sale',$sale);

            $goodsIds = $goodsIds->group('goods.id')->all();

            if (empty($goodsIds)) return $this->writeJson(200,$this->createPaging($page,$pageSize,0),null,'成功');

            $goodsIds = jsonDecode(json_encode($goodsIds));
            $goodsIds = control::array_flatten($goodsIds);

            $info = GoodsInfo::create()->where('id',$goodsIds,'in')
                ->limit($this->exprOffset($page,$pageSize),$pageSize)->all();

            if (empty($info)) return $this->writeJson(200,$this->createPaging($page,$pageSize,count($goodsIds)),null,'成功');

            //查出所有标签
            $labels = LabelInfo::create()->where('isShow',1)->all();

            foreach ($info as &$oneGoods)
            {
                if (empty($labels))
                {
                    $oneGoods->label = null;
                }else
                {
                    //先查出这个商品有几个标签
                    $goodsLabels = LabelRelationship::create()
                        ->where('targetId',$oneGoods->id)->where('targetType','goods')
                        ->all();

                    if (empty($goodsLabels))
                    {
                        $oneGoods->label = null;
                    }else
                    {
                        $label = [];

                        foreach ($goodsLabels as $oneRelation)
                        {
                            $temp = LabelInfo::create()
                                ->where('id',$oneRelation->labelId)->where('isShow',1)
                                ->get();
                            empty($temp) ?: $label[] = obj2Arr($temp);
                        }

                        $oneGoods->label = empty($label) ? null : $label;
                    }
                }
            }
            unset($oneGoods);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,$this->createPaging($page,$pageSize,count($goodsIds)),$info,'成功');
    }

}