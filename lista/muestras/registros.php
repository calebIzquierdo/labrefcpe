<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idingresomuestra',
	1 => 'fecharecepcion',
	2 => 'mred',
	3 => 'procedencia',
	6 => 'idingresomuestra'
	);
	
	$sql = "SELECT idingresomuestra  ";
	$sql.= " FROM vista_muestra ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idingresomuestra from vista_muestra";
	$query1=$objconfig->execute_select($consul,1) ;

	$sql = " select idingresomuestra, fecharecepcion, tipoatencion, procedencia,nombre_usuario,estareg,fechareg,estado_examen,mred ";
	$sql.= " FROM vista_muestra WHERE estareg=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (pacientes) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR tipoatencion LIKE  '%".$requestData['search']['value']."%' ";
		$sql.=" OR upper (mred) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR UPPER (nombre_usuario) LIKE UPPER ('%".$requestData['search']['value']."%') ";
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
	$fechaReg = $objconfig->FechaDMY($items["fecharecepcion"]);
	
	$nestedData[] = $items["idingresomuestra"];
	$nestedData[] = "<input type='hidden' id='fecharecepcion".$count."' name='fecharecepcion".$count."' value='".$fechaReg."' />".$fechaReg ;
	$nestedData[] = "<input type='hidden' id='micr".$count."' name='micr".$count."' value='".strtoupper($items["mred"])."' />".strtoupper($items["mred"]);
	$nestedData[] = "<input type='hidden' id='estab".$count."' name='estab".$count."' value='".strtoupper($items["procedencia"])."' />".strtoupper($items["procedencia"]);
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$items["idingresomuestra"].",".$count.")' />";
	
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

