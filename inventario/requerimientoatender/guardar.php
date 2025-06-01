<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	

	$objconfig = new conexion();

	$objconfig->table 	= "requerimiento";
	$objconfig->campoId	= "idrequerimiento";

	//VERIFICAMOS SI SE GENERA EL ID PARA INSERTAR EN LA TABLA 
	if($_POST["op"]!=1)
    {       
		 $next 	= $_POST["idrequerimiento"];

		 //ACTUALIZAMOS EL REQUERIMIENTO
		 $sql1 = "update requerimiento set estareg=4, observacion='".$_POST["observacion"]."' where idrequerimiento=".$next;
	}

	if($_POST["op"]==4){
		//ACTUALIZAMOS EL ESTADO A APROBADO
		$next 	= $_POST["idrequerimiento"];
		$sql1 = "update requerimiento set  estareg=4, observacion='".$_POST["observacion"]."' where idrequerimiento=".$next;
	}
   

	$anio= date("Y-m-d"); 
	$hora= date("H:i:s"); 

	$objconfig->execute($sql1);
	
	
	//INSERTAR EL DETALLE DE REQUERIMIENTO
	
	$del1 = "delete from requerimiento_validar where idrequerimiento=".$next;
	$objconfig->execute($del1);
	

		for($i=1;$i<=$_POST["contar_detalle_reque"];$i++)
		{	
			$sql2 = "insert into requerimiento_validar(idrequerimiento,idmaterial,cantidad,cant_aprobada,especificaciones,idmarca,fvencimiento,
						idunidad,idmodelo,idtipobien,idtipomaterial)
					values(".$next.",".$_POST["idmaterial".$i].",".$_POST["cantidad".$i].",".$_POST["cantidad_a".$i].",
					'".$_POST["especificaciones".$i]."','1','12'
					,'".$_POST["idunidad".$i]."','1','1','1')";
			echo $sql2;		
		$objconfig->execute($sql2);
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

       if($_POST["op"]!==1)
        {   
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO LA VERIFICACIÓN DEL REQUERIMIENTO N°: ".$_POST["correlativo"]." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','SALIDA MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE APROBO LA  NETREGA DEL REQUERIMIENTO N°: ".$_POST["correlativo"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','SALIDA MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        } 
?>