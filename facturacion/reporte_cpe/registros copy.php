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
        /* 7 => 'total',
		8 =>'firmar',
		9 => 'enviar',
		10 => 'consultar',
		10 => 'imprimir',
		10 => 'enviaremail',
		11 => 'anularporbaja',
		12=> 'anularpornotacredito' */
	);

	$sql = "SELECT idpago FROM pago";
	$query = $objconfig->CantidadFilas($sql);
	$sql1 = "SELECT idnota FROM nota_credito_debito";
	$query1 = $objconfig->CantidadFilas($sql1);
	$totalData = ((int)$query)+((int)$query1) ;
	$totalFiltered = $totalData;


	$consul = "SELECT idpago FROM pago";
	$query1 = $objconfig->execute_select($consul, 1) ;


	$sql = "SELECT distinct P.itempago, P.idpago, P.fecharecepcion, A.descripcion as idarea, P.estareg, P.nrodocumento, TC.descripcion as idcomprobante, P.fechaemision, P.idcliente, SUM(P.valor) AS total, TP.descripcion as idtipopago
	FROM pago P JOIN areas A ON (P.idarea=A.idarea) JOIN tipo_comprobante TC ON (P.idcomprobante=TC.idcomprobante) JOIN tipo_pago TP ON (P.idtipopago=TP.idtipopago) JOIN cliente C ON (P.idcliente=C.idcliente) ";
    //$cabecera = $objconfig->execute_select($sql);
	/* var_dump($requestData['search']); */
	$fDate=" ";
	if($_GET["fInicio"]){
		$fDate=" where P.fechaemision >= '".$_GET["fInicio"]."' ";

	}
	if($_GET["fFin"]){
		$fDate=" where P.fechaemision <= '".$_GET["fFin"]."' ";

	}
	if($_GET["fInicio"] && $_GET["fFin"]){
		$fDate=" where P.fechaemision >= '".$_GET["fInicio"]."' and P.fechaemision <= '".$_GET["fFin"]."' ";

	}
	$sql.=$fDate;
	if( !empty($requestData['search']['value']) ) 
	{
		$sql.=" WHERE ( UPPER(A.descripcion) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR P.nrodocumento LIKE ('%".$requestData['search']['value']."%')";
		$sql.=" OR TC.descripcion LIKE UPPER('%".$requestData['search']['value']."%')";
		$sql.=" OR C.razonsocial LIKE UPPER('%".$requestData['search']['value']."%')";
		$sql.=" OR TP.descripcion LIKE ('%".$requestData['search']['value']."%' ))";
	}
	/* $query=$objconfig->execute_select($sql, 1) ;
    $query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData; */
	$sql.= " GROUP BY P.idpago, P.itempago, P.fecharecepcion, A.descripcion, P.estareg, P.nrodocumento, TC.descripcion, P.fechaemision, P.idcliente, TP.descripcion ";

	//$sql.=" ORDER BY A.descripcion ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";
	$sql.=" ORDER BY A.descripcion ".$requestData['order'][0]['dir']." ";

	//echo $sql;
	$query = $objconfig->execute_select($sql, 1) ;
	$totalData= count($query[1]);
	//var_dump($query);
	$data = array();
