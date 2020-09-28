<?php

class AuthController implements Controller {

    private $auth = null;

    function __construct()
    {
        $this->auth = new AuthService(['login']);
    }

    public function index($request)
    {}

    public function login($request)
    {
        $authResponse = $this->auth->doAuth($request['username'], $request['password']);
        if ( $authResponse ) {
            Utils::apiReturn(200, "Login realizado com sucesso", $authResponse);
        }
        Utils::apiReturn(200, "Usuário não encontrado", $request);
    }

    public function getUser($request)
    {
        Utils::apiReturn(200, "Usuário autenticado encontrado", $this->auth->getUserInfo());
    }

    public function refresh($request)
    {
        $id = $this->auth->getUserInfo()->id;
        $new_expires_at = date('Y-m-d H:i:s', strtotime("+".SESSION_TIME." hours"));
        $updated_user = (new User())
            ->update($id, ['expires_at' => $new_expires_at]);
        
        Utils::apiReturn(200, "Tempo de sessão atualizado", ['expires_at' => $updated_user[0]['expires_at']]);
    }

    public function logout($request)
    {
        $id = $this->auth->getUserInfo()->id;
        $updated_user = new User();
        $updated_user->update($id, [
            'expires_at' => date('Y-m-d H:i:s', strtotime("-1 hours")),
            'access_token' => null
            ]);
        
        Utils::apiReturn(200, "Sessão encerrada com sucesso", $updated_user);
    }

}