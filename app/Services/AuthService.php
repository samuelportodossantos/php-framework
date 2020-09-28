<?php

class AuthService
{
  private $userInfo = null;
  private $username;
  private $password;
  private $token;


  function __construct($exceptions = [])
  {
    $user = $_REQUEST['url'];
    if (!in_array($user, $exceptions)) {
      $this->token = str_replace('Bearer ', '', getallheaders()['Authorization']);
      if ( !$this->verifyToken() ) {
        Utils::apiReturn(200, "Token inválido", ['token' => $this->token]);
      }

      $this->userInfo = $this->userInfo == null ? (new User())
        ->where('access_token', $this->token)
        ->get(['id', 'name', 'email', 'expires_at', 'access_token']) : $this->userInfo;
    }
  }

  public function doAuth($username, $password)
  {

    $this->username = str_replace(" ", "", strip_tags(trim($username)));
    $this->password = str_replace(" ", "", strip_tags(trim($password)));

    $user = new User();
    $user = $user
      ->where("email", $this->username)
      ->get(['id', 'name', 'email', 'password']);

    if (!$user) {
      Utils::apiReturn(200, "Usuário não encontrado", ["username" => $this->username]);
    }

    if (password_verify($this->password, $user->password)) {
      unset($user->password);

      $token = Utils::generateJWT($this->username);
      $token_expires_at = date('Y-m-d H:i:s', strtotime("+". SESSION_TIME ." hours"));

      (new User())->update($user->id, [
        'access_token' => $token,
        'expires_at' => $token_expires_at
      ]);

      $return = [
        'name' =>  $user->name,
        'email' => $user->email,
        'token' => $token,
        'expires_at' => $token_expires_at
      ];

      return $return;
    } else {
      return false;
    }
  }

  public function verifyToken()
  {
    if ($this->token != null) {
      $user = (new User())->where('access_token', $this->token)
        ->get();
      return $user;
    }
    return false;
  }

  public function setToken($token)
  {
    $this->token    = str_replace(" ", "", strip_tags(trim($token)));
  }

  public function getUserInfo()
  {
    return $this->userInfo;
  }
}
