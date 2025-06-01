<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "kitsalida";
	$objconfig->campoId	= "idkit";

    if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
		
	} else {
		$next 	= $_POST["1form_idkit"];
	}
	
	$query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	 echo $query."\n ";
	$objconfig->execute($query);
	
	$del1 = "delete from kitsalida_det where idkit=".$next;
	$objconfig->execute($del1);
	
	for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
	{
		$sql1 = "insert into kitsalida_det(idkit,cantidad,idmaterial,idmarca,serie,fvencimiento,idtipomaterial, idunidad,lote,idregistro,totales )
				values(".$next.",'".$_POST["cantidad".$i]."','".$_POST["idmaterial".$i]."','".$_POST["idmarca".$i]."',
				'".$_POST["serie".$i]."','".$_POST["fvencimiento".$i]."','".$_POST["idtipomaterial".$i]."',
				'".$_POST["idunidad".$i]."','".$_POST["lote".$i]."','".$_POST["idregistro".$i]."','".$_POST["totales".$i]."')";
		 echo "\n  ".$sql1."\n ";
		
		$objconfig->execute($sql1);
	}
			
	//PARA REGISTRAR EL LOG DE LA ACCIONES	
	
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
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO SALIDA DE MATERIALES DEL ALMACEN NUMERO: ".$next." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','SALIDA MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION SALIDA DE MATERIALES DEL ALMACEN CON REG.°: ".$_POST["1form_idkit"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','SALIDA MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>