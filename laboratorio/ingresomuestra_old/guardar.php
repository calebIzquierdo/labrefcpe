<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "muestra";
	$objconfig->campoId	= "idingresomuestra";
	
	
	
    if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
        $query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
		
	    $objconfig->execute($query);
		
		$del1 = "delete from muestra_det where idingresomuestra=".$next;
		$objconfig->execute($del1);
	
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$objconfig->table 	= "muestra_det";
			$objconfig->campoId	= "idmuestradetalle";
			$next_detalle 	= $objconfig->setCorrelativos();
			$sql1 = "insert into muestra_det(idmuestradetalle,idingresomuestra,idtipo_examen, idarea, idusuario,  nombre_usuario,idareatrabajo,codbarra,cantidad )
                values(".$next_detalle.",".$next.",".$_POST["idtipo_examen".$i].",".$_POST["idarea".$i].",".$_POST["0form_idusuario"].",
				'".$_POST["0form_nombre_usuario"]."',".$_POST["idareatrabajo".$i].",'".$_POST["0form_codbarra"]."',".$_POST["cantidad".$i].")";
		echo $sql1."\n ";
		
		$objconfig->execute($sql1);
		}
		
	}else{
        $next	= $_POST["1form_idingresomuestra"];
		$query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	    $objconfig->execute($query);
		
		
		$del1 = "delete from muestra_det where idingresomuestra=".$next;
		$objconfig->execute($del1);
	
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$next_detalle = $_POST["idmuestradetalle".$i];
			
			if ($_POST["idmuestradetalle".$i]==0){
			$objconfig->table 	= "muestra_det";
			$objconfig->campoId	= "idmuestradetalle";
			$next_detalle 	= $objconfig->setCorrelativos();
			}
				
			$sql1 = "insert into muestra_det(idmuestradetalle,idingresomuestra,idtipo_examen, idarea, idusuario,  nombre_usuario,idareatrabajo,codbarra,cantidad )
                values(".$next_detalle.",".$next.",".$_POST["idtipo_examen".$i].",".$_POST["idarea".$i].",".$_POST["0form_idusuario"].",
				'".$_POST["0form_nombre_usuario"]."',".$_POST["idareatrabajo".$i].",'".$_POST["0form_codbarra"]."',".$_POST["cantidad".$i].")";
			echo "Editar: ".$sql1."\n " ;

			
			$objconfig->execute($sql1);
		}
		
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
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO FICHAS DE MUESTRAS PARA EXAMENES NUMERO: ".$next." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION EL EXAMEN DE URUCULTIVO CON REGISTRO N°: ".$_POST["1form_idurocultivo"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>