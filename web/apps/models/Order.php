<?php

namespace App\Models;

/**
 * @property OrderItem[] $items
 * @property Customer[] $customers
 */
class Order extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $order_num;

    /**
     *
     * @var string
     */
    public $order_date;

    /**
     *
     * @var string
     */
    public $cust_id;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_db");
        $this->setSource("Orders");
        $this->hasMany('order_num', 'App\Models\OrderItem', 'order_num', ['alias' => 'items']);
        $this->belongsTo('cust_id', 'App\Models\Customer', 'cust_id', ['alias' => 'customers']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Orders';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Order[]|Order|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Order|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}
