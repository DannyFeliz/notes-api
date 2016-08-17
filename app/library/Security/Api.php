<?php

/**
 * Api HMAC Authentification
 *
 * @package Micro
 * @subpackage Messages 
 */
namespace Notes\Security;

use \Exception;
use \Phalcon\Http\Request;
use \Notes\Models\Api\Keys;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as Logger;

class Api
{
    protected $request;

    /**
     * Constructor 
     * 
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Authenticate the request for ws methods
     * 
     * @param  $getHttpMethods URI method type (GET | PUT | POST)
     * @return boolean
     */
    public function authenticate($getHttpMethods)
    {
        // Get Authentication Headers
        $publicKey = $this->request->getHeader('APIPUB');
        $time = $this->request->getHeader('APITIME');
        $hash = $this->request->getHeader('APIHASH');

        /**
         * por la shit de API v0 que hicimos para el 301 de la enciclopedia, 
         * si el url que viene es para getNdoUrl no verificamos seguridad -_-
         * 
         * @todo  remove
         * @deprecated 
         */
        $bugFixed = explode('/', $this->request->get()['_url']);
        if (array_key_exists(2, $bugFixed) && $bugFixed[2] == 'getNdoUrl') {
            return true;
        }

        // does the public key send by the header exist?
        if ($apiKey = Keys::findFirstByPublic($publicKey)) {
            //get the data sent by the API request
            switch ($getHttpMethods) {
                case 'GET':
                        $data = $this->request->getQuery();
                        unset($data['_url']);
                    break;

                case 'POST':
                        $data = $this->request->getPost();
                    break;

                case 'PUT':
                        $data = $this->request->getPut();
                    break;

                default:
                    $data = $this->request->get();
                    if (array_key_exists('_url', $data)) {
                        unset($data['_url']);
                    }
                    break;
            }
            
            $cleanData = $data;
            $message = new AuthMessage($publicKey, $time, $hash, $data);
            
            // build the server has
            $data = $message->build();
            $serverHash = HmacEncrypt::generate($data, $apiKey->private);

            //get the client hash
            $clientHash = $message->getHash();
            //return "{$clientHash} === {$serverHash}";

            // ok so it matches ^^ we are almost good to go
            if ($clientHash === $serverHash) {
                $serverMicrotime = microtime(true);
                $timeDiff = $serverMicrotime - $time;
             
                /* 
                * Uses the header value timestamp to check against the current timestamp
                * If the request was made within a reasonable amount of time (10 sec), 
                */
                if ($timeDiff <= 10) {
                    return true;
                } else {
                    throw new Exception("Request older then 10 seconds");
                }
            } else {
                throw new Exception("Hashes mistmatch ".$getHttpMethods." {$clientHash} === {$serverHash}".json_encode($_POST).json_encode($this->request->getPut()));
            }
        }

        throw new Exception("Unauthenticated request".json_encode($_POST).json_encode($this->request->getPut()));
    }
}
