<?php

namespace Notes\Models\Api;

use Notes\Models\Users\Users;

class Keys extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $key_id;
     
    /**
     *
     * @var string
     */
    public $site;
     
    /**
     *
     * @var string
     */
    public $public;
     
    /**
     *
     * @var string
     */
    public $private;
     
    /**
     *
     * @var string
     */
    public $added_date;
     
    /**
     *
     * @var string
     */
    public $updated_date;
     
    /**
     *
     * @var integer
     */
    public $user_id;
     
    public function getSource()
    {
        return 'api_keys';
    }

    /**
     * Generate the site public and private keys
     * 
     * @return Array
     */
    public static function generate(Users $userData)
    {
        $hash = hash('sha512', openssl_random_pseudo_bytes(64));

        // Base62 Encode the hash, resulting in an 86 or 85 character string
        $hash = gmp_strval(gmp_init($hash, 16), 62);

        // Chop and send the first 80 characters back to the client
         
        $public = substr($hash, 0, 32);
        $secret = substr($hash, 32, 48);
        
        $keys = new self();
        $keys->site  = 'naruho.do';
        $keys->public  = $public;
        $keys->private = $secret;
        $keys->user_id = $userData->user_id;
        $keys->added_date = date('Y-m-d H:i:s');
        $keys->updated_date = $keys->added_date;

        if(!$keys->save())
            throw new \Exception($keys->getMessages()[0]);
            
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap() 
    {
        return array(
            'key_id' => 'key_id', 
            'site' => 'site', 
            'public' => 'public', 
            'private' => 'private', 
            'added_date' => 'added_date', 
            'updated_date' => 'updated_date', 
            'user_id' => 'user_id'
        );
    }

}
