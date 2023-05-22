<?php

namespace Multi\Back;

use Phalcon\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream as logStream;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(
        DiInterface $container = null
    )
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
                'Multi\Back\Controllers' => '../apps/admin/controllers/',
                'Multi\Back\Models'      => '../apps/admin/models/',
            ]
        );

        $loader->register();
    }

    public function registerServices(DiInterface $container)
    {
        // Registering a dispatcher
        $container->set(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace(
                    'Multi\Back\Controllers'
                );

                return $dispatcher;
            }
        );

        // Registering the view component
        $container->set(
            'view',
            function () {
                $view = new View();
                $view->setViewsDir(
                    '../apps/admin/views/'
                );

                return $view;
            }
        );

        // logger
        $container->set(
            'logger',
            function () {
                $loginAdapter = new logStream(BASE_PATH . '/public/logs/login.log');
                return new Logger(
                    'messages',
                    [
                        'login' => $loginAdapter,
                    ]
                );
            }
        );
    }
}
