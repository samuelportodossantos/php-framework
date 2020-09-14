<?php
$route = new Route();
$route->get("/", "IndexController@index");
$route->run();