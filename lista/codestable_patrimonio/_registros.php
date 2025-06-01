<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idestablecimiento',
	1 => 'codrenaes',
	2 => 'eje',
	3 => 'micro',
	4 => 'esta',
	5 => 'codrenaes',
	6 => 'idestablecimiento'
	);

$sql = "SELECT idestablecimiento ";
$sql.= " FROM vista_establecimiento ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select idestablecimiento, eje,red, micro, esta,codrenaes  ";
$sql.= " from vista_establecimiento WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(eje) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(red) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(micro) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(esta) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(codrenaes) LIKE UPPER ('%".$requestData['search']['value']."%') ";

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

	$nestedData[] = $items["idestablecimiento"];
	$nestedData[] = "<input type='hidden' id='codren".$count."' name='codren".$count."' value='".strtoupper($items["codrenaes"])."' />".strtoupper($items["codrenaes"]);
	$nestedData[] = "<input type='hidden' id='ejec".$count."' name='ejec".$count."' value='".strtoupper($items["eje"])."' />".strtoupper($items["eje"]);
	$nestedData[] = "<input type='hidden' id='reds".$count."' name='reds".$count."' value='".strtoupper($items["red"])."' />".strtoupper($items["red"]);
	$nestedData[] = "<input type='hidden' id='micr".$count."' name='micr".$count."' value='".strtoupper($items["micro"])."' />".strtoupper($items["micro"]);
	$nestedData[] = "<input type='hidden' id='estab".$count."' name='estab".$count."' value='".strtoupper($items["esta"])."' />".strtoupper($items["esta"]);
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$items["idestablecimiento"].",".$count.")' />";
	
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

