<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idmaterial',
	1 => 'tipmaterial',
	2 => 'umedida',
	3 => 'mate',
	4 => 'idmaterial',
	5 => 'idmaterial'
	);

$sql = "SELECT idmaterial ";
$sql.= " FROM vista_materiales ";

//////////////////stock mterial//////////////////////


///////////////////////////////////////


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select idmaterial, umedida, mate, tipmaterial,idunidad ,idtipomaterial,especificaiones,stock  ";
$sql.= " from vista_materiales WHERE estado_material='ACTIVO'";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(mate) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(tipmaterial) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(especificaiones) LIKE UPPER ('%".$requestData['search']['value']."%') ";

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
	if($items['stock']>0){
		$stk="<small class='text-danger'> (".intval($items['stock']).") </small>";
	}else{
		$stk="<small class='text-danger'> (0)</small>";
	} 

	$nestedData[] = $items["idmaterial"];
	$nestedData[] = "<input type='hidden' id='tipmat".$count."' name='tipmat".$count."' value='".strtoupper($items["idtipomaterial"]."|".$items["idunidad"]."|".$items["tipmaterial"])."' />".strtoupper($items["tipmaterial"]);
	$nestedData[] = "<input type='hidden' id='umedidac".$count."' name='umedidac".$count."' value='".strtoupper($items["umedida"])."' />".strtoupper($items["umedida"]);
	$nestedData[] = "<input type='hidden' id='material".$count."' name='material".$count."' value='".strtoupper($items["mate"])."' />".strtoupper($items["mate"]).$stk;
	$nestedData[] = "<input type='hidden' id='especificaiones".$count."' name='especificaiones".$count."' value='".strtoupper($items["especificaiones"])."' />".strtoupper($items["especificaiones"]);
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$items["idmaterial"].",".$count.")' />";
	
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

