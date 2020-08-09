<?php
$route = new Route();

$route->post("/", "IndexController@index");
$route->post("/login", "IndexController@login");
$route->get("/users", "IndexController@users");

$route->run();