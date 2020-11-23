<?php

namespace App\HttpService\Common;

use App\HttpService\ServiceBase;
use EasySwoole\Component\Singleton;
use EasySwoole\DDL\Blueprint\Table;
use EasySwoole\DDL\DDLBuilder;
use EasySwoole\DDL\Enum\Character;
use EasySwoole\DDL\Enum\Engine;
use EasySwoole\Pool\Manager;

class CreateMysqlTable extends ServiceBase
{
    use Singleton;

    function __construct()
    {
        parent::__construct();
        $this->onServiceCreate();
    }

    private function onServiceCreate()
    {

    }

    //用户表
    function api_user()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colVarChar('username', 16)->setDefaultValue('');
            $table->colVarChar('password', 16)->setDefaultValue('');
            $table->colVarChar('phone', 16)->setDefaultValue('');
            $table->colVarChar('wxOpenId', 64)->setDefaultValue('');
            $table->colVarChar('email', 64)->setDefaultValue('');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

}