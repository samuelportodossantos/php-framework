<?php

class DefaultMigration extends Migrate {

    function __construct()
    {
        parent::__construct('migrations');
        parent::primary('id');
        parent::varchar('table_name');
        parent::boolean('migrated');
        parent::run();
    }

}