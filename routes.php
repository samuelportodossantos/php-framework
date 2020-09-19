<?php
$route = new Route();
$route->get("/", "IndexController@index");

$route->post("/login", "AuthController@login");

$route->run();