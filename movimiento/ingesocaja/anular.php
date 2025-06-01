<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$idusuario = explode("|",$_SESSION['nombre']);
	$iduser = $idusuario[0];
    
    $objconfig->execute("update pago set estareg=0, nombre_anulado='".$idusuario[1]."' where itempago=".$_POST["anulado"]);
	$objconfig->execute("update muestra set idpago=0 where idpago=".$_POST["anulado"]);

   
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
       $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
       $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
       $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
       $ip = $_SERVER['REMOTE_ADDR'];
    else
       $ip = "IP desconocida";

    $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                         values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA ANULACION DEL DOCUMENTO DE PAGO: ".$_POST["numero"]."','".date("h:i:s A")."')");

    
?>

