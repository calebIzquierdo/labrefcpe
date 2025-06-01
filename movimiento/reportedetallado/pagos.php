<?php

    //session_start();
    //$idperfil = $_SESSION['idperfil'];


	include("../../objetos/class.conexion.php");


		
	$objconfig = new conexion();

    $idcomp=$_GET["idcomprobante"];
	$f1=$_GET["finicioA"];
	$f2=$_GET["ffinalA"];

	$and = "";
	if($idcomp !=0){
		$and = " vp.idcomprobante = ".$idcomp." and ";
	}
	
	
	$consul = "select vp.nrodocumento,vp.fechaemision,vp.tip_comprob,vp.descuento,vp.monto1,vp.monto,vp.valor,c.razonsocial,
	vp.fecharecepcion,vp.fechareg,vp.horareg,vp.tipoatencion,vp.estado_examen,vp.tipexamen,vp.procedencia,nombre_usuario,vp.tipo_pago,vp.tipo_documento
	from vista_pagos vp
	inner join cliente c on c.idcliente=vp.idcliente
	where ".$and." vp.fechaemision between '".$f1."' and '".$f2."'";

	
	$query=$objconfig->execute_select($consul,1) ;
    
    $data = array();
	foreach($query[1] as $items)
		{		
		$nestedData=array();
		
		$nestedData[] = $items["nrodocumento"];
		$nestedData[] = $items["fechaemision"];
		$nestedData[] = $items["tip_comprob"];
                $nestedData[] = $items["tipo_pago"];
		$nestedData[] = $items["descuento"];	
		$nestedData[] = $items["monto1"];
		$nestedData[] = $items["monto"];
		$nestedData[] = $items["valor"];
		$nestedData[] = $items["razonsocial"];	
		$nestedData[] = $items["fecharecepcion"];
		$nestedData[] = $items["fechareg"];
		$nestedData[] = $items["horareg"];
		$nestedData[] = $items["tipoatencion"];	
		$nestedData[] = $items["estado_examen"];
		$nestedData[] = $items["tipexamen"];
		$nestedData[] = $items["procedencia"];
		$nestedData[] = $items["nombre_usuario"];	
                $nestedData[] = $items["tipo_documento"];		
		$data[] = $nestedData;
		}
    
	echo json_encode($data);  // send data as json format

?>

