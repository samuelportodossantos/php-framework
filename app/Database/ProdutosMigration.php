<?php

class ProdutosMigration extends Migrate {

    function __construct()
    {
        parent::__construct('Produtos');
        parent::primary('id');
        parent::varchar('descricao');
        parent::varchar('titulo');
        parent::double('valor');
        parent::run();
    }

}