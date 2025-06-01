<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "codigobarra_estable";
	$objconfig->campoId	= "idcodigobarra";
	$next 	= $objconfig->setCorrelativos();
	 
    $query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	echo $query ;
	$objconfig->execute($query);
    
	$del1 = "delete from codigobarra_detalle where idingresomuestra=".$next;
	$objconfig->execute($del1);
	
		for($i=1;$i<=$_POST["0form_cantidad"];$i++)
		{
			$sql1 = "insert into codigobarra_detalle(idcodigobarra,codbarra )
                values(".$next.",'".$_POST["codbarra".$i]."')";
		echo $sql1."\n ";
		$objconfig->execute($sql1);
		}
	$ncorrela = $_POST["cant"]+1;
	 $objconfig->execute("update correlativo_estable set correlativo='".$ncorrela."' where idcorrelativo=".$_POST["0form_item"]);
	

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
                                values('".$_SESSION['nombre']."','".$ip."','SE GENERO NUEVO CODIGOS DE BARRA ESTABLECIMIENTO: ".strtoupper($_POST["nombre_establecimiento"]).", DEDESDE ".$_POST["0form_nombre_correlativo"]. "' HASTA  ".$_POST["0form_final_correlativo"]. ",'".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION EL EXAMEN DE URUCULTIVO CON REGISTRO N°: ".$_POST["1form_idurocultivo"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>