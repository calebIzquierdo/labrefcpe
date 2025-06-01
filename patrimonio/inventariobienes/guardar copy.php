<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "inventario_cabecera";
	$objconfig->campoId	= "idinventario";
	/*
	OP: 2
	VM24683:128 CODIGO: 1
	*/
	$codd=$_POST["cod"];
	echo json_encode($_POST)."\n";

	//optiene el correlativo
    if($_POST["op"]==1)
    {
		//crear
        $next 	= $objconfig->setCorrelativos();
		
	} else {
		//actualizar
		 $next 	= $_POST["Hcorrelativo"];

	}
//parseo la data para aprovechar la funcion mantenimiento de la clase conexion
//el cual retorna un string con la consulta de registro
if($_POST["op"]==1){
	//registro
	$dataHeader["1form_nroinventario"]=$_POST["Hcorrelativo"];
}else{
	//actualizacion
	$dataHeader["1form_idinventario"]=$_POST["cod"];
	$dataHeader["0form_nroinventario"]=$_POST["Hcorrelativo"];

	//elimino el detalle del registro
	$sql1 = "DELETE FROM inventario_detalle where idinventario='".$_POST["cod"]."'";
	$objconfig->execute($sql1); 
}

$dataHeader["0form_idejecutora"]=$_POST["Hidejecutora"];
$dataHeader["0form_idred"]=$_POST["Hidred"];
$dataHeader["0form_idmicrored"]=$_POST["Hidmicrored"];
$dataHeader["0form_idestablecimiento"]=$_POST["Hidestablecimiento"];
$dataHeader["0form_idusuario"]=$_POST["Hidusuario"];
$dataHeader["0form_fechainventario"]=$_POST["Hfecharecepcion"];
$dataHeader["0form_estado"]="1";
$query 	= $objconfig->genera_mantenimiento2($_POST["op"],$dataHeader);
echo "\n".$query."\n";
	echo "\n".$query."\n";
	$objconfig->execute($query);
	//luego de registrar un nuevo registro obtendo el id para los detalles
	// al actualizar se utiliza el atributo enviado por post
	$queryT = "select idinventario from inventario_cabecera where nroinventario='".$_POST["Hcorrelativo"]."' LIMIT 1";
    echo $queryT;
	$itemsT = $objconfig->execute_select($queryT,1);
	//echo json_encode($itemsT);
	echo "Cant_Det: ".count($_POST["detalle"])."\n";
		for($i=0;$i<count($_POST["detalle"]);$i++)
		{	echo "\n***********************Inicio***************\n";
			
			
			if($_POST["op"]==1){
				//registrar detalle
				//creo otro objeto de conexion para asignar mis nueva tablas y
				//aprovechar la clase conexion
				//el cual retorna un string con la consulta de registro
				$objconfig2 = new conexion();

				$objconfig2->table 	= "inventario_detalle";
				$objconfig2->campoId	= "idinventariodetalle";

				$dataDetalle["1form_idinventario"]=$itemsT["1"][0]["idinventario"];
				$dataDetalle["0form_idarea"]=$_POST["detalle"][$i]["idarea"];
				$dataDetalle["0form_idareatrabajo"]=$_POST["detalle"][$i]["idareatrabajo"];
				$dataDetalle["0form_idpersonal"]=$_POST["detalle"][$i]["idpersonal"];
				$dataDetalle["0form_idmaterial"]=$_POST["detalle"][$i]["material"];
				$dataDetalle["0form_idmarca"]=$_POST["detalle"][$i]["marca"];
				$dataDetalle["0form_idmodelo"]=$_POST["detalle"][$i]["modelo"];
				$dataDetalle["0form_codpatrimonial"]=$_POST["detalle"][$i]["codpatri"];
				$dataDetalle["0form_codpatrimoniallab"]=$_POST["detalle"][$i]["codpatrilab"];
				$dataDetalle["0form_nroserie"]=$_POST["detalle"][$i]["serie"];
				$dataDetalle["0form_color"]=$_POST["detalle"][$i]["color"];
				$dataDetalle["0form_estado"]=$_POST["detalle"][$i]["nombre_estado"];
				$dataDetalle["0form_observacion"]=$_POST["detalle"][$i]["observacion"];
				$sql1 = $objconfig2->genera_mantenimiento2($_POST["op"],$dataDetalle);
				echo "\n   ".$sql1."\n ";
				$objconfig->execute($sql1); 
				
			}else{
				//actualizar detalle
				//creo otro objeto de conexion para asignar mis nueva tablas y
				//aprovechar la clase conexion
				//el cual retorna un string con la consulta de registro
				$objconfig2 = new conexion();

				$objconfig2->table 	= "inventario_detalle";
				$objconfig2->campoId	= "idinventariodetalle";
				$dataDetalle["1form_idinventario"]=$codd;
				$dataDetalle["0form_idarea"]=$_POST["detalle"][$i]["idarea"];
				$dataDetalle["0form_idareatrabajo"]=$_POST["detalle"][$i]["idareatrabajo"];
				$dataDetalle["0form_idpersonal"]=$_POST["detalle"][$i]["idpersonal"];
				$dataDetalle["0form_idmaterial"]=$_POST["detalle"][$i]["material"];
				$dataDetalle["0form_idmarca"]=$_POST["detalle"][$i]["marca"];
				$dataDetalle["0form_idmodelo"]=$_POST["detalle"][$i]["modelo"];
				$dataDetalle["0form_codpatrimonial"]=$_POST["detalle"][$i]["codpatri"];
				$dataDetalle["0form_codpatrimoniallab"]=$_POST["detalle"][$i]["codpatrilab"];
				$dataDetalle["0form_nroserie"]=$_POST["detalle"][$i]["serie"];
				$dataDetalle["0form_color"]=$_POST["detalle"][$i]["color"];
				$dataDetalle["0form_estado"]=$_POST["detalle"][$i]["nombre_estado"];
				$dataDetalle["0form_observacion"]=$_POST["detalle"][$i]["observacion"];
				$sql1 = $objconfig2->genera_mantenimiento2(1,$dataDetalle);
				echo "\n   ".$sql1."\n ";
				$objconfig2->execute($sql1); 
			} 			
			
				
			

			echo "\n***********************FIN***************\n";
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO INGRESO DE INVENTARIO: ".$next." DIGITADO POR: ".strtoupper($_POST["Hnombre_usuario"])."','".date("h:i:s A")."','INVENTARIO DE BIENES','".$_POST["Hnombre_usuario"]."','".$_POST["Hidusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION INGRESO DE INVENTARIO N°: ".$_POST["Hcorrelativo"]." DIGITADO POR:  ".strtoupper($_POST["Hnombre_usuario"])."','".date("h:i:s A")."','INGRESO DE BIENES','".$_POST["Hnombre_usuario"]."','".$_POST["Hidusuario"]."')");
        }

?>