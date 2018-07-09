<?php

namespace App\Models;

class OrderItem extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $order_num;

    /**
     *
     * @var integer
     */
    public $order_item;

    /**
     *
     * @var string
     */
    public $prod_id;

    /**
     *
     * @var integer
     */
    public $quantity;

    /**
     *
     * @var double
     */
    public $item_price;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_db");
        $this->setSource("OrderItems");
        $this->belongsTo('order_num', 'App\Models\Order', 'order_num', ['alias' => 'Orders']);
        $this->belongsTo('prod_id', 'App\Models\Product', 'prod_id', ['alias' => 'Product']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'OrderItems';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderItems[]|OrderItems|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrderItems|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function sum($parameters = null)
    {
        return 'OrderItems';
    }
}
