<?php
class Product extends DB {
    function __construct()
    {
        parent::__construct(get_class());
    }
}