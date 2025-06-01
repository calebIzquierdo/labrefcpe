<?php

include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'nombres', 
	1 => 'seriedoc',
	2 => 'valor',
	3 => 'btnedit'
	);

$sql = "SELECT idpersonal ";
$sql.= " FROM seriedoc_personal ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select P.idusuario, TC.descripcion, P.nombres, SDP.idseriedoc, SD.seriedoc, SD.idtipocomprobante, SD.valor from usuarios P inner join seriedoc_personal SDP on (P.idusuario=SDP.idpersonal) inner join seriedoc SD on (SDP.idseriedoc=SD.idseriedoc) inner join tipo_comprobante TC on (SD.idtipocomprobante=TC.idcomprobante) ";
$sql.= " ";
$isFilterApply=0;
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(P.nombres) LIKE UPPER ('%".$requestData['search']['value']."%') ";  
		$sql.=" OR upper(SD.seriedoc) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" )";
		
	}

	$query=$objconfig->execute_select($sql,1) ;

	$totalFiltered = $objconfig->CantidadFilas($sql,1); // when there is a search parameter then we have to modify total number filtered rows as per search result.
	$sql.=" ORDER BY  P.nombres  ".$requestData['order'][0]['dir']."  OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']." ROWS ONLY ";
	/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
	//echo $sql;
	$query = $objconfig->execute_select($sql,1) ;

$data = array();

$count = 1;
foreach($query[1] as $items)
	{
  
	$nestedData=array(); 
	$nestedData[] = $count;
	$nestedData[] = $items["nombres"];
	$nestedData[] = $items["descripcion"];
	$nestedData[] = $items["seriedoc"];
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,\"".$items["idusuario"]."-".$items["idtipocomprobante"]."-".$items["idseriedoc"]."\")' class='btn btn-block btn-info'>Editar</button>";

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

