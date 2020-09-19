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

        if ( !isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https' ) {
            Utils::apiReturn(403, 'SSL required', []);
        }
            
        if ( $this->routeList[$this->url] != null ) {

            $routeController = $this->routeList[$this->url]['name'];
            $controller      = explode("@", $routeController)[0];
            $method          = explode("@", $routeController);
            $method          = array_pop($method);
            $type            = $this->routeList[$this->url]['type'];

            if ( class_exists($controller)  ) {
                $routeClass = new $controller();
                $request = $this->routeList[$this->url]['method'];

                if ( $request != $_SERVER['REQUEST_METHOD'] ) {

                    if ( $type == 'api') {
                        Utils::apiReturn(405, 'Method not allowed', [
                            'method' => $_SERVER['REQUEST_METHOD']
                        ]);
                    } else {
                        View::return("default_views/405", ["method" => $_SERVER['REQUEST_METHOD']]);
                    }
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
            View::return("default_views/404");
        }   
    }

    public function post($route, $routeName, $type = 'normal'){
        $this->routeAdd($route, $routeName, 'POST', $type);
    }

    public function get($route, $routeName, $type = 'normal'){
        $this->routeAdd($route, $routeName, 'GET', $type);
    }

    private function routeAdd($route, $routeName, $method, $type) 
    {   
        $this->add($route, $routeName, $method, $type);
    }
   
    private function add ($route, $routeName, $method, $type)
    {
        $this->routeList[$route] = ['name' => $routeName, 'method' => $method, "type" => $type];
    }
}