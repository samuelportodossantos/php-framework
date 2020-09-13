<?php

class IndexController implements Controller {

    public function index($request){
        Utils::json_dd($request, 'stop');
    }

    public function login($request)
    {

        $Auth = new AuthService('samuelp','1234');

        var_dump($Auth);
        
        Utils::json_dd($request, 'stop');
    }

    public function users($request)
    {
        Utils::json_dd($request, 'stop');
    }

}