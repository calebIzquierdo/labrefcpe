<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'usuario', 
	1 => 'usuario', 
	2 => 'ip',
	3 => 'descripcion',
	4 => 'fechareg',
	5 => 'hora'
	
	);

$sql = "select count(1) ";
$sql.= " FROM vista_log ";

$query = $objconfig->CantidadFilas($sql);

$totalData = $query ;
$totalFiltered = $totalData;


$sql = "select usuario, ip, descripcion, fechareg, hora ";
$sql.= " FROM vista_log WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(ip) LIKE UPPER('%".$requestData['search']['value']."%') ";    
		$sql.=" OR UPPER(usuario) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(descripcion) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		// $sql.=" OR UPPER(estareg) LIKE UPPER ('%".$requestData['search']['value']."% ') ";
		$sql.=" )";
	}

$query=$objconfig->execute_select($sql,1) ;

// when there is a search parameter then we have to modify total number filtered rows as per search result. 
$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql.=" order by fechareg desc,cast(hora as time) desc OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']." ROWS ONLY ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query = $objconfig->execute_select($sql,1) ; 

$data = array();

$n=0;
foreach($query[1] as $items)
	{
  
	$n = ++$n;
	$i = explode("|",$items["usuario"]);

	$nestedData=array(); 

	$nestedData[] = $n;
	$nestedData[] = strtoupper($i[1]);
	$nestedData[] = strtoupper($items["ip"]);
	$nestedData[] = strtoupper($items["descripcion"]);
	$nestedData[] = $objconfig->FechaDMY($items["fechareg"]);
	$nestedData[] = $items["hora"];
	
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

