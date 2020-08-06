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
            $routeController = $this->routeList[$this->url];
            $controller = explode("@", $routeController)[0];
            $method = explode("@", $routeController);
            $method = array_pop($method);

            if ( class_exists($controller)  ) {
                $routeClass = new $controller();
                if ( method_exists($routeClass, $method) ) {
                    $routeClass->$method();
                } else {
                    $routeClass->index();
                }
            }

        } else {
            print "Error 404, route not found";
        }   
    }

    public function add ($route, $routeName)
    {
        $this->routeList[$route] = $routeName;
    }
}