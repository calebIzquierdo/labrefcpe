<?php

include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idhospital',
	1 => 'descripcion',
	2 => 'cat',
	3 => 'codrenaes',
	4 => 'codsis',
	5 => 'estareg',
	6 => 'idhospital'
	);

$sql = "SELECT idejecutora ";
$sql.= " FROM vista_hospital ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idhospital, descripcion,codrenaes,cat, codsis, case when estareg=1 then 'ACTIVO' ELSE 'INACTIVO' end as estareg ";
$sql.= " FROM vista_hospital WHERE 1=1";
$isFilterApply=0;
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(descripcion) LIKE UPPER ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR upper(cat) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(codrenaes) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(codsis) LIKE upper ('%".$requestData['search']['value']."%') ";
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

	$nestedData[] = $items["idhospital"];
	$nestedData[] = $items["descripcion"];
	$nestedData[] = $items["cat"];
	$nestedData[] = $items["codrenaes"];
	$nestedData[] = $items["codsis"];
	$nestedData[] = $items["estareg"];
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idhospital"].")' class='btn btn-block btn-info'>Editar</button>";

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

