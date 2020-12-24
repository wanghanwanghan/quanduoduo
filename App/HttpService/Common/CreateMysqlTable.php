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

    function lifeIndex()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colVarChar('category', 16)->setDefaultValue('')->setColumnComment('类别');
            $table->colVarChar('evaluate', 16)->setDefaultValue('')->setColumnComment('评定');
            $table->colVarChar('desc', 256)->setDefaultValue('')->setColumnComment('描述');
            $table->colVarChar('city', 16)->setDefaultValue('')->setColumnComment('城市');
            $table->colVarChar('area', 16)->setDefaultValue('')->setColumnComment('区域');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function constellationToday()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colVarChar('name', 16)->setDefaultValue('')->setColumnComment('星座名称');
            $table->colVarChar('friend', 16)->setDefaultValue('')->setColumnComment('速配星座');
            $table->colTinyInt('number', 3)->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('幸运数字');
            $table->colVarChar('summary', 512)->setDefaultValue('')->setColumnComment('今日概述');
            $table->colTinyInt('all', 3)->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('综合指数');
            $table->colTinyInt('health', 3)->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('健康指数');
            $table->colTinyInt('love', 3)->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('爱情指数');
            $table->colTinyInt('work', 3)->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('工作指数');
            $table->colTinyInt('money', 3)->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('财运指数');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function constellationWeek()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colTinyInt('week', 3)->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('第几周');
            $table->colVarChar('name', 16)->setDefaultValue('')->setColumnComment('星座名称');
            $table->colVarChar('health', 512)->setDefaultValue('')->setColumnComment('健康概述');
            $table->colVarChar('job', 512)->setDefaultValue('')->setColumnComment('学业概述');
            $table->colVarChar('love', 512)->setDefaultValue('')->setColumnComment('恋爱概述');
            $table->colVarChar('money', 512)->setDefaultValue('')->setColumnComment('财运概述');
            $table->colVarChar('work', 512)->setDefaultValue('')->setColumnComment('工作概述');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function constellationMonth()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colTinyInt('month', 3)->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('第几月');
            $table->colVarChar('name', 16)->setDefaultValue('')->setColumnComment('星座名称');
            $table->colVarChar('all', 512)->setDefaultValue('')->setColumnComment('综合概述');
            $table->colVarChar('health', 512)->setDefaultValue('')->setColumnComment('健康概述');
            $table->colVarChar('love', 512)->setDefaultValue('')->setColumnComment('感情概述');
            $table->colVarChar('money', 512)->setDefaultValue('')->setColumnComment('财运概述');
            $table->colVarChar('work', 512)->setDefaultValue('')->setColumnComment('工作概述');
            $table->colVarChar('happyMagic', 512)->setDefaultValue('')->setColumnComment('可能发生的事');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function constellationYear()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colSmallInt('year')->setIsUnsigned('')->setDefaultValue(0)->setColumnComment('年');
            $table->colVarChar('name', 16)->setDefaultValue('')->setColumnComment('星座名称');
            $table->colVarChar('allTitle', 32)->setDefaultValue('')->setColumnComment('总结');
            $table->colVarChar('allDesc', 512)->setDefaultValue('')->setColumnComment('综合概述');
            $table->colVarChar('career', 512)->setDefaultValue('')->setColumnComment('事业概述');
            $table->colVarChar('love', 512)->setDefaultValue('')->setColumnComment('感情概述');
            $table->colVarChar('health', 512)->setDefaultValue('')->setColumnComment('健康概述');
            $table->colVarChar('finance', 512)->setDefaultValue('')->setColumnComment('财运概述');
            $table->colVarChar('stone', 32)->setDefaultValue('')->setColumnComment('幸运物品');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function cityList()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colVarChar('province', 32)->setDefaultValue('');
            $table->colVarChar('city', 32)->setDefaultValue('');
            $table->colVarChar('district', 32)->setDefaultValue('');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }

    function oneJokeVideo()
    {
        $sql = DDLBuilder::table(__FUNCTION__, function (Table $table) {
            $table->setTableComment('')->setTableEngine(Engine::INNODB)->setTableCharset(Character::UTF8MB4_GENERAL_CI);
            $table->colInt('id', 11)->setIsAutoIncrement()->setIsUnsigned()->setIsPrimaryKey()->setColumnComment('主键');
            $table->colVarChar('url', 512)->setDefaultValue('');
            $table->colVarChar('source', 16)->setDefaultValue('');
            $table->colInt('created_at', 11)->setIsUnsigned()->setDefaultValue(0);
            $table->colInt('updated_at', 11)->setIsUnsigned()->setDefaultValue(0);
        });

        $obj = Manager::getInstance()->get('quanduoduo')->getObj();

        $obj->rawQuery($sql);

        Manager::getInstance()->get('quanduoduo')->recycleObj($obj);
    }









}