$itemsPago=[];
    $count = 1;
	foreach($query[1] as $items)
    {
		$ccount=0;
		/* foreach($itemsPago as $iitem){
			if($iitem==$items["itempago"]){
				$ccount++;
			}
		}
		if($ccount==0){
			array_push($itemsPago,$items["itempago"]);
		}else{
			continue;
		} */
		$nestedData=array();
		$cliente = $objconfig->execute_select("SELECT razonsocial, ruc FROM cliente WHERE idcliente = ".$items["idcliente"]);
        
    	$invoice_sunat= $objconfig->execute_select("select tramaxmlfirmado, tramazipcdr,mensajeerror, mensajerespuesta from invoice_sunat where idventa='".$items["itempago"]."' and( tramaxmlfirmado IS NOT NULL)",1);
    
		$nestedData[] = $items["idarea"];
		$nestedData[] = $cliente[1]["razonsocial"];
		$nestedData[] = $cliente[1]["ruc"];
		$nestedData[] = $objconfig->FechaDMY2($items["fechaemision"]);
		$nestedData[] = $items["idcomprobante"];
		$nestedData[] = $items["nrodocumento"];
		$nestedData[] = $items["idtipopago"];/* 
		$nestedData[] = $items["total"]; */
		/* if(!$invoice_sunat[1][0]['tramaxmlfirmado']){
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
		$nestedData[]= "<button type='button'  onclick='imprimir(".$items["idpago"].")' class='btn btn-info btn-xs ml-2'  data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' >Imprimir</button";
		$nestedData[]= "<button type='button'  onclick='open_modal_correo(".$items["idpago"].")' class='btn btn-info btn-xs ml-2'  data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#sendCorror' >Enviar correo</button";
		 */
		//var_dump($nestedData);
		$data[] = $nestedData;
        $count++;
    }
	//echo $requestData['length'].' - '.count($query[1]);
	$length1= 10-((((int)$requestData['length'])-(count($query[1])+((int)$requestData['start'])))*-1);
	$length11=(count($query[1]));
	//echo $length1;
	$start1=0;
	for($j=0;$j<=($length1);$j){
		$start1=$j;
		$j=$j+10;
	}
	
	//echo $length11."\n";
	if($length11==0){
		$consulP = "SELECT idpago FROM pago";
		$queryP = $objconfig->execute_select($consulP, 1) ;
		$temp=count($queryP[1])%10;
		//echo $temp."\n";
		$ssql="SELECT idnota FROM nota_credito_debito LIMIT 10  offset ".(10-($temp));
		//echo $ssql."\n";
		$query2 = $objconfig->execute_select($ssql, 1) ;
		//echo count($query2[1]);
		$start1=$start1-(count($query2[1]));
		$start1=(10-($temp));
		$length1=10;
	}
	//echo $length1.' - '.$start1.' - '.$length11; 

	$sql = "SELECT P.idpago,P.itempago, P.fecharecepcion, A.descripcion as idarea, P.estareg, P.nrodocumento, TC.descripcion as idcomprobante, P.fechaemision, P.idcliente, SUM(P.valor) AS total, TP.descripcion as idtipopago
	FROM nota_credito_debito NCD JOIN pago P ON (NCD.idventa=P.itempago) JOIN areas A ON (P.idarea=A.idarea) JOIN tipo_comprobante TC ON (P.idcomprobante=TC.idcomprobante) JOIN tipo_pago TP ON (P.idtipopago=TP.idtipopago) JOIN cliente C ON (P.idcliente=C.idcliente) ";
    //$cabecera = $objconfig->execute_select($sql);
	/* var_dump($requestData['search']); */
	$fDate=" ";
	if($_GET["fInicio"]){
		$fDate=" where P.fecharecepcion >= '".$_GET["fInicio"]."' ";

	}
	if($_GET["fFin"]){
		$fDate=" where P.fecharecepcion <= '".$_GET["fFin"]."' ";

	}
	if($_GET["fInicio"] && $_GET["fFin"]){
		$fDate=" where P.fecharecepcion >= '".$_GET["fInicio"]."' and P.fecharecepcion <= '".$_GET["fFin"]."' ";

	}
	$sql.=$fDate;

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

	//$sql.=" ORDER BY A.descripcion ".$requestData['order'][0]['dir']."  LIMIT ".$length1."  offset ".$start1." ";
	$sql.=" ORDER BY A.descripcion ".$requestData['order'][0]['dir']." ";

//echo $sql;
	$query = $objconfig->execute_select($sql, 1) ;
	//var_dump($query);
	/* $data = array();
    $count = 1; */
	$totalData= $totalData+count($query[1]);
	
	$itemsPago=[];
	foreach($query[1] as $items)
    {
		$ccount=0;
		/* foreach($itemsPago as $iitem){
			if($iitem==$items["itempago"]){
				$ccount++;
			}
		}
		if($ccount==0){
			array_push($itemsPago,$items["itempago"]);
		}else{
			continue;
		} */
		$nestedData=array();
		$cliente = $objconfig->execute_select("SELECT razonsocial, ruc FROM cliente WHERE idcliente = ".$items["idcliente"]);
        $invoice_sunat= $objconfig->execute_select("select tramaxmlfirmado, tramazipcdr,mensajeerror, mensajerespuesta from invoice_sunat where idventa='".$items["itempago"]."' and( tramaxmlfirmado IS NOT NULL) order by invoice_sunat_id asc",1);
		$nestedData[] = $items["idarea"];
		$nestedData[] = $cliente[1]["razonsocial"];
		$nestedData[] = $cliente[1]["ruc"];
		$nestedData[] = $objconfig->FechaDMY2($items["fechaemision"]);
		$nestedData[] = "NOTA DE CREDITO - ".$items["idcomprobante"];
		$nestedData[] = $items["nrodocumento"];
		$nestedData[] = $items["idtipopago"];
		/* $nestedData[] = $items["total"]; */
		/* if(!$invoice_sunat[1][1]['tramaxmlfirmado']){
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
		 */
		//var_dump($nestedData);
		$data[] = $nestedData;
        $count++;
    }
	//$totalFiltered=$totalData;
	$totalFiltered=0;
	$json_data = array(
        "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
        "recordsTotal"    => intval( $totalData ),  // total number of records
        "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            => $data   // total data array
    );
	echo json_encode($json_data);  // send data as json format
?>

