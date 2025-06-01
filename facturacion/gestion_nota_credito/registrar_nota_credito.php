<?php
if(!session_start()){session_start();}
        
    include("../../objetos/class.conexion.php");	
    
	include("../../objetos/class.numToLet.php");
$objconfig = new conexion();

	
$sql="select P.nrodocumento, P.idpago, P.idcomprobante, P.fechareg, P.horareg, P.monto1, P.idcliente, P.itempago, P.esta_ncredito from pago P where P.idpago='".$_POST["comprobante_select"]."';";
$pago = $objconfig->execute_select($sql,1);

if($pago[1][0]['esta_ncredito']!="0"){
    echo '{"status":false,"msg":"Comprobante ya fue cancelado!!"}';
    return;
}
/*
idnota SERIAL PRIMARY KEY,
  idventa varchar(15) DEFAULT '0',
  iddocumento varchar(12) DEFAULT '0',
  tipodocumento char(2) DEFAULT '-',  
  fechaemision date DEFAULT NULL,
  idtipomoneda smallint DEFAULT 1,
  tipooperacion char(4) DEFAULT '01',
  gravadas decimal(10,2) DEFAULT 0.00,
  gratuitas decimal(10,2) DEFAULT 0.00,
  inafectas decimal(10,2) DEFAULT 0.00,
  exoneradas decimal(10,2) DEFAULT 0.00,
  descuentoglobal decimal(10,2) DEFAULT 0.00,
  totalventa decimal(10,2) DEFAULT 0.00,
  totaligv decimal(10,2) DEFAULT 0.00,
  totalisc decimal(10,2) DEFAULT 0.00,
  totalotrostributos decimal(10,2) DEFAULT 0.00,
  montoletras varchar(150) DEFAULT '-',
  montopercepcion decimal(10,2) DEFAULT 0.00,
  montodetraccion decimal(10,2) DEFAULT 0.00,   
  idusuario bigint DEFAULT 0,
  estado int DEFAULT 0,
  fecharegistro timestamp DEFAULT NOW()
*/
$infNotaCredito=$objconfig->execute_select("select idnota from nota_credito_debito order by idnota desc limit 1;");

    $TDOC="";
    $nroDoc="";
    if($pago[1][0]['idcomprobante']==2){
        $TDOC="03";
        $ncUsuario=$objconfig->execute_select("select SD.seriedoc, SD.valor from seriedoc_personal SDP inner join seriedoc SD on (SDP.idseriedoc=SD.idseriedoc) where SDP.idpersonal='".$_SESSION["id_user"]."' and SD.estado and SD.idtipocomprobante=13 and SD.seriedoc like('B%')");
        //echo json_encode($ncUsuario)."\n";
        if($ncUsuario["1"]){
            $val=((int)$ncUsuario["1"]["valor"])+1;
            $nroDoc = $ncUsuario["1"]["seriedoc"].'-'.str_pad(($val)."",7,"0", STR_PAD_LEFT);
            $sqql="update seriedoc set valor='".($val)."' where idseriedoc=9";
            //echo $sqql."\n";
            $objconfig->execute($sqql);
        }
     }
     if($pago[1][0]['idcomprobante']==3){
        //echo "factura";
        $TDOC="01";
        $ncUsuario=$objconfig->execute_select("select SD.seriedoc, SD.valor from seriedoc_personal SDP inner join seriedoc SD on (SDP.idseriedoc=SD.idseriedoc) where SDP.idpersonal='".$_SESSION["id_user"]."' and SD.estado and SD.idtipocomprobante=13 and SD.seriedoc like('F%')");
        if($ncUsuario["1"]){
            $val=((int)$ncUsuario["1"]["valor"])+1;
            $nroDoc = $ncUsuario["1"]["seriedoc"].'-'.str_pad(($val)."",7,"0", STR_PAD_LEFT);
            $sqql="update seriedoc set valor='".($val)."' where idseriedoc=10";
            $objconfig->execute($sqql);
        }
     }
