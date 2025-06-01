<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	include("../../objetos/class.numToLet.php");
	$objconfig = new conexion();

	$objconfig->table 	= "pago";
	$objconfig->campoId	= "itempago";
	$item_next 	= $objconfig->setCorrelativos();

	

	 if($_POST["op"]==1)
    {
		
		
		
		if ($_POST["0form_idcomprobante"]!=7){
			for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
			{
				$sql1 = "insert into pago(itempago,idejecutora,idred,idmicrored,idestablecimiento,idtipo,idmuestradetalle,idingresomuestra,idtipo_examen, 
					idusuario,  nombre_usuario,idarea,idareatrabajo,codbarra,fechaemision,idcliente,idestablesolicita,idcomprobante,nrodocumento,descuento,monto1,monto,
					fecharecepcion,idtipoatencion,idtipopago,observacion,valor )
					values(".$item_next.",'".$_POST["0form_idejecutora"]."','".$_POST["0form_idred"]."','".$_POST["0form_idmicrored"]."','".$_POST["0form_idestablecimiento"]."',
					'".$_POST["0form_idtipo"]."','".$_POST["idmuestradetalle".$i]."','".$_POST["idingresomuestra".$i]."','".$_POST["idtipo_examen".$i]."',
					'".$_POST["0form_idusuario"]."','".$_POST["0form_nombre_usuario"]."','".$_POST["idarea".$i]."','".$_POST["idareatrabajo".$i]."',
					'".$_POST["codbarra".$i]."','".$_POST["0form_fechaemision"]."','".$_POST["0form_idcliente"]."','".$_POST["0form_idestablesolicita"]."',
					'".explode('-',$_POST["0form_idcomprobante"])[0]."','".$_POST["0form_seriedocumento"]."-".substr(str_repeat(0, 7).$_POST["0form_nrodocumento"], - 7)."', '".$_POST["0form_descuento"]."' ,'".$_POST["0form_monto1"]."',
					'".$_POST["0form_monto"]."','".$_POST["fecharecepcion".$i]."','".$_POST["idtipoatencion".$i]."','".$_POST["0form_idtipopago"]."',
					'".$_POST["0form_observacion"]."','".$_POST["valor".$i]."'
				)";
				echo "Sin exonerar: ".$sql1."\n ";
				$objconfig->execute($sql1);
				$objconfig->execute("update muestra set idpago=".$item_next." where idingresomuestra=".$_POST["idingresomuestra".$i]);
		
			}
		} 
		
		else{
			
			for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
			{
				$sql2 = "insert into pago(itempago,idejecutora,idred,idmicrored,idestablecimiento,idtipo,idmuestradetalle,idingresomuestra,idtipo_examen, 
					idusuario,  nombre_usuario,idarea,idareatrabajo,codbarra,fechaemision,idcliente,idestablesolicita,idcomprobante,nrodocumento,descuento,monto1,monto,
					fecharecepcion,idtipoatencion,idtipopago,observacion,idtipo_exonera,idpersonal	)
					values(".$item_next.",'".$_POST["0form_idejecutora"]."','".$_POST["0form_idred"]."','".$_POST["0form_idmicrored"]."','".$_POST["0form_idestablecimiento"]."',
					'".$_POST["0form_idtipo"]."','".$_POST["idmuestradetalle".$i]."','".$_POST["idingresomuestra".$i]."','".$_POST["idtipo_examen".$i]."',
					'".$_POST["0form_idusuario"]."','".$_POST["0form_nombre_usuario"]."','".$_POST["idarea".$i]."','".$_POST["idareatrabajo".$i]."',
					'".$_POST["codbarra".$i]."','".$_POST["0form_fechaemision"]."','".$_POST["0form_idcliente"]."','".$_POST["0form_idestablesolicita"]."',
					'".$_POST["0form_idcomprobante"]."','".$_POST["0form_seriedocumento"]."-".substr(str_repeat(0, 7).$_POST["0form_nrodocumento"], - 7)."', '".$_POST["0form_descuento"]."' ,'".$_POST["0form_monto1"]."',
					'".$_POST["0form_monto"]."','".$_POST["fecharecepcion".$i]."','".$_POST["idtipoatencion".$i]."','".$_POST["0form_idtipopago"]."',
					'".$_POST["0form_observacion"]."','".$_POST["0form_idtipo_exonera"]."','".$_POST["0form_idpersonal"]."'
					)";
				echo "Exonera: ".$sql2."\n ";
				$objconfig->execute($sql2);
				$objconfig->execute("update muestra set idpago=".$item_next." where idingresomuestra=".$_POST["idingresomuestra".$i]);
		
			}
		}
	}	
	
	//actualizando valor de seriedoc
	$idseriedoc=(int)$_POST["0form_idseriedocumento"];
	$valor=(int)$_POST["0form_nrodocumento"];
	$objconfig->execute("update seriedoc set valor=".$valor." where idseriedoc='".$idseriedoc."'");
	
	$literal = new EnLetras();
	//generando la factura del pago
	$dataEmisor['NroDocumento']='20494013453';
	$dataEmisor['TipoDocumento']='6';
	$dataEmisor['NombreLegal']='OFICINA DE GESTIÓN DE SERVICIOS DE SALUD ESPECIALIZADA DE ALCANCE REGIONAL-OGESS ESPECIALIZADA';
	$dataEmisor['NombreComercial']='OFICINA DE GESTIÓN DE SERVICIOS DE SALUD ESPECIALIZADA DE ALCANCE REGIONAL-OGESS ESPECIALIZADA';
	$dataEmisor['CodigoAnexo']='0000';
	$respReceptor= $objconfig->execute_select("select idcliente, razonsocial, ruc, iddocumento from cliente where idcliente='".$_POST['0form_idcliente']."'");
	//var_dump($respReceptor[1]);
	$dataReceptor['NroDocumento']=$respReceptor[1]['ruc'];
	//$dataReceptor['NroDocumento']='10418889824';
	$tipodocR="0";
	if($respReceptor[1]['iddocumento']==1){
		$tipodocR="1";
	}
	if($respReceptor[1]['iddocumento']==2){
		$tipodocR="4";
	}
	if($respReceptor[1]['iddocumento']==3){
		$tipodocR="7";
	}
	if($respReceptor[1]['iddocumento']==4){
		$tipodocR="6";
	}
	$dataReceptor['TipoDocumento']=$tipodocR;
	//$dataReceptor['TipoDocumento']="6";
	$dataReceptor['NombreLegal']=$respReceptor[1]['razonsocial'];
	//$dataReceptor['NombreLegal']='JOSUE SEGUNDO ACUÑA CORDOVA';
	$dataItems=[];
	for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
	{
		$item['Id']=$i;
		$item['Cantidad']=$_POST['cantidad'.$i];
		$item['UnidadMedida']='ZZ';
		$item['CodigoItem']='';
		$item['Descripcion']=$_POST['tipo_examen'.$i];
		$item['PrecioUnitario']=$_POST['valor'.$i];
		$item['PrecioReferencial']=$_POST['valor'.$i];
		$item['TipoPrecio']='01';
		$item['TipoImpuesto']='20';
		$item['Impuesto']=0;
		$item['Descuento']=0;
		$item['TotalVenta']=$_POST['subtotal'.$i];
		array_push($dataItems,$item);
	}
	$data['IdDocumento']=$_POST["0form_seriedocumento"]."-".substr(str_repeat(0, 7).$_POST["0form_nrodocumento"], - 7);
	/* B-03
	F-01 */
	/* echo $_POST["0form_idtipo"]."\n"; */
	$data['TipoDocumento']="";
	if(explode('-',$_POST["0form_idcomprobante"])[0]==2){
        $data['TipoDocumento']="03";
     }
     if(explode('-',$_POST["0form_idcomprobante"])[0]==3){
        $data['TipoDocumento']="01";
     }
	//$data['TipoDocumento']=$_POST["0form_idtipo"];
	$fechagenerar=explode('/',$_POST["0form_fechaemision"]);
	$fechagenerar=$fechagenerar[2].'/'.$fechagenerar[1].'/'.$fechagenerar[0];
	$data['FechaEmision']=$fechagenerar;
	$data['HoraEmision']='12:00:00';
	$data['FechaVencimiento']=$fechagenerar;
	$data['Moneda']='PEN';
	$data['TipoOperacion']='0101';
	$data['Exoneradas']=$_POST['0form_monto'];
	$data['TotalVenta']=$_POST['0form_monto'];
	$data['TotalIgv']=0;
	$data['MontoEnLetras']=$literal->ValorEnLetras($_POST['0form_monto'], "con");
	$data['Credito']=false;
	$data['Emisor']=$dataEmisor;
	$data['Receptor']=$dataReceptor;
	$data['Items']=$dataItems;
	//echo json_encode($_POST);
	echo json_encode($data);
	$res= $objconfig->generar_factura($data);
	$sql1="insert into invoice_sunat(idventa,mensajeerror,tramaxmlsinfirma,crespuesta_sinfirmado,mensajerespuesta) VALUES ('".$item_next."','".$res->MensajeError."','".$res->TramaXmlSinFirma."','0','Factura generada'); ";
	$objconfig->execute($sql1);
	
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NUEVO COMPRBANTE DE PAGO NUMERO: ".$_POST["0form_nrodocumento"]." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION EL EXAMEN DE URUCULTIVO CON REGISTRO N°: ".$_POST["1form_idurocultivo"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>
