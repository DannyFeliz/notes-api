<?php

namespace Notes\Controllers;

class SubjectController extends BaseController
{
    public function getAllSubject()
    {
        $data = [];
        $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], $data);

        return $this->response;
    }
}