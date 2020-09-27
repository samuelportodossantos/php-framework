<?php

class AuthController implements Controller {

    function __construct()
    {
        
       
    }

    public function index($request)
    {}

    public function login($request)
    {

        
        
        $auth = new AuthService($request['username'], $request['password']);
        $auth->doAuth();

        // Utils::json_dd(["status" => "success", "content" => ["token" => null]]);
    }

}