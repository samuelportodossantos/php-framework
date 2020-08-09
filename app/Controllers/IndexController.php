<?php

class IndexController implements Controller {

    public function index($request){
        Utils::json_dd($request);
    }

    public function login($request)
    {
        Utils::json_dd($request, 'stop');
    }

    public function users($request)
    {
        Utils::json_dd($request, 'stop');
    }

}