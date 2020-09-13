<?php
$route = new Route();

$route->post("/", "IndexController@index");
$route->post("/login", "IndexController@login");
$route->get("/users", "IndexController@users");

$route->get("/products", "ProductController@index");
$route->post("/products/save", "ProductController@save");
$route->post("/products/delete", "ProductController@delete");

$route->run();