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

    function admin_link_info()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colTinyInt('linkType',3)->setIsUnsigned()->setDefaultValue(0);
            $table->colVarChar('image',256)->setDefaultValue('');
            $table->colVarChar('miniAppName',16)->setDefaultValue('');
            $table->colVarChar('appId',32)->setDefaultValue('');
            $table->colVarChar('url',256)->setDefaultValue('');
            $table->colTinyInt('level',3)->setIsUnsigned()->setDefaultValue(0);
            $table->colVarChar('mainTitle',16)->setDefaultValue('');
            $table->colVarChar('subTitle',32)->setDefaultValue('');
            $table->colInt('num',11)->setIsUnsigned()->setDefaultValue(0);
            $table->colVarChar('backgroundColor',32)->setDefaultValue('');
            $table->colTinyInt('isShow',3)->setIsUnsigned()->setDefaultValue(1);
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function admin_link_click()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colBigInt('id', 20)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colInt('linkId',11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('userId',11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->indexNormal('linkId_index','linkId');
            $table->indexNormal('userId_index','userId');
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function admin_access_record()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colBigInt('id', 20)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colInt('ip2long',11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->indexNormal('ip2long_index','ip2long');
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function sys_config()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('配置')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 20)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colVarChar('category',32)->setDefaultValue('');
            $table->colVarChar('name',32)->setDefaultValue('');
            $table->colText('val');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function admin_goods_info()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colVarChar('image', 256)->setDefaultValue('');
            $table->colVarChar('appId', 32)->setDefaultValue('');
            $table->colVarChar('appIdDesc', 32)->setDefaultValue('')->setColumnComment('appId描述');
            $table->colVarChar('goodsDesc', 128)->setDefaultValue('')->setColumnComment('商品描述');
            $table->decimal('originalPrice', 8, 2)->setDefaultValue(0);
            $table->decimal('currentPrice', 8, 2)->setDefaultValue(0);
            $table->colTinyInt('type', 3)->setIsUnsigned()->setDefaultValue(0)->setColumnComment('1自营，2优惠券，3京配');
            $table->colVarChar('url', 1024)->setDefaultValue('');
            $table->colInt('expireTime', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colTinyInt('isShow', 3)->setIsUnsigned()->setDefaultValue(0);
            $table->colTinyInt('level', 3)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function admin_label_info()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colVarChar('labelName', 16)->setDefaultValue('')->setColumnComment('标签名');
            $table->colTinyInt('isShow', 3)->setIsUnsigned()->setDefaultValue(1);
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function admin_label_relationship()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('标签的关系表')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colInt('labelId', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colVarChar('targetType', 16)->setDefaultValue('')->setColumnComment('链接还是商品');
            $table->colInt('targetId', 11)->setIsUnsigned()->setDefaultValue(0)->setColumnComment('目标主键');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }
}