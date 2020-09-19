<?php

class View {

  public static function return($path, $data = [])
  {

    $path = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."Views".DIRECTORY_SEPARATOR.$path.".php";

    if ( file_exists($path) ) {
      $contents = file_get_contents($path);
      
      foreach ($data as $key => $var) {
        $contents = str_replace("{{ ".$key." }}", $var, $contents);
      }

      print $contents;
    } else {
      print "View não encontrada.";
    }

    exit;

  } 

}