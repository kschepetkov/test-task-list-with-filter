<?php

namespace App\Models;

class Vendor extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $vend_id;

    /**
     *
     * @var string
     */
    public $vend_name;

    /**
     *
     * @var string
     */
    public $vend_address;

    /**
     *
     * @var string
     */
    public $vend_city;

    /**
     *
     * @var string
     */
    public $vend_state;

    /**
     *
     * @var string
     */
    public $vend_zip;

    /**
     *
     * @var string
     */
    public $vend_country;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_db");
        $this->setSource("Vendors");
        $this->hasMany('vend_id', 'App\Models\Products', 'vend_id', ['alias' => 'Products']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Vendors';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vendor[]|Vendor|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vendor|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
