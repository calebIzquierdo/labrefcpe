<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
		
	if($_POST["op"]==1){
		//registrar detalle
		//creo otro objeto de conexion para asignar mis nueva tablas y
		//aprovechar la clase conexion
		//el cual retorna un string con la consulta de registro
		

		$objconfig->table 	= "inventario_detalle";
		$objconfig->campoId	= "idinventariodetalle";

		$dataDetalle["1form_idinventario"]=$_POST["cod"];
		$dataDetalle["0form_idarea"]=$_POST["idarea"];
		$dataDetalle["0form_idareatrabajo"]=$_POST["idareatrabajo"];
		$dataDetalle["0form_idpersonal"]=$_POST["idpersonal"];
		$dataDetalle["0form_idmaterial"]=$_POST["material"];
		$dataDetalle["0form_idmarca"]=$_POST["marca"];
		$dataDetalle["0form_idmodelo"]=$_POST["modelo"];
		$dataDetalle["0form_codpatrimonial"]=$_POST["codpatri"];
		$dataDetalle["0form_codpatrimoniallab"]=$_POST["codpatrilab"];
		$dataDetalle["0form_nroserie"]=$_POST["serie"];
		$dataDetalle["0form_color"]=$_POST["color"];
		$dataDetalle["0form_estado"]=$_POST["nombre_estado"];
		$dataDetalle["0form_observacion"]=$_POST["observacion"];
		$sql1 = $objconfig->genera_mantenimiento2($_POST["op"],$dataDetalle);
		echo "\n   ".$sql1."\n ";
		$objconfig->execute($sql1); 
		
	}elseif($_POST["op"]==2){
		
		$del1 = "delete from inventario_detalle where idinventariodetalle=".$_POST["cod"];
		
		$objconfig->execute($del1);
		echo "Se quito el item seleccionado!!!";
	}
			

	echo "\n***********************FIN***************\n";


	

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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO INGRESO DE INVENTARIO: ".$next." DIGITADO POR: ".strtoupper($_POST["Hnombre_usuario"])."','".date("h:i:s A")."','INVENTARIO DE BIENES','".$_POST["Hnombre_usuario"]."','".$_POST["Hidusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION INGRESO DE INVENTARIO N°: ".$_POST["Hcorrelativo"]." DIGITADO POR:  ".strtoupper($_POST["Hnombre_usuario"])."','".date("h:i:s A")."','INGRESO DE BIENES','".$_POST["Hnombre_usuario"]."','".$_POST["Hidusuario"]."')");
        }
		
	

?>