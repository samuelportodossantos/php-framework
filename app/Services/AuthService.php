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
    $this->username = $username;
    $this->password = $password;
    $this->token    = $token;
  }

  public function doAuth()
  {

  }

  public function getUserInfo()
  {

  }

  public function renewTokenTime()
  {
    
  }
  
}