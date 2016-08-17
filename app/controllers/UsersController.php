<?php

namespace Notes\Controllers;


use Goutte\Client;
use Symfony\Component\BrowserKit\Cookie;

class UsersController extends BaseController
{
    public $client;

    public function onConstruct() {
    }

    public function login() {

        $username = $this->request->getPost('username', 'string');
        $password = $this->request->getPost('password', 'string');

        if (!$username) {
            $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], ["error" => 'Username is required']);
            return $this->response;
        }

        if (!$password) {
            $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], ["error" => 'Password is required']);
            return $this->response;
        }

        $client = new Client();
        $url = str_replace("http", "https", getenv("REQUEST_URL")) . "/login/index.php";
        $client->request('POST', $url, ["username" => $username, "password" => $password]);

        $hasError = $client->getCrawler()->filter('.alert-error');
        if ($hasError->count()) {
            $response = ['success' => false,
                         'content' => $hasError->first()->text()];

            $this->setResponse(['message' => 'ERROR'], $response, 422);
            return $this->response;
        }

        $token = uniqid();
        $this->saveCookies($client, $token);
        $this->session->set("token", $token);

        $response = ["success" => true,
                     "content" => $token
                    ];

        $this->setResponse(['message' => 'SUCCESS'], $response);
        return $this->response;
    }

    public function getUserName()
    {
        if($this->isValidToken($this->request->getQuery("token"))) return;

        $data = [];

        $client = $this->doRequest(getenv("REQUEST_URL"));

        $username = $client->filter("p.nombre > strong");
        $data['username'] = str_replace('BIENVENIDO(A) ', '', $username->text());

        $this->setResponse(['type' => 'SUCCESS', 'message' => 'SUCCESS'], $data);
        return $this->response;
    }

    public function logout($token)
    {
        $this->redis->del($token);
    }
}