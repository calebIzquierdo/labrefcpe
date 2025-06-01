<?php
  if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
		
	$objconfig = new conexion();
        
        $id = $_POST["1form_idanio"];
        $anio = $_POST["0form_descripcion"];
		
		//$upd = "update anio set estareg=0 where idanio=".$id ;
	    //$objconfig->execute($upd);
		
        
		$objconfig->table 	= "anio";
		$objconfig->campoId	= "idanio";
		$next 	= $objconfig->setCorrelativos();
	    
        $sql = "insert into anio (idanio,descripcion) values('".$next."' ,'".($anio+1)."')";
		$objconfig->execute($sql);
        
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
                                values('".$_SESSION['nombre']."','".$ip."','SE APERTURO EL NUEVO AÑO DE PRODUCCION ".($anio+1)."','".date("h:i:s A")."')");

?>
