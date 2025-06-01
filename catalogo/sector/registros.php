<?php
	
	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idsector', 
	1 => 'paises',
	2 => 'depart',
	3 => 'provin',
	3 => 'distri',
	4 => 'descripcion',
	5 => 'estado',
	6 => 'idsector'
	);

$sql = "SELECT idsector  ";
$sql.= " FROM sector  ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select d.idsector, dt.descripcion as distri, dp.descripcion as depart, pv.descripcion as provin, p.descripcion as paises, d.descripcion,  ";
$sql.= " case when d.estareg=1 then 'ACTIVO' else 'INACTIVO' end as estado ";
$sql.= " FROM sector as d ";
$sql.= " inner join pais as p on (p.idpais = d.idpais)";
$sql.= " inner join departamento as dp on (dp.iddepartamento = d.iddepartamento)";
$sql.= " inner join provincia as pv on (pv.idprovincia = d.idprovincia)";
$sql.= " inner join distrito as dt on (dt.iddistrito = d.iddistrito)";

	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" where UPPER (d.descripcion) LIKE UPPER ('%".$requestData['search']['value']."%') ";    
		$sql.=" OR UPPER (p.descripcion) LIKE UPPER ('%".$requestData['search']['value']."%' ) ";
		$sql.=" OR UPPER (dp.descripcion) LIKE UPPER ('%".$requestData['search']['value']."%' ) ";
		$sql.=" OR UPPER (pv.descripcion) LIKE UPPER ('%".$requestData['search']['value']."%' ) ";
		$sql.=" OR UPPER (dt.descripcion) LIKE UPPER ('%".$requestData['search']['value']."%' ) ";
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

	$nestedData[] = $items["idsector"];
	$nestedData[] = strtoupper($items["paises"]);
	$nestedData[] = strtoupper($items["depart"]);
	$nestedData[] = strtoupper($items["provin"]);
	$nestedData[] = strtoupper($items["distri"]);
	$nestedData[] = strtoupper($items["descripcion"]);
	$nestedData[] = strtoupper($items["estado"]);
	$nestedData[] = "<button type='button' data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false'  onclick='cargar_form(2,".$items["idsector"].")' class='btn btn-outline btn-warning btn-primary btn-xs' > Editar </button>";

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
