<?php

namespace App\HttpModels\Api;

use EasySwoole\ORM\AbstractModel;

class User extends AbstractModel
{
    function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    protected $tableName = 'api_user';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}