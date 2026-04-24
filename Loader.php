<?php
namespace Loader;
use Controllers\IndexController;
use Database\BaseSql;
class Loader
{
    public readonly array $route;
    public readonly array $params;

    public function __construct(array $serv)
    {   
        $url = trim(parse_url($serv['REQUEST_URI'], PHP_URL_PATH), '/');
        $this->route = empty($url) ? ["index"] : explode('/', $url);
        parse_str($serv['QUERY_STRING'], $params);
        $this->params = $params ?? [];

        $this->load();
    }

    private function load()
    {
        $controller = new IndexController();
        BaseSql::connect();

        if (method_exists($controller, $this->route[0] . 'Action')) {
            $method = $this->route[0] . 'Action';
        } else {
            $method ='ErrorAction';
        }
        
        $controller->$method($this->route[1] ?? null);
    }

    public function run() {

    }
}