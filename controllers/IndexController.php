<?php
namespace Controllers;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->view('index');
    }

    public function categoryAction()
    {
        $this->view('index');
    }

    public function articleAction()
    {
        $this->view('index');
    }

    public function ErrorAction()
    {
        $this->view('404');
    }

}