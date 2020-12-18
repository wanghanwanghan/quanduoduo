<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class GoodsInfo extends ModelsBase
{
    protected $tableName = 'admin_goods_info';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}