<?php
$route = new Route();
$route->add("/", "IndexController@index");
$route->run();