<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idhospital',
	1 => 'codrenaes',
	2 => 'ejec',
	3 => 'descripcion',
	4 => 'cat',
	5 => 'idhospital'	
	);

$sql = "SELECT idhospital ";
$sql.= " FROM vista_hospital ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select idhospital, codrenaes,descripcion, cat, ejec  ";
$sql.= " from vista_hospital WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(codrenaes) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(descripcion) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(cat) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(ejec) LIKE UPPER ('%".$requestData['search']['value']."%') ";

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

	$nestedData[] = $items["idhospital"];
	$nestedData[] = "<input type='hidden' id='codren".$count."' name='codren".$count."' value='".strtoupper($items["codrenaes"])."' />".strtoupper($items["codrenaes"]);
	$nestedData[] = "<input type='hidden' id='ejec".$count."' name='ejec".$count."' value='".strtoupper($items["ejec"])."' />".strtoupper($items["ejec"]);
	$nestedData[] = "<input type='hidden' id='estab".$count."' name='estab".$count."' value='".strtoupper($items["descripcion"])."' />".strtoupper($items["descripcion"]);
	$nestedData[] = "<input type='hidden' id='cat".$count."' name='cat".$count."' value='".strtoupper($items["cat"])."' />".strtoupper($items["cat"]);
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$items["idhospital"].",".$count.")' />";
	
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

