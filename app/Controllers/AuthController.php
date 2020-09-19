<?php

class AuthController implements Controller {

    public function index($request)
    {}

    public function login()
    {
        Utils::json_dd(["status" => "success", "content" => ["token" => null]]);
    }
}