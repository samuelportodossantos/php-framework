<?php

class IndexController implements Controller {

    public function index($request){

        $data = [
            "framework" => "GENS",
            "meuNome" => "Samuel Porto"
        ];

        View::return("index", $data);

    }

}