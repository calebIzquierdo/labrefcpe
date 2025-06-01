<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

	$objconfig = new conexion();

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
        0 => 'Area',
        1 => 'cliente',
        2 => 'ruc',
        3 => 'fechaemision',
        4 => 'idcomprobante',
        5 => 'nrodocumento',
        6 => 'idtipopago',
        7 => 'total',
		8 => 'firmar',
		9 => 'enviar',
		10 => 'consultar',
		10 => 'imprimir',
		10 => 'enviaremail',
		11 => 'anularporbaja',
		12 => 'anularpornotacredito'
	);

	$sql = "select * from vista_pagos_cpe";

	
	$sql = "select * from vista_pagos_cpe";
   
	if( !empty($requestData['search']['value']) ) 
	{
		$sql.=" WHERE ( UPPER(area) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR nrodocumento LIKE ('%".$requestData['search']['value']."%')";	
		
		$sql.=" )";
		
	}
	//echo $sql;	
	// when there is a search parameter then we have to modify total number filtered rows as per search result.
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;
	
	$sql.=" ORDER BY itempago desc  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";

	$query = $objconfig->execute_select($sql,1) ;

	$data = array();

	foreach($query[1] as $items)
    { 
		
		$nestedData=array();
		$cliente = $objconfig->execute_select("SELECT razonsocial, ruc FROM cliente WHERE idcliente = ".$items["idcliente"]);
        
    	$invoice_sunat= $objconfig->execute_select("select tramaxmlfirmado, tramazipcdr,mensajeerror, mensajerespuesta from invoice_sunat where idventa='".$items["itempago"]."' and( tramaxmlfirmado IS NOT NULL)",1);
    
		$nestedData[] = $items["area"];
		$nestedData[] = $cliente[1]["razonsocial"];
		$nestedData[] = $cliente[1]["ruc"];
		$nestedData[] = $objconfig->FechaDMY2($items["fechaemision"]);
		$nestedData[] = $items["idcomprobante"];
		$nestedData[] = $items["nrodocumento"];
		$nestedData[] = $items["idtipopago"]; 
		$nestedData[] = $items["total"]; 
		if(!$invoice_sunat[1][0]['tramaxmlfirmado']){
			$nestedData[] = "<button type='button'  onclick='firmar_pago(".$items["itempago"].")' class='btn btn-success btn-xs ' data-toggle='tooltip' data-placement='right' title='".$invoice_sunat[1][0]["mensajeerror"]."'>Firmar</button>";

		}else{
			$nestedData[] = "<button type='button'  onclick='firmar_pago(".$items["itempago"].")' class='btn btn-danger btn-xs ' disabled data-toggle='tooltip' data-placement='right' title='".$invoice_sunat[1][0]["mensajerespuesta"]."'>Firmar</button>";
		}
		if(!($invoice_sunat[1][0]['tramazipcdr']!="-")){
			$nestedData[] = "<button type='button'  onclick='enviar_pago(".$items["itempago"].")' class='btn btn-primary btn-xs ' data-toggle='tooltip' data-placement='right' title='".$invoice_sunat[1][0]["mensajeerror"]."'>Enviar</button>";

		}else{
			$nestedData[] = "<button type='button'  onclick='enviar_pago(".$items["itempago"].")' class='btn btn-danger btn-xs ' disabled data-toggle='tooltip' data-placement='right' title='".$invoice_sunat[1][0]["mensajerespuesta"]."'>Enviar</button>";

		}
		$nestedData[] = "<button type='button'  onclick='consultar_pago(".$items["itempago"].")' class='btn btn-info btn-xs '>Consultar</button>";
		$nestedData[]= "<button type='button'  onclick='imprimir(".$items["itempago"].")' class='btn btn-info btn-xs ml-2'  data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' >Imprimir</button";
		$nestedData[]= "<button type='button'  onclick='open_modal_correo(".$items["itempago"].")' class='btn btn-info btn-xs ml-2'  data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#sendCorror' >Enviar correo</button";
		
		//var_dump($nestedData);
		$data[] = $nestedData;
        //$count++;
    }
	
	
	$json_data = array(
        "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
        "recordsTotal"    => intval( $totalData ),  // total number of records
        "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            => $data   // total data array
    );
	echo json_encode($json_data);  // send data as json format
?>

