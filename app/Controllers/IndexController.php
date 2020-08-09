<?php

class IndexController implements Controller {
    public function index($request){
        Utils::json_dd($request);
    }
}