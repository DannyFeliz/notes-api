<?php

namespace Notes\Models\Api;


class Logs extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $log_id;
     
    /**
     *
     * @var string
     */
    public $public;
     
    /**
     *
     * @var integer
     */
    public $user_id;
     
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
     * @var string
     */
    public $hash;
     
    /**
     *
     * @var string
     */
    public $call_action_url;
     
    public function getSource()
    {
        return 'api_logs';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap() 
    {
        return array(
            'log_id' => 'log_id', 
            'public' => 'public', 
            'user_id' => 'user_id', 
            'added_date' => 'added_date', 
            'updated_date' => 'updated_date', 
            'hash' => 'hash', 
            'call_action_url' => 'call_action_url'
        );
    }

}
