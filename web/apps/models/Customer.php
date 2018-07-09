<?php

namespace App\Models;

class Customer extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $cust_id;

    /**
     *
     * @var string
     */
    public $cust_name;

    /**
     *
     * @var string
     */
    public $cust_address;

    /**
     *
     * @var string
     */
    public $cust_city;

    /**
     *
     * @var string
     */
    public $cust_state;

    /**
     *
     * @var string
     */
    public $cust_zip;

    /**
     *
     * @var string
     */
    public $cust_country;

    /**
     *
     * @var string
     */
    public $cust_contact;

    /**
     *
     * @var string
     */
    public $cust_email;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_db");
        $this->setSource("Customers");
        $this->hasMany('cust_id', 'App\Models\Order', 'cust_id', ['alias' => 'Orders']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Customers';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Customer[]|Customer|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Customer|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
