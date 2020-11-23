<?php

namespace App\HttpModels;

use EasySwoole\ORM\AbstractModel;

class ModelsBase extends AbstractModel
{
    function __construct(array $data = [])
    {
        parent::__construct($data);

        //$this->connectionName = 'quanduoduo';
    }
}