<?php 
	if(!session_start()){session_start();}
        
	include_once("class.conexion.php");
	
	$objconfig = new conexion();
	
	$user 	= strtoupper($_POST["user"]);
	$cont	= strtoupper($_POST["pass"]);
	$pass	= md5($cont);
	
	$objconfig->table 	= "usuarios";
	$objconfig->campos 	= array("idusuario","nombres","contra","idperfil");
	
	$sql = $objconfig->genera_sql(" upper(login) ='$user' and contra='$pass' and estareg=1");
	
	$consulta = $conn->prepare($sql);
	$consulta->execute();
	$items = $consulta->fetch();
	
	$pc =   php_uname();

	if(!isset($items["nombres"]))
	{
             echo "No se puede determinar que las credenciales proporcionadas sean auténticas. !!!";
			echo "<div class='alert alert-danger alert-dismissible text-center' >Error de Usuario y/o Contraseña </div>";
			 			
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
		               
            $objconfig->execute("insert into log(usuario,ip,descripcion,hora,idusuario,nombrepc) 
                                 values('?|".$user."','".$ip."','SE INTENTÓ TENER ACCESO AL SISTEMA CON CONTRASEÑA: ".$cont." ','".date("h:i:s A")."',0,'".$pc."')");

            
	}else{
            $_SESSION['id_user']        = $items["idusuario"];
            $_SESSION['nombre']         = $items["idusuario"]."|".$items["nombres"];
            $_SESSION['idperfil']       = $items["idusuario"];
            $id       = $items["idusuario"];
			
               
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
		   
            
            $objconfig->execute("insert into log(usuario,ip,descripcion,hora,idusuario,nombrepc) 
						 values('".$items["idusuario"]."|".$items["nombres"]."','".$ip."','ACCESO AL SISTEMA','".date("h:i:s A")."',".$id.",'".$pc."' )");

            echo "1";
	}

?>