<?php

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;

class Index extends Controller
{
    public function index()
    {

    }

    public function actionNotFound(?string $action)
    {
        parent::actionNotFound($action);
    }
}