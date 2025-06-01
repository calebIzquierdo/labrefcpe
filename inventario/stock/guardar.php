<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "ingreso";
	$objconfig->campoId	= "idingreso";

    if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
		
	} else {
		 $next 	= $_POST["1form_idingreso"];
	}
	
	$query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	$objconfig->execute($query);
	
	$del1 = "delete from ingreso_det where idingreso=".$next;
	$objconfig->execute($del1);
	
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$sql1 = "insert into ingreso_det(idingreso,cantidad,idmaterial,idmarca,serie,idtipobien,fvencimiento,modelo, pcompra , pventa ,
					codpatri ,codpatrilab,idunidad, idtipomaterial,fechacompra)
					values(".$next.",'".$_POST["cantidad".$i]."','".$_POST["idmaterial".$i]."','".$_POST["idmarca".$i]."','".$_POST["serie".$i]."',
					'".$_POST["idtipobien".$i]."','".$_POST["fvencimiento".$i]."','".$_POST["modelo".$i]."','".$_POST["pcompra".$i]."','".$_POST["pventa".$i]."',
					'".$_POST["codpatri".$i]."','".$_POST["codpatrilab".$i]."','".$_POST["idunidad".$i]."','".$_POST["idtipomaterial".$i]."','".$_POST["0form_fechacompra"]."')";
				
			$cant = $objconfig->execute_select("select count(cantidad) as stock from stock_material 
										where idmaterial='".$_POST["idmaterial".$i]."' and idmarca='".$_POST["idmarca".$i]."' and idtipomovimiento=1");
			//echo "# ".$cant[1]["stock"]."\n";
				if ($cant[1]["stock"]==0){
				$sql2 = "insert into stock_material(idejecutora, idred, idmicrored, idestablecimiento,cantidad, idmaterial, idmarca,idtipobien,idunidad,
						idtipomaterial,idtipoingreso,ajuste, idtipomovimiento )
						values('".$_POST["0form_idejecutora"]."','".$_POST["0form_idred"]."','".$_POST["0form_idmicrored"]."','".$_POST["0form_idestablecimiento"]."',
						'".$_POST["cantidad".$i]."','".$_POST["idmaterial".$i]."','".$_POST["idmarca".$i]."','".$_POST["idtipobien".$i]."','".$_POST["idunidad".$i]."',
						'".$_POST["idtipomaterial".$i]."','".$_POST["0form_idtipoingreso"]."','0','1')";
					echo "\n   ".$sql2."\n ";
					$objconfig->execute($sql2);
				} else {
					$cant1 = $objconfig->execute_select("select cantidad as stock from stock_material where idmaterial='".$_POST["idmaterial".$i]."' and idmarca='".$_POST["idmarca".$i]."' and idtipomovimiento=1");
					$new_cant = $_POST["cantidad".$i]+$cant1[1]["stock"];
					 $actu = "update stock_material set cantidad='".$new_cant."'
								where idmaterial='".$_POST["idmaterial".$i]."' and idmarca='".$_POST["idmarca".$i]."' and idtipomovimiento=1";
					 echo "Actualiza".$actu;
					 $objconfig->execute($actu);
				}
		
			$objconfig->execute($sql1);
		}
	
       $sql_stock = "insert into stock_x_marcas(idingreso,idejecutora,idred,idmicrored,idestablecimiento,cantidad,idmaterial,idmarca,idtipobien,
						fechacompra, fvencimiento, idunidad, idtipomaterial,idtipoingreso,idcomprobante,nrocomprobante,ajuste,idtipomovimiento)
						select  id.idingreso,i.idejecutora,i.idred,i.idmicrored,i.idestablecimiento, id.cantidad,id.idmaterial,id.idmarca,id.idtipobien,
						id.fechacompra,id.fvencimiento,id.idunidad,id.idtipomaterial,i.idtipoingreso,i.idcomprobante,i.nrocomprobante,0,1
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO INGRESO DE MATERIALES NUMERO: ".$next." DIGITADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','INGRESO MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION INGRESO DE MATERIAL N°: ".$_POST["1form_idingreso"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','INGRESO MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>