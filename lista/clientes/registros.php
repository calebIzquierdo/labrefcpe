<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idcliente', 
	1 => 'nombres',
	2 => 'nrodocumento',
	3 => 'direccion',
	4 => 'idcliente'
	);

$sql = "SELECT idcliente ";
$sql.= " FROM clientes ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "SELECT idcliente, nombres, direccion, nrodocumento ";
$sql.= " FROM clientes WHERE estareg=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(nombres) LIKE UPPER('%".$requestData['search']['value']."%') ";    
		$sql.=" OR UPPER(direccion) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(nrodocumento) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		
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

	$nestedData[] = $items["idcliente"];
	$nestedData[] = "<input type='hidden' id='nombres".$count."' name='nombres".$count."' value='".strtoupper($items["nombres"])."' />".strtoupper($items["nombres"]);
	$nestedData[] = "<input type='hidden' id='ruc".$count."' name='ruc".$count."' value='".strtoupper($items["nrodocumento"])."' />".strtoupper($items["nrodocumento"]);
	$nestedData[] = strtoupper($items["direccion"]);
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='enviar Registro' onclick='enviar(".$items["idcliente"].",".$count.")' />";
	
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

