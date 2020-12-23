<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class CityList extends ModelsBase
{
    protected $tableName = 'cityList';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}