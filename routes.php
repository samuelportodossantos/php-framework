<?php
$route = new Route();
$route->post("/", "IndexController@index");
$route->run();