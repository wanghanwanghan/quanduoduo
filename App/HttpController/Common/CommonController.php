<?php

namespace App\HttpController\Common;

use App\HttpController\Index;
use EasySwoole\Http\Message\UploadFile;
use wanghanwanghan\someUtils\control;

class CommonController extends Index
{
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

                //移动到文件夹
                $file->moveTo(FILE_PATH . $filename);

                $fileList[] = $filename;
            }
        }

        return $this->writeJson(200, null, $fileList, '上传成功');
    }

}