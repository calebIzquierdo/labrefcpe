<?php
include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idpaciente',
	1 => 'nombres',
	2 => 'nrodocumento',
	3 => 'apellidos',
	4 => 'nrodocumento',
	5 => 'hclinica',
	6 => 'estareg',
	7 => 'idpaciente'
	);

$sql = "SELECT idpaciente  ";
$sql.= " FROM vista_paciente ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idpaciente, nombres,apellidos, nrodocumento, seguro,hclinica, estareg ";
$sql.= " FROM vista_paciente WHERE 1=1";

	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(nombres) LIKE UPPER ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR UPPER(apellidos) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(nrodocumento) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(seguro) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(hclinica) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(estareg) LIKE UPPER ('%".$requestData['search']['value']."%') ";
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
  
	/* $estado="ACTIVO";
		if($items["estado"]==0){$estado="INACTIVO";}  */
		
	$nestedData=array(); 

	$nestedData[] = $items["idpaciente"];
	$nestedData[] = $items["nombres"];
	$nestedData[] = $items["apellidos"];
	$nestedData[] = $items["nrodocumento"];
	$nestedData[] = $items["seguro"];
	$nestedData[] = $items["hclinica"];
	$nestedData[] = $items["estareg"];
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idpaciente"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";

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

