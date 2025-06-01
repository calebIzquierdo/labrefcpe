<?php
	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idlaboratorio',
	1 => 'reds',
	2 => 'interm',
	3 => 'codrenae',
	4 => 'codlab',
	5 => 'labmalaria',
	6 => 'estado',
	7 => 'idlaboratorio',
	);

$sql = "SELECT idlaboratorio ";
$sql.= " FROM vista_labmalaria ";

$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idlaboratorio,codrenae,interm,reds,codlab, labmalaria, estado";
$sql.= " FROM vista_labmalaria WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( upper (labmalaria) LIKE upper ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR upper (codrenae) LIKE upper ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR upper (interm) LIKE upper ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR upper (reds) LIKE upper ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR upper (codlab) LIKE upper ('%".$requestData['search']['value']."%') ";    
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
	$nestedData[] = $items["idlaboratorio"];
	$nestedData[] = $items["reds"];
	$nestedData[] = $items["interm"];
	$nestedData[] = $items["codrenae"];
	$nestedData[] = $items["codlab"];
	$nestedData[] = $items["labmalaria"];
	$nestedData[] = $items["estado"];
	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' onclick='cargar_form(2,".$items["idlaboratorio"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
	
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

