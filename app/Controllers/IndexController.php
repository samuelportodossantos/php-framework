<?php

class IndexController implements Controller {

    public function index($request)
    {

        $data = [
            "title" => "Bem vindo ao Gens framework",
        ];

        View::return("index", $data);

    }

}