<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	$objconfig->table 	= "solicitantes";
	$objconfig->campoId	= "idsolicitante";
	$query = $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	echo $query ;

	$objconfig->execute($query);
	
        if($_POST["op"]==1)
        {
            $sql = $objconfig->execute_select("select max(idpersonal) as maximo from personal");
            $idpersonal = $sql[1]["maximo"];
        }else{
            $idpersonal = $_POST["1form_idpersonal"];
        }
        if($_POST["0form_usuario"]==1)
        {
            $sqlCon = $objconfig->execute_select("select count(*) as esta from usuarios where idpersonal=".$idpersonal);

            if($sqlCon[1]["esta"]==0)
            {
                $sql = "insert into usuarios(nombres,login,contra,idpersonal) 
                       values('".$_POST["0form_nombres"]."','".$_POST["0form_login"]."','".$_POST["0form_pass"]."',".$idpersonal.")";
            }else{
                $sql = "update usuarios set nombres='".$_POST["0form_nombres"]."',login='".$_POST["0form_login"]."',
                        contra='".$_POST["0form_pass"]."',estareg=1 where idpersonal=".$idpersonal;
            }

        }else{
            $sql = "update usuarios set estareg=0 where idpersonal=".$idpersonal;
        }
     //   echo $sql;
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

        if($_POST["op"]==1)
        {
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA INSERCION DEL NUEVO SOlicitante ".strtoupper($_POST["0form_nombres"])."','".date("h:i:s A")."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA MODIFICACION DEL SOLICITANTE ".strtoupper($_POST["0form_nombres"])."','".date("h:i:s A")."')");
        }
?>