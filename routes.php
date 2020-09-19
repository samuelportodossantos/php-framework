<?php

$route = new Route();

// Rotas web
$route->get("/", "IndexController@index");

// Rotas da API
$route->post("/login", "AuthController@login", "api");

$route->run();