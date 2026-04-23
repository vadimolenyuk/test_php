<?php
namespace Controllers;

use Smarty\Smarty;

abstract class BaseController
{
    protected $smarty;


    public function __construct()
    {
        $this->smarty = new Smarty();
    }

    protected function view(string $file, array $data = [])
    {
        $this->smarty->assign("file", $file);

        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display("../view/basetemplate.tpl");
    }
}