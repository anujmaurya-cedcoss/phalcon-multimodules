<?php
namespace Multi\Front\Controllers;

use Phalcon\Mvc\Controller;
class IndexController extends Controller
{
    public function indexAction()
    {
        $this->response->redirect('../product/show');
    }
}
