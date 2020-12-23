<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class Constellation extends ModelsBase
{
    protected $tableName = 'constellation';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    function addSuffix($suffix): Constellation
    {
        $name = $this->tableName().$suffix;
        $this->tableName($name);
        return $this;
    }
}