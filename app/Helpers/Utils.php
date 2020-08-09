<?php

class Utils 
{

    /**
     * @var $content conteúdo que vai ser renderizado
     * @var $arg se não for definido o padrão é 'pass', para parar a executação do sistema informe 'stop'
     * @return void
     */
    public static function dd ($content, $arg = 'pass')
    {
        print "<pre style='padding: 15px; background-color: #000; color: lightgreen;'>";
        print_r($content);
        print "</pre>";

        if ( $arg == 'stop' ) {
            exit;
        }
    }

    /**
     * @var $content conteúdo que vai ser renderizado
     * @return void
     */
    public static function json_dd ($content, $arg = 'pass')
    {
        print json_encode($content);
        if ( $arg == 'stop' ) {
            exit;
        }
    }

    /**
     * @param integer $code codigo de retorno, Ex: 200 para sucesso
     * @param string $message mensagem de erro ou sucesso
     * @param array $data dados de resposta ao retorno
     * @return json parão de retorno da requisição
     */
    public static function apiReturn($code, $message, $dada)
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'data' => $dada
        ];
        self::json_dd($response, 'stop');
    }
   
    public static function urlGetParams()
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[1];
        $get_params = [];
        $uri = parse_str($uri, $get_params);
        return $get_params;
    }

}