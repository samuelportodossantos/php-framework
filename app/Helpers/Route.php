<?php

class Route
{
    private $routeList = [];
    private $url = null;

    function __construct()
    {
        $this->url = isset($_GET['url']) ? "/{$_GET['url']}" : '/';
    }
    
    public function run ()
    {
        if ( isset($this->routeList[$this->url]) ) {
            $routeController = $this->routeList[$this->url]['name'];
            $controller = explode("@", $routeController)[0];
            $method = explode("@", $routeController);
            $method = array_pop($method);

            if ( class_exists($controller)  ) {
                $routeClass = new $controller();
                $request = $this->routeList[$this->url]['method'];
                switch ($request) {
                    case 'POST':
                        $request = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        break;
                    case 'GET':
                        $request = filter_input_array(INPUT_GET, FILTER_DEFAULT);
                        break;
                    default:
                        $request = filter_input_array(INPUT_GET, FILTER_DEFAULT);
                        break;
                }

                if ( method_exists($routeClass, $method) ) {
                    $routeClass->$method($request);
                } else {
                    $routeClass->index($request);
                }
            }

        } else {
            Utils::apiReturn(404, 'Route not found', []);
        }   
    }

    public function post($route, $routeName){
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
            Utils::apiReturn(405, 'Method not allowed', []);
        }
        $this->add($route, $routeName, 'POST');
    }

    public function get($route, $routeName){
        if ( $_SERVER['REQUEST_METHOD'] !== 'GET' ) {
            Utils::apiReturn(405, 'Method not allowed', []);
        }
        $this->add($route, $routeName, 'GET');
    }

    private function add ($route, $routeName, $method)
    {
        $this->routeList[$route] = ['name' => $routeName, 'method' => $method];
    }
}