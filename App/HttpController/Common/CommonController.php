<?php

namespace App\HttpController\Common;

use App\HttpController\Index;
use App\HttpModels\Admin\OneJokeVideo;
use App\HttpService\Common\CreateMysqlTable;
use App\HttpService\LogService;
use EasySwoole\Http\Message\UploadFile;
use QL\Ext\Chrome;
use QL\QueryList;
use wanghanwanghan\someUtils\control;

class CommonController extends Index
{
    //测试
    function test()
    {
        $res = OneJokeVideo::create()->all();

        foreach ($res as $one)
        {
            $url = str_replace('/mnt/work/quanduoduo.sanh.com.cn/Static/File/','',$one['url']);

            $url = str_replace('.mp4.mp4','.mp4',$url);

            $one->update([
                'url' => $url
            ]);
        }

        $res = OneJokeVideo::create()->all();

        return $this->writeJson(200,null,$res);
    }

    //爬糗事百科
    function spider1()
    {
        for ($page=1;$page<=13;$page++)
        {
            LogService::getInstance()->log4PHP(['page'=>$page]);

            $url = "https://www.qiushibaike.com/video/page/{$page}";

            $ql = QueryList::getInstance();

            $ql->use(Chrome::class,'chrome');

            $ql = $ql->chrome($url,['args' => ['--no-sandbox']]);

            $rules = [
                'item' => ['video>source','src'],
            ];

            $res = $ql->rules($rules)->range('.old-style-col1>div')->query()->getData()->all();

            foreach ($res as $key => $one)
            {
                LogService::getInstance()->log4PHP(['item'=>$key]);

                $url = str_replace('//','https://',$one['item']);

                if (empty($url)) continue;

                $filename = explode('/',$url);
                $filename = end($filename);

                $ext = explode('.',$filename);
                $ext = '.'.end($ext);

                $year = date('Y');
                $month = date('m');
                $day = date('d');

                $pathSuffix = $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day . DIRECTORY_SEPARATOR;

                //传绝对路径
                is_dir(FILE_PATH . $pathSuffix) ?: mkdir(FILE_PATH . $pathSuffix, 0644);

                file_put_contents(FILE_PATH.$pathSuffix.$filename.$ext,file_get_contents($url));

                LogService::getInstance()->log4PHP(['file'=>FILE_PATH.$pathSuffix.$filename.$ext]);

                OneJokeVideo::create()->data([
                    'url' => FILE_PATH.$pathSuffix.$filename.$ext,
                    'soure' => '糗事百科',
                ])->save();
            }
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