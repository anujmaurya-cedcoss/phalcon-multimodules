<?php
namespace Multi\Front\Controllers;

use Phalcon\Mvc\Controller;

class ProductController extends Controller
{
    public function indexAction()
    {
        // redirected to view
    }
    
    public function showAction()
    {
        $collection = $this->mongo->product;
        $data = $collection->find();
        $this->view->message = $data;
    }

    public function quickViewAction()
    {
        $id = $_GET['id'];
        $collection = $this->mongo->product;
        $data = $collection->findOne(["_id" => new \MongoDB\BSON\ObjectId($id)]);
        $this->view->message = $data;
    }
}