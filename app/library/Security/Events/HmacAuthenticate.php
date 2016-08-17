<?php

namespace Notes\Security\Events;

/**
 * Event that Authenticates the client message with HMac
 *
 */
class HmacAuthenticate extends \Phalcon\Events\Manager
{
    /**
     * Constructor
     * 
     */
    public function __construct()
    {
        $this->handleEvent();
    }

    /**
     * Setup an Event
     *
     * Phalcon event to make sure client sends a valid message
     * http://docs.phalconphp.com/en/latest/reference/micro.html#micro-application-events
     * 
     * @return FALSE|void
     */
    public function handleEvent()
    {
        $this->attach('micro', function ($event, $app) {
            if ($event->getType() == 'beforeExecuteRoute') {
                //disable security
                if (!\Phalcon\DI::getDefault()->getConfig()->application->hmacSecurity) {
                    return;
                }

                //disable the security for this route?
                if (is_object(\Phalcon\DI::getDefault()->getConfig()->noauth)) {
                    //do we have disable security for this Routher method? ( GET, POST, PUT)
                    if (is_object(\Phalcon\DI::getDefault()->getConfig()->noauth[$app->router->getMatchedRoute()->getHttpMethods()])) {
                        // does this route existe in the disable? if, so no security for you
                        if (array_key_exists($app->router->getMatchedRoute()->getPattern(), \Phalcon\DI::getDefault()->getConfig()->noauth[$app->router->getMatchedRoute()->getHttpMethods()])) {
                            return ;
                        }
                    }
                }


                // Authenticate method using credentials
                try {
                    $apiAuth = new \Notes\Security\Api($app->request);
                    return $apiAuth->authenticate($app->router->getMatchedRoute()->getHttpMethods());
                } catch (\Exception $e) {
                    //log problem
                    \Phalcon\DI::getDefault()->getLogger()->error($e->getMessage());

                    $app->response->setStatusCode(200, "Unauthorized");
                    $app->response->setContentType('application/json', 'UTF-8');
                    $app->response->setJsonContent(['message' => $e->getMessage()]);
                    $app->response->send();
                    return false;
                }
            }
        });
    }
}
