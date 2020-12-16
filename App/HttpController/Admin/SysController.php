<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpModels\Api\AccessRecode;
use Carbon\Carbon;

class SysController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function getMiniAppAccessRecord()
    {
        $page = $this->getRawData('page',1);
        $pageSize = $this->getRawData('pageSize',100);

        $start = Carbon::now()->startOfDay()->timestamp;
        $end = Carbon::now()->endOfDay()->timestamp;

        try
        {
            $accessInfo = AccessRecode::create()
                ->where('created_at',[$start,$end],'in')
                ->limit($this->exprOffset($page,$pageSize),$pageSize)->all();
            $total = AccessRecode::create()->where('created_at',[$start,$end],'in')->count();
        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,$this->createPaging($page,$pageSize,$total),$accessInfo,'成功');
    }



}