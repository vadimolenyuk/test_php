<?php
namespace Loader;
use Controllers\IndexController;

class Loader
{
    public readonly string $route;
    public readonly array $params;

    public function __construct(array $serv)
    {   
        $url = trim(parse_url($serv['REQUEST_URI'], PHP_URL_PATH), '/');

        $route = empty($url) ? ["index"] : explode('/', $url);
        $this->route = implode('', array_map('ucfirst', $route));
        parse_str($serv['QUERY_STRING'], $params);
        $this->params = $params ?? [];

        $this->load();
    }

    private function load()
    {
        $controller = new IndexController();

        if (method_exists($controller, $this->route . 'Action')) {
            $method = $this->route . 'Action';
            $controller->$method();
        } else {
            echo "404 Not Found";
        }
    }

    public function run() {

    }
}