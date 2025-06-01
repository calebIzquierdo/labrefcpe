<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
    if ($_POST['op']==4){
        $objconfig->execute("update requerimiento set estareg=4 where idrequerimiento=".$_POST["codigo"]);
    }elseif($_POST['op']==3){
        $objconfig->execute("update requerimiento set estareg=3 where idrequerimiento=".$_POST["codigo"]);
    }

	
   

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
                         values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA ANULACION DE LA SALIDAD n° ".$_POST["1form_idsalida"]."','".date("h:i:s A")."')");

    
?>

