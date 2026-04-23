<?php
namespace Controllers;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->view('index');
    }

    public function pageAction()
    {
        $this->view('index');
    }

}