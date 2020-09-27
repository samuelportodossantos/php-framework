<?php

class AuthService {
  
  private $username;
  private $password;
  private $token;

  /**
   * @param String $username
   * @param String $password
   * @param String $token (Optional) if have token, dont need username and password
   */
  function __construct($username, $password, $token = null)
  {
    $this->username = str_replace(" ", "", strip_tags(trim($username)));
    $this->password = str_replace(" ", "", strip_tags(trim($password)));
    $this->token    = str_replace(" ", "", strip_tags(trim($token)));
  }

  public function doAuth()
  {
    $user = new User();
    $user = $user
      ->where("email", $this->username)
      ->get(['id', 'name', 'email', 'password']);
    
    if ( !$user ) {
      Utils::apiReturn(200, "Usuário não encontrado", ["username" => $this->username]);
    }

    if ( password_verify($this->password, $user->password) ) {
      unset($user->password);

      $token = Utils::generateJWT($this->username);
      $token_expires_at = date('Y-m-d H:i:s', strtotime("+1 hours"));
      
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

      Utils::apiReturn(200, "Usuário encontrado", $return);
    } else {
      Utils::apiReturn(200, "Usuário não encontrado", ["username" => $this->username]);
    }
    
  }

  public function getUserInfo()
  {

  }

  public function renewTokenTime()
  {
    
  }
  
}