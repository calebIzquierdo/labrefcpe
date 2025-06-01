<?php
if(!session_start()){session_start();}
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
	3 => 'idusuario',
	4 => 'perf',
	5 => 'estareg',
	6 => 'idusuario',
	7 => 'estado',
	8 => 'idusuario'
	);

$sql = "SELECT idusuario ";
$sql.= " FROM vista_user where estareg=1 ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idusuario, nombres, login,tipo_perfil, estado,ejecut,red,micro,est,estareg ";
$sql.= " FROM vista_user WHERE estareg=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(nombres) LIKE UPPER('%".$requestData['search']['value']."%') ";    
		$sql.=" OR UPPER(login) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(tipo_perfil) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(estado) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(red) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(est) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		// $sql.=" OR UPPER(estareg) LIKE UPPER ('%".$requestData['search']['value']."% ') ";
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

	$nestedData[] = $items["idusuario"];
	$nestedData[] = strtoupper($items["nombres"]);
	$nestedData[] = strtoupper($items["login"]);
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' onclick='cargar_form(3,".$items["idusuario"].")' class='btn btn-block btn-danger'>Clave</button>";
	$nestedData[] = strtoupper($items["tipo_perfil"]);
	$nestedData[] = strtoupper($items["est"]);
	$nestedData[] = strtoupper($items["red"]);
	$nestedData[] = strtoupper($items["estado"]);
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' onclick='cargar_form(2,".$items["idusuario"].")' class='btn btn-block btn-info'>Editar</button>";

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

