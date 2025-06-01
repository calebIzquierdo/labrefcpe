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
        0 => 'idarea',
        1 => 'cliente',
        2 => 'ruc',
        3 => 'fechaemision',
        4 => 'idcomprobante',
        5 => 'nrodocumento',
        6 => 'idtipopago',
        7 => 'total',
		8 =>'firmar',
		9 => 'enviar',
		10 => 'consultar',
		10 => 'imprimir',
		10 => 'enviaremail',
		11 => 'anularporbaja',
		12=> 'anularpornotacredito'
	);

	$sql = "SELECT idnota FROM nota_credito_debito";
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	/* $consul = "SELECT idpago FROM pagos";
	$query1 = $objconfig->execute_select($consul, 1) ; */


	$sql = "SELECT P.idpago,P.itempago, P.fecharecepcion, A.descripcion as idarea, P.estareg, P.nrodocumento, TC.descripcion as idcomprobante, P.fechaemision, P.idcliente, SUM(P.valor) AS total, TP.descripcion as idtipopago
	FROM nota_credito_debito NCD JOIN pago P ON (NCD.idventa=P.itempago) JOIN areas A ON (P.idarea=A.idarea) JOIN tipo_comprobante TC ON (P.idcomprobante=TC.idcomprobante) JOIN tipo_pago TP ON (P.idtipopago=TP.idtipopago) JOIN cliente C ON (P.idcliente=C.idcliente) ";
    $cabecera = $objconfig->execute_select($sql);
	/* var_dump($requestData['search']); */
	if( !empty($requestData['search']['value']) ) 
	{
		$sql.=" WHERE ( UPPER(A.descripcion) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR P.nrodocumento LIKE ('%".$requestData['search']['value']."%')";
		$sql.=" OR TC.descripcion LIKE UPPER('%".$requestData['search']['value']."%')";
		$sql.=" OR C.razonsocial LIKE UPPER('%".$requestData['search']['value']."%')";
		$sql.=" OR TP.descripcion LIKE ('%".$requestData['search']['value']."%' ))";
	}
	/* $query=$objconfig->execute_select($sql, 1) ; */
    /* $query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData; */
	$sql.= " GROUP BY P.idpago, P.itempago, P.fecharecepcion, A.descripcion, P.estareg, P.nrodocumento, TC.descripcion, P.fechaemision, P.idcliente, TP.descripcion ";

	$sql.=" ORDER BY A.descripcion ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";

//echo $sql;
	$query = $objconfig->execute_select($sql, 1) ;
	//var_dump($query);
	$data = array();
    $count = 1;
	$itemsPago=[];
	foreach($query[1] as $items)
    {
		$ccount=0;
		foreach($itemsPago as $iitem){
			if($iitem==$items["itempago"]){
				$ccount++;
			}
		}
		if($ccount==0){
			array_push($itemsPago,$items["itempago"]);
		}else{
			continue;
		}
		$nestedData=array();
		$cliente = $objconfig->execute_select("SELECT razonsocial, ruc FROM cliente WHERE idcliente = ".$items["idcliente"]);
        $invoice_sunat= $objconfig->execute_select("select tramaxmlfirmado, tramazipcdr,mensajeerror, mensajerespuesta from invoice_sunat where idventa='".$items["itempago"]."' and( tramaxmlfirmado IS NOT NULL) order by invoice_sunat_id asc",1);
		$nestedData[] = $items["idarea"];
		$nestedData[] = $cliente[1]["razonsocial"];
		$nestedData[] = $cliente[1]["ruc"];
		$nestedData[] = $objconfig->FechaDMY2($items["fechaemision"]);
		$nestedData[] = $items["idcomprobante"];
		$nestedData[] = $items["nrodocumento"];
		$nestedData[] = $items["idtipopago"];
		/* $nestedData[] = $items["total"]; */
		if(!$invoice_sunat[1][1]['tramaxmlfirmado']){
			$nestedData[] = "<button type='button'  onclick='firmar_pago(".$items["itempago"].")' class='btn btn-success btn-xs ' data-toggle='tooltip' data-placement='right' title='".$invoice_sunat[1][1]["mensajeerror"]."'>Firmar</button>";

		}else{
			$nestedData[] = "<button type='button'  onclick='firmar_pago(".$items["itempago"].")' class='btn btn-danger btn-xs ' disabled data-toggle='tooltip' data-placement='right' title='".$invoice_sunat[1][1]["mensajerespuesta"]."'>Firmar</button>";
		}
		if(!($invoice_sunat[1][1]['tramazipcdr']!="-")){
			$nestedData[] = "<button type='button'  onclick='enviar_pago(".$items["itempago"].")' class='btn btn-primary btn-xs ' data-toggle='tooltip' data-placement='right' title='".$invoice_sunat[1][1]["mensajeerror"]."'>Enviar</button>";

		}else{
			$nestedData[] = "<button type='button'  onclick='enviar_pago(".$items["itempago"].")' class='btn btn-danger btn-xs ' disabled data-toggle='tooltip' data-placement='right' title='".$invoice_sunat[1][1]["mensajerespuesta"]."'>Enviar</button>";

		}
		$nestedData[] = "<button type='button'  onclick='consultar_pago(".$items["itempago"].")' class='btn btn-info btn-xs '>Consultar</button>";
		$nestedData[]= "<button type='button'  onclick='imprimir(".$items["idpago"].")' class='btn btn-info btn-xs ml-2'  data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' >Imprimir</button";
		$nestedData[]= "<button type='button'  onclick='open_modal_correo(".$items["idpago"].")' class='btn btn-info btn-xs ml-2'  data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#sendCorror' >Enviar correo</button";
		
		//var_dump($nestedData);
		$data[] = $nestedData;
        $count++;
    }
	$json_data = array(
        "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
        "recordsTotal"    => intval( $totalData ),  // total number of records
        "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            => $data   // total data array
    );
	echo json_encode($json_data);  // send data as json format

?>

