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
        1 => 'descripcion',
        2 => 'abreviado',
        3 => 'seriedoc',
        4 => 'valor',
        4 => 'estado',
        5 => 'btnedit',

	);
	$sql = "SELECT idseriedoc ";
	$sql.= " FROM seriedoc ";
	
	
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData; 


	$sql = "select SD.idseriedoc, SD.seriedoc, SD.valor, SD.estado, TC.descripcion, TC.abreviado from seriedoc SD inner join tipo_comprobante TC on SD.idtipocomprobante=TC.idcomprobante ";
    $cabecera = $objconfig->execute_select($sql);
	/* var_dump($requestData['search']); */
	if( !empty($requestData['search']['value']) ) 
	{
		$sql.=" WHERE ( UPPER(TC.descripcion) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR SD.seriedoc LIKE ('%".$requestData['search']['value']."%'))";
	}
	$query=$objconfig->execute_select($sql, 1) ;
    $query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;
	$sql.= " GROUP BY SD.idtipocomprobante, SD.idseriedoc, TC.descripcion, TC.abreviado, SD.estado ";

	$sql.=" ORDER BY SD.idtipocomprobante ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";

	//echo $sql;
	$query = $objconfig->execute_select($sql, 1) ;
	//var_dump($query);
	$data = array();
    $count = 1;
	foreach($query[1] as $items)
    {
		$nestedData=array();
		$nestedData[] = $count;
		$nestedData[] = $items["descripcion"];
		$nestedData[] = $items["abreviado"];
		$nestedData[] = $items["seriedoc"];
		$nestedData[] = str_pad($items["valor"], 7, '0', STR_PAD_LEFT);
		if($items["estado"]){
			$nestedData[] = "<p class='btn btn-primary'>Activo</p>";
		}else{
			$nestedData[] = "<p class='btn btn-danger'>Inactivo</p>";
		}
		
		$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idseriedoc"].")' class='btn btn-block btn-info'>Editar</button>";

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