if($nroDoc==""){
    echo '{"status":false,"msg":"Usuario no tiene asignado la serie de nota de credito!!"}';
    return;
}
$literal = new EnLetras();
$sql1="insert into nota_credito_debito (idventa,iddocumento, tipodocumento, fechaemision,exoneradas, 
descuentoglobal, totalventa, montoletras, idusuario, estado, fecharegistro) 
values('".$pago[1][0]['itempago']."','".$nroDoc."', '".$pago[1][0]['idcomprobante']."', '".$pago[1][0]['fechareg']."', 
'".$pago[1][0]['monto1']."', '0', '".$pago[1][0]['monto1']."', '".$literal->ValorEnLetras($pago[1][0]['monto1'], "con") ."', '".$_SESSION["id_user"]."', '1', '".$pago[1][0]['fechareg']."');";
$objconfig->execute($sql1);

    $relacionados=[];
    $relacion["NroDocumento"]=$pago[1][0]['nrodocumento'];
    $relacion["TipoDocumento"]=$TDOC;
    array_push($relacionados,$relacion);
    $discrepancias=[];
    $discripancia["NroReferencia"]=$pago[1][0]['nrodocumento'];
    $discripancia["Tipo"]="01";
    $discripancia["Descripcion"]=$_POST["observacion"];
    array_push($discrepancias,$discripancia);
    $emisor['NroDocumento']='20494013453';
	$emisor['TipoDocumento']='6';
	$emisor['NombreLegal']='UNIDAD EJECUTORA HOSPITAL II-2 TARAPOTO';
	$emisor['NombreComercial']='UNIDAD EJECUTORA HOSPITAL II-2 TARAPOTO';
	$emisor['CodigoAnexo']='0000';
    $respReceptor= $objconfig->execute_select("select idcliente, razonsocial, ruc, iddocumento from cliente where idcliente='".$pago[1][0]['idcliente']."'");
	$receptor['NroDocumento']=$respReceptor[1]['ruc'];
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
	$receptor['TipoDocumento']=$tipodocR;
	$receptor['NombreLegal']=$respReceptor[1]['razonsocial'];
	$receptor['NombreComercial']=$respReceptor[1]['razonsocial'];
	$receptor['CodigoAnexo']="0000";
    $items=[];
    $sql1="select fecharecepcion, tipoatencion, idtipoatencion, procedencia,estado_examen,idtipoatencion,codbarra,tipexamen,fechaemision,valor,monto,monto1,".
		"descuento,cantidad FROM vista_pagos where itempago='".$pago[1][0]['itempago']."';";
    $regdetalle= $objconfig->execute_select($sql1,1);
   	if(count($regdetalle[1])==0){
		echo '{"status":false,"msg":"Error al listar items, no se pudo cancelar factura"}';
		return;
	}
	 for($i=1;$i<=count($regdetalle[1]);$i++){
        $item['Id']=$i;
        $cantidadItem=1;
        if($regdetalle[1][($i-1)]['cantidad']){
            $cantidadItem=(int)($regdetalle[1][($i-1)]['cantidad']);
        }
        $item['Cantidad']=$cantidadItem;
        $item['UnidadMedida']="ZZ";
        $item['CodigoItem']=$regdetalle[1][($i-1)]['idtipoatencion'];
        $item['Descripcion']=$regdetalle[1][($i-1)]['tipexamen'];
        $item['PrecioUnitario']=$regdetalle[1][($i-1)]['valor'];
        $item['PrecioReferencial']=$regdetalle[1][($i-1)]['valor'];//df PrecioUnitario
        $item['TipoPrecio']="01";
        $item['TipoImpuesto']="20";
        $item['Impuesto']=0;//df
        $item['ImpuestoSelectivo']=0;//df
        $item['TasaImpuestoSelectivo']=0;//df
        $item['OtroImpuesto']=0; //df
        $item['Descuento']=number_format(floatval($regdetalle[1][($i-1)]['descuento']),2,'.','.');
        $item['TotalVenta']=number_format(floatval($regdetalle[1][($i-1)]['monto1']),2,'.','.');
        
        $sql2="insert into nota_detalle (idnota,cantidad,codigoitem,preciounitario,preciopreferencial,tipoprecio,
        tipoimpuesto,descuento,totalventa,impuestoselectivo) values 
        ('".$infNotaCredito["1"]["idnota"]."','".$cantidadItem."','".$regdetalle[1][($i-1)]['idtipoatencion']."',
        '".$regdetalle[1][($i-1)]['valor']."','".$regdetalle[1][($i-1)]['valor']."','ZZ','20','".$item['Descuento']."',
        '".$item['TotalVenta']."','0')";
        $objconfig->execute($sql2);
        array_push($items,$item);
    }
    $data["IdDocumento"]=$nroDoc;
    $data['TipoDocumento']='07';
    $data["FechaEmision"]=$pago[1][0]['fechareg'];
    $data["HoraEmision"]=$pago[1][0]['horareg'];
    //$data["FechaVencimiento"]=$pago[1][0]['fechareg'];
    $data["Moneda"]="PEN";
    $data["TipoOperacion"]="0101";
    $data["Gravadas"]=0;
    $data["Gratuitas"]=0;
    $data["Inafectas"]=0;
    $data["Exoneradas"]=$pago[1][0]['monto1'];
    $data["DescuentoGlobal"]=0; 
    $data["TotalVenta"]=$pago[1][0]['monto1'];
    $data["TotalIgv"]=0;
    $data["TotalIsc"]=0;
    $data["MontoEnLetras"]=$literal->ValorEnLetras($pago[1][0]['monto1'], "con");
    //$data["Credito"]= false;
    $data["Relacionados"]=$relacionados;
    $data["Discrepancias"]=$discrepancias;
    $data["Emisor"]=$emisor;
    $data["Receptor"]=$receptor;
    $data["Items"]=$items;
	//echo "test";    
$res= $objconfig->generar_nota_credito($data);
	$sql1="insert into invoice_sunat(idventa,mensajeerror,tramaxmlsinfirma,crespuesta_sinfirmado,mensajerespuesta) VALUES ('".$pago[1][0]['itempago']."','".$res->MensajeError."','".$res->TramaXmlSinFirma."','0','Nota de credito registrada'); ";
	$objconfig->execute($sql1);
    $sql1="update pago set esta_ncredito='1' where itempago='".$pago[1][0]['itempago']."'";
    $objconfig->execute($sql1);
    //echo json_encode($data);

    echo '{"status":true,"msg":"Comprobante cancelado"}';
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NOTA DE CREDITO DEL COMPROBANTE N: ".$pago[1][0]['nrodocumento']." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICÓ NOTA DE CREDITO DEL COMPROBANTE N°: ".$pago[1][0]['nrodocumento']." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }
?>
