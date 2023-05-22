<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Collection\Manager;

$container = new FactoryDefault();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/apps');
require_once(APP_PATH . '/vendor/autoload.php');
$container->set(
    'router',
    function () {
        $router = new Router();

        $router->setDefaultModule('front');

        $router->add(
            '/admin/:controller/:action/:params',
            [
                'module' => 'admin',
                'controller' => 1,
                'action' => 2,
                'params' => 3,
            ]
        );

        $router->add(
            '/'
        );

        $router->add(
            '/admin/products/:action',
            [
                'module' => 'admin',
                'controller' => 'products',
                'action' => 1,
            ]
        );

        $router->add(
            '/products/:action',
            [
                'controller' => 'products',
                'action' => 1,
            ]
        );

        return $router;
    }
);

$container->set(
    'mongo',
    function () {
        $mongo = new MongoDB\Client(
            'mongodb+srv://root:9SoCvPuQHy0SMXn1@cluster0.nwpyx9q.mongodb.net/?retryWrites=true&w=majority'
        );
        return $mongo->selectDatabase('store');
    },
    true
);
$container->set(
    'collectionManager',
    function () {
        return new Manager();
    }
);

$application = new Application($container);

$application->registerModules(
    [
        'front' => [
            'className' => \Multi\Front\Module::class,
            'path' => '../apps/front/Module.php',
        ],
        'admin' => [
            'className' => \Multi\Back\Module::class,
            'path' => '../apps/admin/Module.php',
        ]
    ]
);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
