<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	//var_dump($_POST);
	$objconfig->table 	= "seriedoc";
	$objconfig->campoId	= "idseriedoc";
   if($_POST["op"]==1){
      //REGISTRO
      $sql="insert into seriedoc(seriedoc,valor,idtipocomprobante,estado) values('".$_POST["0form_seriedoc"]."','".$_POST["0form_valor"]."','".$_POST["0form_idcomprobante"]."','".$_POST["0form_estareg"]."')";
      echo $sql;
      $objconfig->execute($sql);
   }else{
      //UPDATE
      $sql= "update seriedoc set seriedoc='".$_POST["0form_seriedoc"]."',valor='".$_POST["0form_valor"]."',idtipocomprobante='".$_POST["0form_idcomprobante"]."',estado='".$_POST["0form_estareg"]."' where idseriedoc='".$_POST["1form_idseriedoc"]."'";
      echo $sql;
      $objconfig->execute($sql);
      
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

        if($_POST["op"]==1)
        {
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA INSERCION DE LA NUEVA SERIE: ".strtoupper($_POST["0form_seriedoc"])."','".date("h:i:s")."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA MODIFICACION DE LA SERIE: ".strtoupper($_POST["1form_idseriedoc"])."','".date("h:i:s")."')");
        } 
?>