<?php
	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idtipo_examen',
	1 => 'area',
	2 => 'areatrab',
	3 => 'descripcion',
	4 => 'estareg',
	5 => 'idtipo_examen',
	);

$sql = "SELECT idtipo_examen ";
$sql.= " FROM vista_tipoexamen ";

$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idtipo_examen,area,areatrab, descripcion, estareg";
$sql.= " FROM vista_tipoexamen WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( upper (descripcion) LIKE upper ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR upper (area) LIKE upper ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR upper (areatrab) LIKE upper ('%".$requestData['search']['value']."%') ";    
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

foreach($query[1] as $items)
{
	$nestedData=array(); 
	$nestedData[] = $items["idtipo_examen"];
	$nestedData[] = $items["area"];
	$nestedData[] = $items["areatrab"];
	$nestedData[] = $items["descripcion"];
	$nestedData[] = $items["estareg"];
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' onclick='cargar_form(2,".$items["idtipo_examen"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
	
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

