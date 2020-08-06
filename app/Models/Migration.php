<?php
class Migration extends DB {
    function __construct()
    {
        parent::__construct(get_class());
    }
}