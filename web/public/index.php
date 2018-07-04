<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql;

// Определяем некоторые константы с абсолютными путями
// для использования с локальными ресурасами
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Регистрируем автозагрузчик
$loader = new Loader();

$loader->registerNamespaces(
    [
        'App\Controllers' => APP_PATH . '/controllers/',
        'App\Models' => APP_PATH . '/models/',
    ]
);

$loader->register();

// Создаём контейнер DI
$di = new FactoryDefault();

// астраиваем компонент представлений
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

// Setup a base URI
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);


// Setup a base URI
$di->set(
    'db',
    function () {
        $connection = new Mysql([
            "host"     => "localhost",
            "dbname"   => "phalcon_db",
            "port"     => 3306,
            "username" => "root",
            "password" => "passwort",
        ]);
        return $connection;
    }
);


// Setup a base URI
$di->set(
    'router',
    function () {
        $router = new \Phalcon\Mvc\Router();
        $router->add('/', [
            'namespace' => 'App\Controllers',
            'controller' => 'Index',
            'action' => 'index',
        ]);
        return $router;
    }
);


$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}