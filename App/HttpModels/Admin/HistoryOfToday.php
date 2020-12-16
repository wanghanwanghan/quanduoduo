<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class HistoryOfToday extends ModelsBase
{
    protected $tableName = 'historyOfToday';
    protected $autoTimeStamp = false;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}