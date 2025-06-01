<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idperfil', 
	1 => 'descripcion',
	2 => 'estareg',
	3 => 'idperfil'
	);

$sql = "SELECT idperfil, descripcion, estareg ";
$sql.= " FROM perfiles ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idperfil, descripcion,  case when estareg=1 then 'ACTIVO' ELSE 'INACTIVO' end as estareg ";
$sql.= " FROM perfiles WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(descripcion) LIKE UPPER ('%".$requestData['search']['value']."%') ";    
		// $sql.=" OR upper(estareg) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" )";
	}

$query=$objconfig->execute_select($sql,1) ;

$totalFiltered = $objconfig->CantidadFilas($sql,1); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']." ROWS ONLY ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = $objconfig->execute_select($sql,1) ;

$data = array();

foreach($query[1] as $items)
	{
  
	
	$nestedData=array(); 

	$nestedData[] = $items["idperfil"];
	$nestedData[] = $items["descripcion"];
	$nestedData[] = $items["estareg"];
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' onclick='cargar_form(2,".$items["idperfil"].")' class='btn btn-block btn-info'>Editar</button>";

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

