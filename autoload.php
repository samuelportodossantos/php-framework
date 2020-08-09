<?php

# Verifica se existe o arquivo de configuração
$env_path = __DIR__.DIRECTORY_SEPARATOR.".env";
// $env_path = "../.env";
if ( !file_exists($env_path) ) {
    trigger_error("Não foi possível encontrar o arquivo de configuração");
    die();
}

# Lê o arquivo de configuração, cria e disponibiliza as constantes
$config = parse_ini_file($env_path);
foreach ($config as $key => $index) {
    define($key, $index);
}

# Realiza o autoload das classes
spl_autoload_register(function($class){

    foreach (array_slice(scandir('app'), 2) as $folder) {
        $filePath = __DIR__. DIRECTORY_SEPARATOR ."app".DIRECTORY_SEPARATOR. $folder . DIRECTORY_SEPARATOR . $class .".php";
        if ( file_exists( $filePath ) ) {
            include $filePath;
        }
    }

});