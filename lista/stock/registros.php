<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
	
	$idma = $_GET["idm"];
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idmaterial',
	1 => 'tipmate',
	2 => 'unmedida',
	3 => 'matel',
	4 => 'idmaterial',
	5 => 'idmatelrial'
	);

$sql = "SELECT idmatelrial ";
$sql.= " FROM vista_stock Where idmatelrial=".$idma."  ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select idmaterial, unmedida, matel, tipmate,idunidad ,idtipomaterial,cantidad , vensim  ";
$sql.= " from vista_stock Where idmaterial=".$idma."";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(matel) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(tipmate) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(unmedida) LIKE UPPER ('%".$requestData['search']['value']."%') ";

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

	//$nestedData[] = $items["idmatelrial"];
	$nestedData[] = $count;
	$nestedData[] = "<input type='hidden' id='tipmat".$count."' name='tipmat".$count."' value='".strtoupper($items["idtipomatelrial"]."|".$items["idunidad"])."' />".strtoupper($items["tipmate"]);
	$nestedData[] = "<input type='hidden' id='unmedidac".$count."' name='unmedidac".$count."' value='".strtoupper($items["unmedida"])."' />".strtoupper($items["unmedida"]);
	$nestedData[] = "<input type='hidden' id='matelrial".$count."' name='matelrial".$count."' value='".strtoupper($items["matel"])."' />".strtoupper($items["matel"]);
	$nestedData[] = "<input type='hidden' id='cant".$count."' name='cant".$count."' value='".$items["cantidad"]."' />".$items["cantidad"];
	$nestedData[] = "<input type='hidden' id='vensim".$count."' name='vensim".$count."' value='".$items["vensim"]."' />".$items["vensim"];
	//$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$items["idmatelrial"].",".$count.")' />";
	
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

