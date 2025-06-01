<?php
        if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	var_dump($_POST);
   if($_POST["op"]==1){
      //REGISTRO
      $sql="insert into seriedoc_personal(idpersonal, idseriedoc) values('".$_POST["0form_idusuario"]."','".$_POST["0form_idserie"]."')";
      echo $sql;
      $objconfig->execute($sql);
   }else{
      //UPDATE
      $sql= "update seriedoc_personal set idpersonal='".$_POST["0form_idusuario"]."', idseriedoc='".$_POST["0form_idserie"]."' where idpersonal='".$_POST["ult_idusuario"]."' and idseriedoc='".$_POST["ult_idserie"]."'";
      echo $sql;
      $objconfig->execute($sql);
      
   }
	//echo $query;
	//$objconfig->execute($query);
	
       /*  if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA INSERCION DE LA NUEVA EJECUTORA: ".strtoupper($_POST["0form_descricion"])."','".date("h:i:s")."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA MODIFICACION DE LA EJECUTORA: ".strtoupper($_POST["0form_descricion"])."','".date("h:i:s")."')");
        } */
?>