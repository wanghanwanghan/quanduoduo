<?php

namespace App\HttpController\Common;

use App\HttpController\Index;
use App\HttpService\Common\CreateMysqlTable;
use App\HttpService\LogService;
use EasySwoole\Http\Message\UploadFile;
use QL\QueryList;
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

                //用年月日区分文件上传目录
                $year = date('Y');
                $month = date('m');
                $day = date('d');

                $pathSuffix = $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day . DIRECTORY_SEPARATOR;

                //传绝对路径
                is_dir(FILE_PATH . $pathSuffix) ?: mkdir(FILE_PATH . $pathSuffix, 0755);

                //移动到文件夹
                $file->moveTo(FILE_PATH . $pathSuffix . $filename);

                $fileList[$key] = $pathSuffix . $filename;
            }
        }

        return $this->writeJson(200, null, $fileList, '上传成功');
    }

    //spider
    function spider()
    {
        $url = 'http://www.mama.cn/index.php?g=Home&a=Hotreview&d=index&page=1';

        $rules = [
            'link' => ['dt>a', 'href'],
        ];

        $range = '#alList li';

        $rt = QueryList::get($url)->rules($rules)->range($range)->query()->getData();

        $links = $rt->all();

        foreach ($links as $oneLink)
        {
            $url = $oneLink['link'];

            $rules = [
                'title' => ['.detail-title>h1', 'text'],
                'img' => ['.mod-ctn img:eq(0)', 'src'],
                'desc' => ['.mod-ctn>p', 'text'],
            ];

            $range = '.detail-main';

            $rt = QueryList::get($url)->rules($rules)->range($range)->query()->getData();

            //[
            //    {
            //        "title":"新手妈妈孕期注意事项",
            //        "img":"http://qimg.cdnmama.com/bk/wiki/2019/9/123RF-wiki/1-qinzi/3-huaiyun/9987745.jpg",
            //        "desc":"对于绝大多数女性来说，第一次成为妈.....
            //    }
            //]

            $content = $rt->all();

            foreach ($content as $oneContent)
            {
                continue;
            }
        }

        return $this->writeJson(200,null,$rt->all());
    }

}