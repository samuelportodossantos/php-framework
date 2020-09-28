<?php

$route = new Route();

// Rotas web
$route->get("/", "IndexController@index");

// Rotas da API
$route->post("/login", "AuthController@login", "api");
$route->get("/user", "AuthController@getUser", "api");
$route->get("/refresh", "AuthController@refresh", "api");
$route->get("/logout", "AuthController@logout", "api");

$route->run();