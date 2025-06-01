<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "ingreso";
	$objconfig->campoId	= "idingreso";
	
	//echo json_encode($_POST)."\n";
	 /*
	echo "---1form_idingreso".$_POST["1form_idingreso"]; //1
	exit(); */
	print_r($_POST);
    if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
	} else {
		$next 	= $_POST["1form_idingreso"];
	}
	
	$query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	//echo "\n".$query."\n";
	$objconfig->execute($query);
	//if($_POST["op"]==1){
		//$del1 = "delete from ingreso_det where idingreso=".$next;
		//$objconfig->execute($del1);
	//}
	
	$materialesNoDelete='';
	// echo "Cant_Det: ".$_POST["contar_diagnostico"]."\n 10, 1,3";
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{	

			echo "\n ".$i." **********************Inicio***************\n";
			if(isset($_POST["idmaterial".$i]))
			{
				$lotes = trim($_POST["lote".$i]);
				$seriepost=$_POST["serie".$i];

				///////////////VALIDACION SI DEL FOFRMULARIO VIENE serie o lote  '','-','.'
				if($lotes=='' || $lotes='-' || $lotes='.' || $lotes='.-'){
					$lotes='';
				}
				if($seriepost=='' || $seriepost='-' || $seriepost='.' || $seriepost='.-'){
					$seriepost='';
				}
				$fvencimiento= $_POST["fvencimiento".$i]; 
				
				$vence = $objconfig->execute_select("SELECT idvence from materiales where idmaterial='".$_POST["idmaterial".$i]."'" );
							
				if($vence[1]["idvence"]==1){
					$and = " and lote='".$lotes."'";
					$and1 =" and fvencimiento='".$fvencimiento."'";
				}else {
					$and ="";
					$and1 ="";
				}
			
			$sql3 = "SELECT cantidad,serie from ingreso_det where idingreso=".$next." and idmaterial=".$_POST["idmaterial".$i]." and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."'". $and.$and1;
			echo "CONSULTA CANTIDAD	:".$sql3;
			$cant = $objconfig->execute_select($sql3,1);

			echo json_encode(" CANTIDAD: ".$cant[1]["cantidad"])."\n";
			$materialesNoDelete.=" and idmaterial!='".$_POST["idmaterial".$i]."' ";
			echo "IDMarcar: ".$_POST["idmarca".$i]."\n";
			echo "IDModelo: ".$_POST["idmodelo".$i]."\n";
			echo "IDMaterial: ".$_POST["idmaterial".$i]."\n";

			if($cant[1]['cantidad']){
				//actualiza detalle
				$sql1 = "update ingreso_det set cantidad='".$_POST["cantidad".$i]."',serie='".$cant[1]["serie"].",".$seriepost."'  where idmaterial=".$_POST["idmaterial".$i]." and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."'". $and.$and1;

			}else{
				//registra detalle
				$sql1 = "insert into ingreso_det(idingreso,cantidad,idmaterial,idmarca,serie,idtipobien,fvencimiento,idmodelo, pcompra , pventa ,
									codpatri ,codpatrilab,idunidad, idtipomaterial,fechacompra,lote)
									values(".$next.",'".$_POST["cantidad".$i]."','".$_POST["idmaterial".$i]."','".$_POST["idmarca".$i]."','".$seriepost."',
									'".$_POST["idtipobien".$i]."','".$_POST["fvencimiento".$i]."','".$_POST["idmodelo".$i]."','".$_POST["pcompra".$i]."','".$_POST["pventa".$i]."',
									'".$_POST["codpatri".$i]."','".$_POST["codpatrilab".$i]."','".$_POST["idunidad".$i]."','".$_POST["idtipomaterial".$i]."',
									'".$_POST["0form_fechacompra"]."','".$lotes."')";
			}
			
			
			// consulta cantidad en el stock
			$cant = $objconfig->execute_select("select count(cantidad) as stock,serie from stock_material where idmaterial='".$_POST["idmaterial".$i]."' and 
								idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."' ". $and.$and1,1);
			
											
			
				if ($cant[1]["stock"]==0){
					echo "Insertar Stock ==0";
					$sql2 = "insert into stock_material(idejecutora, idred, idmicrored, idestablecimiento,cantidad, idmaterial, idmarca,idtipobien,idunidad,
						idtipomaterial,idtipoingreso,ajuste, idtipomovimiento,idmodelo,lote,fvencimiento,serie)
						values('".$_POST["0form_idejecutora"]."','".$_POST["0form_idred"]."','".$_POST["0form_idmicrored"]."','".$_POST["0form_idestablecimiento"]."',
						'".$_POST["cantidad".$i]."','".$_POST["idmaterial".$i]."','".$_POST["idmarca".$i]."','".$_POST["idtipobien".$i]."','".$_POST["idunidad".$i]."',
						'".$_POST["idtipomaterial".$i]."','".$_POST["0form_idtipoingreso"]."','0','1','".$_POST["idmodelo".$i]."','".$lotes."','".$_POST["fvencimiento".$i]."','".$seriepost."')";
					echo "\n Nuevo articulo  -> ".$sql2."\n ";
					$objconfig->execute($sql2);
				} else {
					echo "Actualizar Stock >=0";
					//exit();
					//actualizacion de stock
					//consultar cantidad registrada en el anterior ingreso_det
					$sql3 = "SELECT cantidad,serie from ingreso_det where idingreso=".$next." and idmaterial=".$_POST["idmaterial".$i]." and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."' ". $and.$and1;
					echo "CONSULTAAAA	:".$sql3."\n";
					$cant = $objconfig->execute_select($sql3,1);
					echo json_encode($cant)."\n "."";
							//Eliminar el anterio ingreso_det
							/* $del1 = "delete from ingreso_det where idingreso=".$next;
							$objconfig->execute($del1); */
					//consultar el stock actual
						$cant1 = $objconfig->execute_select("select cantidad as stock from stock_material where idmaterial='".$_POST["idmaterial".$i]."' and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."' ". $and.$and1);
					//restar la cantidad anterior con el stock actual
						echo "Stock ant: ".$cant1[1]["stock"]." - ".$cant["1"]["cantidad"];
						$new_cant =$cant1[1]["stock"]-$cant["1"]["cantidad"];
						echo " = ".$new_cant."\n";
					//sumar el stock obtenido con la nueva cantidad
						echo "Stock act: ".$_POST["cantidad".$i]." + ".$new_cant;
						$new_cant = $_POST["cantidad".$i]+$new_cant;
						echo " = ".$new_cant."\n";
					 $actu = "update stock_material set cantidad='".$new_cant."',serie='".$cant["1"]["serie"].",".$seriepost."'
								where idmaterial='".$_POST["idmaterial".$i]."' and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."'  ". $and.$and1;
					 echo "Actualiza -> ".$actu;
					 $objconfig->execute($actu);
				}
				echo "\n   ".$sql1."\n ";
				$objconfig->execute($sql1); 
			}
		}
		//obteniendo los items eliminados en el frontend que fueron registrados en la db
		$deleteItems="select cantidad, idmaterial, idmarca, idmodelo,lote  from ingreso_det where idingreso=".$next.$materialesNoDelete;
		echo "ELIMINAR ITEMS DB: ".$deleteItems."\n";
		$resDeleteItems = $objconfig->execute_select($deleteItems,1);
		foreach($resDeleteItems["1"] as $item){
					//consultar cantidad registrada en el anterior ingreso_det
					$sql3 = "SELECT cantidad,serie from ingreso_det where idingreso=".$next." and idmaterial=".$item["idmaterial"].";";
					echo "CONSULTAAAA	:".$sql3."\n";
					$cant = $objconfig->execute_select($sql3,1);
					//consultar el stock actual
					$cant1 = $objconfig->execute_select("select cantidad,serie as stock from stock_material where idmaterial='".$item["idmaterial"]."' ",1);
					$up_stock =$cant1[1]["stock"]-$item["cantidad"];
					$actu = "update stock_material set cantidad='".$up_stock."',serie='".$cant1[1]["serie"].",".$seriepost."'
							where idmaterial='".$item["idmaterial"]."' and idmarca='".$item["idmarca"]."' and idmodelo='".$item["idmodelo"]."' ".$and.$and1;
					echo "Actualiza -> ".$actu;
					$objconfig->execute($actu);
					
		}
		echo "\n===============FIN==================\n";
		echo json_encode($resDeleteItems)."\n";
		//Eliminando detalles eliminados en el front_end
		//$del1 = "delete from ingreso_det where idingreso=".$next.$materialesNoDelete;
		$del1 = "delete from ingreso_det where idingreso=".$next.$materialesNoDelete;
		echo $del1;
		$objconfig->execute($del1);
       $sql_stock = "insert into stock_x_marcas(idingreso,idejecutora,idred,idmicrored,idestablecimiento,cantidad,idmaterial,idmarca,idtipobien,
						fechacompra, fvencimiento, idunidad, idtipomaterial,idtipoingreso,idcomprobante,nrocomprobante,ajuste,idtipomovimiento,idmodelo,lote)
						select  id.idingreso,i.idejecutora,i.idred,i.idmicrored,i.idestablecimiento, id.cantidad,id.idmaterial,id.idmarca,id.idtipobien,
						id.fechacompra,id.fvencimiento,id.idunidad,id.idtipomaterial,i.idtipoingreso,i.idcomprobante,i.nrocomprobante,0,1,id.idmodelo,id.lote
						from ingreso_det as id
						inner join ingreso as i on i.idingreso=id.idingreso
					where i.idingreso=".$next;
		$objconfig->execute($sql_stock);
		
		
		
		
		
	

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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO INGRESO DE MATERIALES AL ALMACEN CON NUMERO: ".$next." DIGITADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','INGRESO MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION INGRESO AL ALMACEN DE  MATERIAL N°: ".$_POST["1form_idingreso"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','INGRESO MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>