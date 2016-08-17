<?php

/**
 * Basic Authentication Message
 *
 * @package Micro
 * @subpackage Messages 
 * @author Jete O'Keeffe
 */
namespace Notes\Security;

class AuthMessage
{
    /**
     * Id of the Client
     * @var int
     */
    protected $publicKey;
    
    /**
     * Unix timestamp
     * @var string
     */
    protected $time;
    
    /**
     * Data/Content of the Message
     * @var string
     */
    protected $data;

    /**
     * Hash of the Message
     * @var string
     */
    protected $hash;

    /**
     * Construct 
     * @param string $publicKey [description]
     * @param string $time      [description]
     * @param string $hash      [description]
     * @param Array $data      [description]
     */
    public function __construct($publicKey, $time, $hash, Array $data = [])
    {
        $this->publicKey = $publicKey;
        $this->hash = $hash;
        $this->time = $time;
        $this->data = $data;
    }

    /**
     * Get the hash of the Message
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function build()
    {
        return $this->time . $this->publicKey . implode($this->data);
    }
}
