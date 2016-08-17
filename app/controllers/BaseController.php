<?php

namespace Notes\Controllers;

use Goutte\Client;
use Phalcon\Mvc\Controller;
use Symfony\Component\BrowserKit\Cookie;

/**
 * Base controller
 *
 */
abstract class BaseController extends Controller
{
    /**
     * Set the general response
     *
     * @param array $status Statys of the response content
     * @param array $data Data to response
     * @param int $statusCode optional status code
     * @return void
     */
    public function setResponse($status, $data = null, $statusCode = 200)
    {
        $response['status'] = $status; // Status
        $response['data'] = null;
        if (!is_null($data)) {
            $response['data'] = $data;
        } // Data

        //log all request taht we send to client trying to access the API
        if ($this->config->application->debug->logRequest) {
            $this->di->getLog('request')->addInfo('RESPONSED', $response);
        }

        $acceptType = $this->request->getBestAccept();
        $this->response->setStatusCode($statusCode, $response['status']['message']);
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent($response['data']);
    }

}
