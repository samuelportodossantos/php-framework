<?php

class UsersMigration extends Migrate {

    function __construct()
    {
        parent::__construct('Users');
        parent::primary('id');
        parent::varchar('name');
        parent::varchar('email');
        parent::varchar('password');
        parent::varchar('access_token');
        parent::datetime('expires_at');
        parent::run();
    }

}