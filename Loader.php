<?php
namespace Loader;
use Controllers\IndexController;
use Database\BaseSql;
use Exception;

class Loader
{
    public readonly array $route;

    public function __construct(array $serv)
    {   
        $url = trim(parse_url($serv['REQUEST_URI'], PHP_URL_PATH), '/');
        $this->route = empty($url) ? [""] : explode('/', $url);

        $this->load();
    }

    private function load()
    {
        BaseSql::connect();
        $this->runController();
    }

    private function runController() {
        $urls = (require __DIR__ . '/rule.php');
        $method ='ErrorAction';

        foreach ($urls as $url => $controller){
            $urlParams = explode("/", $url);
            $isActual = true;
            if (count($this->route) == count($urlParams)) {
          
                foreach($this->route as $key => $part){
                    if ($part === $urlParams[$key] || ( $urlParams[$key]===":id" && filter_var($part, FILTER_VALIDATE_INT)!==false)) {
                        $method = $controller;
                    } else {
                        $method ='ErrorAction';
                        $isActual = false;
                    }
                }

                if ($isActual) {
                    break;
                }
            }
        }
        try {
            (new IndexController())->$method($this->route[1] ?? null);
        } catch (\Throwable $e) {
            echo "Error not id;";
        }
    }
}