<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use App\Models\Order;

class IndexController extends Controller
{
    public function indexAction()
    {

        $ew = new Order();
        echo '123';
    }
}