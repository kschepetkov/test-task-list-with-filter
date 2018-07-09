<?php

namespace App\Models;

class Product extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $prod_id;

    /**
     *
     * @var string
     */
    public $vend_id;

    /**
     *
     * @var string
     */
    public $prod_name;

    /**
     *
     * @var double
     */
    public $prod_price;

    /**
     *
     * @var string
     */
    public $prod_desc;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_db");
        $this->setSource("Products");
        $this->hasMany('prod_id', 'App\Models\Orderitem', 'prod_id', ['alias' => 'Orderitems']);
        $this->belongsTo('vend_id', 'App\Models\Vendor', 'vend_id', ['alias' => 'Vendors']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Products';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product[]|Product|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
