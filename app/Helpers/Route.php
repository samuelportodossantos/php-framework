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
            
        if ( $this->routeList[$this->url] != null ) {

            $routeController = $this->routeList[$this->url]['name'];
            $controller = explode("@", $routeController)[0];
            $method = explode("@", $routeController);
            $method = array_pop($method);

            if ( class_exists($controller)  ) {
                $routeClass = new $controller();
                $request = $this->routeList[$this->url]['method'];

                if ( $request != $_SERVER['REQUEST_METHOD'] ) {
                    Utils::apiReturn(405, 'Method not allowed', [
                        'method' => $_SERVER['REQUEST_METHOD'],
                        'request_url' => $_SERVER['SERVER_NAME'].'/'.$_SERVER['REQUEST_URI'],
                        'line' => 53
                        ]);
                }

                switch ($request) {
                    case 'POST':
                        $request_data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        break;
                    case 'GET':
                        $request_data = Utils::urlGetParams();
                        break;
                    default:
                        $request_data = Utils::urlGetParams();
                        break;
                }

                if ( method_exists($routeClass, $method) ) {
                    $routeClass->$method($request_data);
                } else {
                    $routeClass->index($request_data);
                }
            }

        } else {
            Utils::apiReturn(404, 'Route not found', []);
        }   
    }

    public function post($route, $routeName){
        $this->add($route, $routeName, 'POST');
    }

    public function get($route, $routeName){
        $this->add($route, $routeName, 'GET');
    }
   
    private function add ($route, $routeName, $method)
    {
        $this->routeList[$route] = ['name' => $routeName, 'method' => $method];
    }
}