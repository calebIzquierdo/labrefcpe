<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
    $objconfig->table 	= "tipo_examen";
    $objconfig->campoId	= "idtipo_examen";
	if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
    }else{
        $next	= $_POST["1form_idtipo_examen"];
    }
	
    $query = $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	echo $query;
    $objconfig->execute($query);
	
	
	$del1 = "delete from tipo_examen_precio where idtipo_examen=".$next;
    $objconfig->execute($del1);

    for($i=1;$i<=$_POST["contar_prueba"];$i++)
    {
        $sql1 = "insert into tipo_examen_precio(idtipo_examen,idtipoatencion, valor,idusuario,nombre_usuario )
                              values(".$next.",'".$_POST["idtipoatencion".$i]."', '".$_POST["valor".$i]."',
							  '".$_POST["0form_idusuario"]."','".$_POST["0form_nombre_usuario"]."'  )";
		echo $sql1."\n ";
		$objconfig->execute($sql1);
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
                            values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA INSERCION DEL NUEVO TIPO EXAMEN:".strtoupper($_POST["0form_descripcion"])."','".date("h:i:s A")."')");
    }else{
       $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                            values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA MODIFICACION DEL TIPO EXAMEN:".strtoupper($_POST["0form_descripcion"])."','".date("h:i:s A")."')");
    }
?>