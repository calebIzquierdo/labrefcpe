<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idmodulo', 
	1 => 'descripcion',
	2 => 'url',
	3 => 'idpadre',
	4 => 'idmodulo'
	);

$sql = "SELECT idmodulo ";
$sql.= " FROM vista_modulos ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idmodulo, descripcion,  url, idpadre ";
$sql.= " FROM vista_modulos WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(descripcion) LIKE UPPER('%".$requestData['search']['value']."%') ";    
		$sql.=" OR UPPER(url) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(idpadre) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		
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

	$nestedData[] = $items["idmodulo"];
	$nestedData[] = "<input type='hidden' id='descripcion".$count."' name='descripcion".$count."' value='".strtoupper($items["descripcion"])."' />".strtoupper($items["descripcion"]);
	$nestedData[] = utf8_encode(strtoupper($items["url"]));
	$nestedData[] = utf8_encode(strtoupper($items["idpadre"]));
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Editar Registro' onclick='enviar(".$items["idmodulo"].",".$count.")' />";
	
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

