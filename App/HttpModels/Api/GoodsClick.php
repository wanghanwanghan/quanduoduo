<?php

namespace App\HttpModels\Api;

use App\HttpModels\ModelsBase;

class GoodsClick extends ModelsBase
{
    protected $tableName = 'admin_goods_click';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}