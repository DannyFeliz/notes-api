<?php

namespace Notes\Controllers;


class IndexController extends BaseController
{

    public function index()
    {
        $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], ["Test" => "John Doe"]);

        return $this->response;
    }


}
