<?php
namespace Notes\Models;


class Notes extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $note_id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $body;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var string
     */
    public $status;

    /**
     *
     * @var string
     */
    public $color;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'notes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notes[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notes
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
