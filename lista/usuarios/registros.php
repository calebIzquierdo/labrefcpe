<?php
	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idusuario', 
	1 => 'nombres',
	2 => 'login',
	3 => 'idusuario'
	);

$sql = "SELECT idusuario ";
$sql.= " FROM usuarios ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idusuario, nombres, login ";
$sql.= " FROM usuarios WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(nombres) LIKE UPPER('%".$requestData['search']['value']."%') ";    
		$sql.=" OR UPPER(login) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		
		
		$sql.=" )";
	}

$query=$objconfig->execute_select($sql,1) ;

// when there is a search parameter then we have to modify total number filtered rows as per search result. 
$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";
 // echo $sql;
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query = $objconfig->execute_select($sql,1) ; 

$data = array();
$count=0;
foreach($query[1] as $items)
	{
  $count++;
	
	$nestedData=array(); 

	$nestedData[] = $items["idusuario"];
	$nestedData[] = "<input type='hidden' id='nombre".$count."' name='nombre".$count."' value='".strtoupper($items["nombres"])."' />".strtoupper($items["nombres"]);
	$nestedData[] = utf8_encode(strtoupper($items["login"]));
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Enviar Registro' onclick='enviar(".$items["idusuario"].",".$count.")' />";
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

			
echo json_encode($json_data);  // send data as json format

?>

