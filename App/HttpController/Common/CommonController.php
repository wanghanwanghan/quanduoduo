<?php

namespace App\HttpController\Common;

use App\HttpController\Index;
use EasySwoole\Http\Message\UploadFile;
use QL\Ext\Chrome;
use QL\QueryList;
use wanghanwanghan\someUtils\control;

class CommonController extends Index
{
    //测试
    function test()
    {
        for ($page=1;$page<=1;$page++)
        {
            $url = "https://www.qiushibaike.com/video/page/{$page}";

            $ql = QueryList::getInstance();

            $ql->use(Chrome::class,'chrome');

            $ql = $ql->chrome($url,['args' => ['--no-sandbox']]);

            $range = [
                '.old-style-col1>div',
            ];

            $rules = [
                'item' => ['video>source','src'],
            ];

            $res = $ql->rules($rules)->range($range)->query()->getData()->all();
        }



        return $this->writeJson(200,null,$res);
    }

    //上传文件
    function uploadFile()
    {
        $fileArr = $this->request()->getUploadedFiles();

        if (empty($fileArr)) return $this->writeJson(201, null, null, '未发现上传文件');

        $fileList = [];

        foreach ($fileArr as $key => $file)
        {
            if ($file instanceof UploadFile)
            {
                //提取文件后缀
                $ext = explode('.', $file->getClientFilename());
                $ext = end($ext);

                //新建文件名
                $filename = control::getUuid() . '.' . $ext;

                //用年月日区分文件上传目录
                $year = date('Y');
                $month = date('m');
                $day = date('d');

                $pathSuffix = $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day . DIRECTORY_SEPARATOR;

                //传绝对路径
                is_dir(FILE_PATH . $pathSuffix) ?: mkdir(FILE_PATH . $pathSuffix, 0644);

                //移动到文件夹
                $file->moveTo(FILE_PATH . $pathSuffix . $filename);

                $fileList[$key] = $pathSuffix . $filename;
            }
        }

        return $this->writeJson(200, null, $fileList, '上传成功');
    }

}