<?php

ob_start();
session_start();

#autoload
include_once "./autoload.php";

#routes
include_once "./routes.php";

ob_end_flush();