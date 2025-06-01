<?php
	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'iddistrito', 
	1 => 'departamento',
	2 => 'provincia',
	3 => 'descripcion',
	4 => 'estareg',
	5 => 'iddistrito'
	);

$sql = "SELECT iddistrito  ";
$sql.= " FROM vista_distrito ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select iddistrito, descripcion, departamento, provincia , estareg  ";
$sql.= " FROM vista_distrito ";


	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" WHERE  UPPER(descripcion) LIKE UPPER('%".$requestData['search']['value']."%') ";  
		$sql.=" OR upper (departamento) LIKE UPPER('%".$requestData['search']['value']."%') ";  
		$sql.=" OR upper (provincia) LIKE UPPER('%".$requestData['search']['value']."%') ";  
		$sql.=" ";

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

	if ($items["estareg"]=="INACTIVO")
	{
		//$color="btn-outline btn-danger";
		$color=" btn-danger";
	}
		else 
		{
		//$color="btn-outline btn-success";}
		$color=" btn-success";}

	$nestedData[] = $items["iddistrito"];
	$nestedData[] = strtoupper($items["departamento"]);
	$nestedData[] = strtoupper($items["provincia"]);
	$nestedData[] = strtoupper($items["descripcion"]);
	$nestedData[] = $items["estareg"];
	$nestedData[] = "<button type='button' data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false'  onclick='cargar_form(2,".$items["iddistrito"].")' class='btn $color btn-primary btn-xs' > Editar </button>";

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

