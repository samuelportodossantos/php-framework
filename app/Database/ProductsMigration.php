<?php

class ProductsMigration extends Migrate {

    function __construct()
    {
        parent::__construct('Products');
        parent::primary('id');
        parent::varchar('description');
        parent::double('value');
        parent::integer('amount');
        parent::run();
    }

    
}