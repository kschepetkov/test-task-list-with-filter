<?php

namespace App\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Phalcon\Cli\Router;
use Phalcon\Mvc\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Vendor;
use Phalcon\Mvc\View;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Http\Request;

class IndexController extends Controller
{
    public function indexAction()
    {
        $url = '/?';

        $mOrderItem = OrderItem::class;
        $mOrder = Order::class;
        $mProduct = Product::class;
        $mVendor = Vendor::class;
        $mCustomer = Customer::class;

        $builder = $this->modelsManager->createBuilder()
            ->columns([
                "$mOrder.order_num",
                "$mOrder.order_date",
                "$mOrder.cust_id",
                'sum' => "SUM($mOrderItem.quantity * $mOrderItem.item_price)",
                'count' => "COUNT(*)"
            ])
            ->from($mOrder)
            ->leftJoin($mOrderItem, "$mOrderItem.order_num = $mOrder.order_num");

        $group = [
            "$mOrder.order_num",
            "$mOrder.order_date",
            "$mOrder.cust_id",
        ];

        $currentPage = $this->request->getQuery("page", "int");

        if($this->request->getQuery("submit") == 'search'){
            $url .= 'submit=search';
            if ($this->request->getQuery("data_from") && $this->request->getQuery("data_to")) {
                $url .= '&data_from='.$this->request->getQuery("data_from").'&data_to='.$this->request->getQuery("data_to");
                $data_from = (new \DateTime($this->request->getQuery("data_from")))->format('Y-m-d H:i');
                $data_to = (new \DateTime($this->request->getQuery("data_to")))->format('Y-m-d H:i');
                $builder->andHaving(Order::class . ".order_date between '$data_from' AND '$data_to'");
            } elseif ($this->request->getQuery("data_to")){
                $url .= '&data_to='.$this->request->getQuery("data_from");
                $data_to = (new \DateTime($this->request->getQuery("data_to")))->format('Y-m-d H:i');
                $builder->andHaving(Order::class . ".order_date <= '$data_to'");
            } elseif ($this->request->getQuery("data_from")){
                $url .= '&data_from='.$this->request->getQuery("data_to");
                $data_from = (new \DateTime($this->request->getQuery("data_from")))->format('Y-m-d H:i');
                $builder->andHaving(Order::class . ".order_date >= '$data_from'");
            }

            if ($this->request->getQuery("price_from") && $this->request->getQuery("price_to")) {
                $price_from = $this->request->getQuery("price_from");
                $price_to = $this->request->getQuery("price_to");
                $url .= '&price_from='.$price_from.'&price_to='.$price_to;
                $builder->andHaving("sum between '$price_from' AND '$price_to'");
            } elseif ($this->request->getQuery("price_to")){
                $price_to = $this->request->getQuery("price_to");
                $url .= '&price_to='.$price_to;
                $builder->andHaving("sum <= '$price_to'");
            } elseif ($this->request->getQuery("price_from")){
                $price_from = $this->request->getQuery("price_from");
                $url .= '&price_from='.$price_from;
                $builder->andHaving("sum >= '$price_from'");
            }

            if ($this->request->getQuery("vend_name")){
                $vend_name = $this->request->getQuery("vend_name");
                $url .= '&vend_name='.$vend_name;
                $builder->leftJoin($mProduct, "$mProduct.prod_id = $mOrderItem.prod_id");
                $builder->leftJoin($mVendor, "$mVendor.vend_id = $mProduct.vend_id");
                $group[] = "$mVendor.vend_name";
                $builder->andHaving("$mVendor.vend_name = '$vend_name'");
            }
            if ($this->request->getQuery("country")){
                $country = $this->request->getQuery("country");
                $url .= '&country='.$country;
                $builder->innerJoin($mCustomer, "$mCustomer.cust_id = $mOrder.cust_id");
                $group[] = "$mCustomer.cust_country";
                $builder->andHaving("$mCustomer.cust_country = '$country'");
            }

        }
        $orders = $builder->groupBy($group)->getQuery()->execute();
        $paginator = new PaginatorModel(
            [
                "data"  => $orders,
                "limit" => 2,
                "page"  => $currentPage,
            ]
        );
        $this->view->page = $paginator->getPaginate();

        $mCustomer = Customer::class;
        $this->view->customers = $this->modelsManager->createBuilder()
            ->columns(["$mCustomer.cust_country",])
            ->from($mCustomer)
            ->groupBy(["$mCustomer.cust_country"])
            ->getQuery()
            ->execute();

        $mVendor = Vendor::class;
        $this->view->vendors = $this->modelsManager->createBuilder()
            ->columns(["$mVendor.vend_name",])
            ->from($mVendor)
            ->groupBy(["$mVendor.vend_name"])
            ->getQuery()
            ->execute();

        $this->view->current_url = $url;
    }

    public function detailAction()
    {
        if($this->request->getPost('id')){
            $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
            $id = $this->request->getPost('id');
            $mOrderItem = OrderItem::class;
            $mProduct = Product::class;

            $builder = $this->modelsManager->createBuilder()
                ->columns([
                    "$mProduct.prod_id",
                    "$mProduct.prod_name",
                    "$mOrderItem.item_price",
                    "$mOrderItem.quantity",
                    "$mOrderItem.order_num"
                ])
                ->from($mOrderItem)
                ->leftJoin($mProduct, "$mProduct.prod_id = $mOrderItem.prod_id")
                ->andHaving("$mOrderItem.order_num = '$id'")
                ->getQuery()
                ->execute();

            $Data = [];

            foreach ($builder as $item) {
                $Data[] = [
                    "prod_id" => $item->prod_id,
                    "prod_name" => $item->prod_name,
                    "item_price" => $item->item_price,
                    "quantity" => $item->quantity,
                    "summ" => $item->item_price*$item->quantity,
                    "order_num" => $item->order_num,
                ];
            }
            return json_encode($Data);
        }

        return false;
    }
}