<?php

include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idestablecimiento', 
	1 => 'eje',
	2 => 'red',
	3 => 'micro',
	4 => 'esta',
	5 => 'codrenaes',
	6 => 'cat',
	7 => 'estareg',
	8 => 'idestablecimiento',
	8 => 'idestablecimiento'
	
	);

$sql = "SELECT idestablecimiento ";
$sql.= " FROM vista_establecimiento ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idestablecimiento, eje, red,micro,esta, codrenaes,cat, estareg,tipinstituto,estado, ruc ";
$sql.= " FROM vista_establecimiento WHERE 1=1";


	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(eje) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(red) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(micro) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(esta) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(codrenaes) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(cat) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(tipinstituto) LIKE upper ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper(ruc) LIKE upper ('%".$requestData['search']['value']."%') ";
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

	$nestedData[] = $items["idestablecimiento"];
	
	$nestedData[] = $items["eje"];
	$nestedData[] = $items["red"];
	$nestedData[] = $items["micro"];
	$nestedData[] = $items["esta"];
	$nestedData[] = $items["codrenaes"];
	$nestedData[] = $items["cat"];
	$nestedData[] = $items["tipinstituto"];
	$nestedData[] = $items["ruc"];
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idestablecimiento"].")' class='btn btn-warning btn-primary btn-xs'>Editar</button>";

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

