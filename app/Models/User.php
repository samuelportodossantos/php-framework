<?php
class User extends DB {
    function __construct()
    {
        parent::__construct(get_class());
    }
}