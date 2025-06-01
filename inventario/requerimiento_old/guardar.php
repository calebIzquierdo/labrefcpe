<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	

	$objconfig = new conexion();

	$objconfig->table 	= "requerimiento";
	$objconfig->campoId	= "idrequerimiento";
	$anio= date("Y-m-d"); 
	$hora= date("H:i:s"); 
	//VERIFICAMOS SI SE GENERA EL ID PARA INSERTAR EN LA TABLA 
	if($_POST["op"]==1)
    {
/*
		Generamos el correlativo		
		*/
		$queryc ="select max(correlativo) as correlativo from requerimiento LIMIT 1;";
		$correlativos = $objconfig->execute_select($queryc,1);

		if(count($correlativos[1])>0){											
			$correlativo= ((int)$correlativos[1][0]["correlativo"])+1;
		}
		$nrorequerimiento = substr(str_repeat(0, 7).$correlativo, - 7);

        $next 	= $objconfig->setCorrelativos();

		//INSERTAMOS EL REQUERIMIENTO
		$sql1 = "insert into requerimiento(idrequerimiento,correlativo,fecharequerimiento,establecimiento,idarea,idarea_trabajo,idpersonal, glosa ,estareg,fecharegistro,horareg,idusuario)
			values(".$next .",'".$nrorequerimiento."','".$_POST["0form_fecharecepcion"]."','".$_POST["0form_idestablecimiento"]."',
			".$_POST["0form_idarea"].",".$_POST["0form_idareatrabajo"].",".$_POST["idpersonal"].",'".$_POST["glosa"]."',1,'".$anio."','".$hora."',".$_POST["0form_idusuario"].")";		
	} else {
		 $next 	= $_POST["idrequerimiento"];
		 
		//ACTUALIZAMOS EL REQUERIMIENTO
		$sql1 = "update requerimiento set  fecharequerimiento='".$_POST["0form_fecharecepcion"]."',establecimiento='".$_POST["0form_idestablecimiento"]."',idarea=".$_POST["0form_idarea"].",idarea_trabajo=".$_POST["0form_idareatrabajo"].",idpersonal=".$_POST["idpersonal"].", glosa='".$_POST["glosa"]."' 
		where idrequerimiento=".$next;
		
		
	}

	$objconfig->execute($sql1);
	
	
	//INSERTAR EL DETALLE DE REQUERIMIENTO
	
	$del1 = "delete from requerimiento_detalle where idrequerimiento=".$next;
	$objconfig->execute($del1);
	

		for($i=1;$i<=$_POST["contar_detalle_reque"];$i++)
		{	
			if(isset($_POST["idmaterial".$i]))
			{
				$sql1 = "insert into requerimiento_detalle(idrequerimiento,idmaterial,cantidad,especificaciones)
						values(".$next.",".$_POST["idmaterial".$i].",".$_POST["cantidad".$i].",'".$_POST["especificaciones".$i]."')";
				echo $sql1;
				$objconfig->execute($sql1);
			}
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
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION SALIDA DE MATERIALES DEL ALMACEN CON REG.°: ".$_POST["1form_idsalida"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','SALIDA MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }
?>
