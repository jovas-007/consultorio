<?php
/**
 * Manejar sesión
 */
class Sesion{
  private $login = false;
  private $usuario;
  private $admon = true;
  
  function __construct()
  {
    session_start();
    if (isset($_SESSION["usuario"])) {
      $this->usuario = $_SESSION["usuario"];
      $this->admon = $_SESSION["admon"];
      $this->login = true;
    } else {
      unset($this->usuario);
      $this->login = false;
    }
  }

  public function iniciarLogin($usuario,$admon=true){
    if ($usuario) {
      $this->usuario = $_SESSION["usuario"] = $usuario;
      $this->admon = $_SESSION["admon"] = $admon;
      $this->login = true;
    }
  }

  public function finalizarLogin(){
    unset($_SESSION["usuario"]);
    unset($this->usuario);
    $this->login = false;
  }

  public function getLogin(){
    return $this->login;
  }

  public function getUsuario(){
    return $this->usuario;
  }

  public function getAdmon(){
    return $this->admon;
  }

}

?>