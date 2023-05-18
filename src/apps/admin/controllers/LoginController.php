<?php
namespace Multi\Back\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Escaper;

class LoginController extends Controller
{
    public function indexAction()
    {
        // redirected to view
    }
    public function loginAction()
    {
        $escaper = new Escaper();
        $mail = $escaper->escapeHTML($this->request->getPost('email'));
        $password = $escaper->escapeHTML($this->request->getPost('password'));

        $collection = $this->mongo->admin;
        $user = $collection->findOne(
            [
                '$and' => [['email' => $mail], ['password' => $password]]
            ]
        );
        if (!isset($user)) {
            $this->response->redirect('../admin/login/index');
            $this->logger
                ->warning('Unauthorized access attempt by : email => \''
                . $mail . '\' password => \'' . $password . '\'');
        } else {
            $this->response->redirect('../admin/crud/index');
            $this->logger
                ->info('Successful attempt by : email => \''
                . $mail . '\' password => \'' . $password . '\'');
        }
    }
}
