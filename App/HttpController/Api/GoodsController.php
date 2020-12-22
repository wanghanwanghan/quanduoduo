<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpModels\Admin\GoodsInfo;
use App\HttpModels\Admin\LabelInfo;
use App\HttpModels\Admin\LabelRelationship;
use wanghanwanghan\someUtils\control;

class GoodsController extends Index
{
    function selectGoods()
    {
        $isShow = $sale = 1;
        $appDesc = $labelId = '';
        $page = $this->getRawData('page',1);
        $pageSize = $this->getRawData('pageSize',10);

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
                ->limit($this->exprOffset($page,$pageSize),$pageSize)->order('level','desc')->all();

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