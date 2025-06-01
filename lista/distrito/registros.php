<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'iddistrito', 
	1 => 'departamento',
	2 => 'provincia',
	3 => 'descripcion',
	4 => 'iddistrito'
	);

$sql = "SELECT iddistrito  ";
$sql.= " FROM vista_distrito estareg='ACTIVO' ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select iddistrito, descripcion, departamento, provincia , estareg, iddepartamento, idprovincia  ";
$sql.= " FROM vista_distrito where estareg='ACTIVO'";


	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND (  UPPER(descripcion) LIKE UPPER('%".$requestData['search']['value']."%') ";  
		$sql.=" OR upper (departamento) LIKE UPPER('%".$requestData['search']['value']."%') ";  
		$sql.=" OR upper (provincia) LIKE UPPER('%".$requestData['search']['value']."%') ";  
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

	$nestedData[] = $items["iddistrito"];
	$nestedData[] = "<input type='hidden' id='iddepart".$count."' name='iddepart".$count."' value='".strtoupper($items["iddepartamento"])."' />".strtoupper($items["departamento"]);
	$nestedData[] = "<input type='hidden' id='idprov".$count."' name='idprov".$count."' value='".strtoupper($items["idprovincia"])."' />".strtoupper($items["provincia"]);
	$nestedData[] = "<input type='hidden' id='distri".$count."' name='distri".$count."' value='".strtoupper($items["descripcion"]." / ".$items["provincia"]." / ".$items["departamento"])."' />".strtoupper($items["descripcion"]);
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$items["iddistrito"].",".$count.")' />";
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

			
echo json_encode($json_data);  // send data as json format




foreach($query[1] as $items)
	{
	
	$nestedData=array(); 

	if ($items["estareg"]=="INACTIVO")
	{
		//$color="btn-outline btn-danger";
		$color=" btn-danger";
	}
		else 
		{
		//$color="btn-outline btn-success";}
		$color=" btn-success";}

	$nestedData[] = $items["iddistrito"];
	$nestedData[] = strtoupper($items["departamento"]);
	$nestedData[] = strtoupper($items["provincia"]);
	$nestedData[] = strtoupper($items["descripcion"]);
	$nestedData[] = $items["estareg"];
	$nestedData[] = "<button type='button' data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false'  onclick='cargar_form(2,".$items["iddistrito"].")' class='btn $color btn-primary btn-xs' > Editar </button>";

	$data[] = $nestedData;
}
?>

