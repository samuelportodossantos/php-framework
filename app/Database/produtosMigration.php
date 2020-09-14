<?php

class produtosMigration extends Migrate {

    function __construct()
    {
        parent::__construct('Users');
        parent::primary('id');
        parent::run();
    }

}