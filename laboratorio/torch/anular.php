<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
    
    $objconfig->execute("update torch set estareg=3 where idtorch=".$_POST["anulado"]);
	//echo "update torch set estareg=3 where idtorch=".$_POST["anulado"]." ";
	
	$objconfig->execute("update examen_realizado set estareg=3 where idexamen=".$_POST["anulado"]," and idtipo_examen=70");
	//echo "update torch set estareg=3 where idtorch=".$_POST["anulado"]." ";

	$objconfig->execute("update muestra set estareg=1 where idingresomuestra=".$_POST["0form_idingresomuestra"]);
	
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
                         values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA ANULACION DE LA RFERENCIA ".$_POST["numero"]."','".date("h:i:s A")."')");

    
?>

