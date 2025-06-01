<?php

 @session_start();
 $idperfil = $_SESSION['idperfil'];
 $path = "http://".$_SERVER['HTTP_HOST']."/labrefcpe/";
 global $path,$idperfil,$pc ;

  if(!isset($_SESSION['id_user'])) 
  {
    header('Location: '.$path.'index.php');

  }
$pc =   php_uname();
 
?>
