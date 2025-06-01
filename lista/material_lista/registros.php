<?php
if(!session_start()){session_start();}
include("../../objetos/class.conexion.php");		
		
	$objconfig = new conexion();
		
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idstock',
	1 => 'unmedida',
	2 => 'matel',
	3 => 'marc',
	4 => 'cantidad',
	5 => 'idstock',
	6 => 'idstock'
	);

$sql = "SELECT idstock ";
$sql.= " FROM vista_stock ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData; 

$sql = "select idstock, unmedida, matel, marc, cantidad, tipmate,idunidad , idtipomaterial,idmarca,idtipobien ,idmaterial,model,lote, idmodelo ,vensim";
$sql.= " from vista_stock WHERE 1=1";
	if( !empty($requestData['search']['value']) ) 
	{
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( UPPER(marc) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(matel) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(unmedida) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(model) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(lote) LIKE UPPER ('%".$requestData['search']['value']."%') ";

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
	
	$fvence=$objconfig->execute_select("select fvencimiento from ingreso_det where idmaterial=".$items["idmaterial"]."  and idmodelo=".$items["idmodelo"]." group by fvencimiento") ;
	
	$items["fvencimiento"]= "";

	$nestedData[] = $items["idstock"];
	$nestedData[] = "<input type='hidden' id='tipo".$count."' name='tipo".$count."' value='".strtoupper($items["idtipomaterial"])."' />".strtoupper($items["tipmate"]);
	$nestedData[] = "<input type='hidden' id='unidad".$count."' name='unidad".$count."' value='".strtoupper($items["unmedida"])."' />".strtoupper($items["unmedida"]);
	$nestedData[] = "<input type='hidden' id='matel".$count."' name='matel".$count."' value='".strtoupper($items["matel"])."' />".strtoupper($items["matel"]); 
	$nestedData[] = "<input type='hidden' id='marca".$count."' name='marca".$count."' value='".strtoupper($items["marc"])."' />".strtoupper($items["marc"]);
	$nestedData[] = "<input type='hidden' id='modelo".$count."' name='modelo".$count."' value='".strtoupper($items["model"])."' />".strtoupper($items["model"]);
	$nestedData[] = "<input type='hidden' id='stock".$count."' name='stock".$count."' value='".strtoupper($items["idunidad"]."|".$items["idmarca"]."|".$items["idmaterial"]."|".$items["idtipomaterial"]."|".$items["cantidad"]."|".$items["idmodelo"]."|".$items["lote"])."' />".strtoupper($items["cantidad"]);
	$nestedData[] = "<input type='hidden' id='lote".$count."' name='lote".$count."' value='".$items["lote"]."' />".strtoupper($items["lote"]);
	$nestedData[] = "<input type='hidden' id='fvencimiento".$count."' name='fvencimiento".$count."' value='".$objconfig->FechaDMY($fvence[1]["fvencimiento"])."' />".$objconfig->FechaDMY($fvence[1]["fvencimiento"]);
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$items["idstock"].",".$count.")' />";
	
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

