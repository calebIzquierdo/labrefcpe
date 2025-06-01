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
        0 => 'idrequerimiento',
        1 => 'correlativo',
        2 => 'fecharegistro',
		3 => 'solicitante',
		4 => 'tipo',
        5 => 'material',
        6 => 'cantidad',
        7 => 'cant_aprobada',
        8 => 'stock',
	);

	$sql = "SELECT idrequerimiento FROM vista_materiales_sin_stock ";
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "SELECT idrequerimiento FROM vista_materiales_sin_stock";
	$query1 = $objconfig->execute_select($consul, 1) ;


	$sql = "SELECT idrequerimiento, estareg, correlativo, fecharegistro,solicitante, idtipomaterial, tipo, material, cantidad, cant_aprobada, stock FROM vista_materiales_sin_stock WHERE estareg = 4 AND stock = 0 ";

	if( !empty($requestData['search']['value']) ) 
	{
		$sql.=" AND ( UPPER(material) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(tipo) LIKE UPPER('%".$requestData['search']['value']."%')";
		$sql.=" OR correlativo LIKE '%".$requestData['search']['value']."%' )";
	}
	$query=$objconfig->execute_select($sql, 1) ;
    $query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";


	$query = $objconfig->execute_select($sql, 1) ;

	$data = array();
    $count = 1;
	
	foreach($query[1] as $items)
    {
		$nestedData=array();
        
		$nestedData[] = $count;
		$nestedData[] = $items["correlativo"];
		$nestedData[] = $objconfig->FechaDMY2($items["fecharegistro"]);
		$nestedData[] = $items["solicitante"];
		$nestedData[] = $items["tipo"];
		$nestedData[] = $items["material"];
		$nestedData[] = $items["cantidad"];
		$nestedData[] = $items["cant_aprobada"];
		$nestedData[] = $items["stock"];
		
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

