<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpModels\Admin\GoodsInfo;
use App\HttpModels\Admin\LabelInfo;
use App\HttpService\Common\CreateMysqlTable;

class LabelController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function insertLabel()
    {
        $labelName = $this->getRawData('labelName');
        $isShow = $this->getRawData('isShow',1);

        $insert = [
            'labelName' => $labelName,
            'isShow' => $isShow,
        ];

        try
        {
            LabelInfo::create()->data($insert)->save();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$insert,'成功');
    }

    function deleteLabel()
    {
        $id = $this->getRawData('id');

        if (!is_numeric($id)) return $this->writeJson(201,null,null,'id错误');

        try
        {
            $info = LabelInfo::create()->where('id',$id)->get();

            $info->update([
                'isShow' => 0
            ]);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,null,'软删除成功');
    }

    function editLabel()
    {
        $id = $this->getRawData('id',1);
        $labelName = $this->getRawData('labelName');
        $isShow = $this->getRawData('isShow',1);

        $update = [
            'labelName' => $labelName,
            'isShow' => $isShow,
        ];

        try
        {
            $info = LabelInfo::create()->where('id',$id)->get();

            $info->update($update);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$update,'成功');
    }

    function selectLabel()
    {
        CreateMysqlTable::getInstance()->admin_label_info();
        CreateMysqlTable::getInstance()->admin_label_relationship();

        $isShow = $this->getRawData('isShow');
        $page = $this->getRawData('page',1);
        $pageSize = $this->getRawData('pageSize',10);

        try
        {
            $info = LabelInfo::create();
            $total = LabelInfo::create();

            !is_numeric($isShow) ?: $info = $info->where('isShow',$isShow);
            !is_numeric($isShow) ?: $total = $total->where('isShow',$isShow);

            $info = $info->limit($this->exprOffset($page,$pageSize),$pageSize)->all();
            $total = $total->count();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,$this->createPaging($page,$pageSize,$total),$info,'成功');
    }

}