<?php

if (!session_start()) {
	session_start();
}
include("../../objetos/class.conexion.php");
$objconfig = new conexion();

// storing  request (ie, get/post) global array to a variable 
$requestData = $_REQUEST;
// Inicio de la consulta 
$columns = array(
	// datatable column index  => database column name
	0 => 'idrequerimiento',
	1 => 'correlativo',
	2 => 'fecha',
	3 => 'area',
	4 => 'subarea',
	5 => 'solicitante',
	6 => 'correlativo'
);

/*
    fecha,
    idarea,
    idareatrabajo,
    idpersonal,
    solicitante,
    estareg,
    estado,
    nombres,
    glosa,
    observacion,
    estable,
    idusuario
*/

$sql = "SELECT idrequerimiento ";
$sql .= " FROM vista_requerimiento Where estareg=4 ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query;
$totalFiltered = $totalData;

$sql = "select idrequerimiento, fecha, area, correlativo,subarea ,solicitante,idarea,idareatrabajo,idpersonal  ";
$sql .= " from vista_requerimiento Where estareg=4";
if (!empty($requestData['search']['value'])) {
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( UPPER(area) LIKE UPPER('%" . $requestData['search']['value'] . "%') ";
	$sql .= " OR UPPER(correlativo) LIKE UPPER ('%" . $requestData['search']['value'] . "%') ";
	$sql .= " OR UPPER(subarea) LIKE UPPER ('%" . $requestData['search']['value'] . "%') ";
	$sql .= " OR UPPER(solicitante) LIKE UPPER ('%" . $requestData['search']['value'] . "%') ";

	$sql .= " )";
}

$query = $objconfig->execute_select($sql, 1);

// when there is a search parameter then we have to modify total number filtered rows as per search result. 
$query = $objconfig->CantidadFilas($sql);
$totalData = $query;
$totalFiltered = $totalData;

$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['length'] . "  offset " . $requestData['start'] . " ";
// echo $sql;
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */

$query = $objconfig->execute_select($sql, 1);
/* print_r($query);
die(); */
$data = array();
$count = 0;
foreach ($query[1] as $items) {
	$count++;

	$nestedData = array();

	$nestedData[] = $count;
	$nestedData[] = "<input type='hidden' id='correlativo" . $count . "' name='correlativo" . $count . "' value='" . $items["correlativo"] . "' />" . $items["correlativo"];
	$nestedData[] = "<input type='hidden' id='fecha" . $count . "' name='fecha" . $count . "' value='" . $objconfig->FechaDMY($items["fecha"]) . "' />" . $objconfig->FechaDMY($items["fecha"]);
	$nestedData[] = "<input type='hidden' id='area" . $count . "' name='area" . $count . "' value='" . $items["idarea"] . "' />" . strtoupper($items["area"]);
	$nestedData[] = "<input type='hidden' id='subarea" . $count . "' name='subarea" . $count . "' value='" . $items["idareatrabajo"] . "' />" . $items["subarea"];
	$nestedData[] = "<input type='hidden' id='soli" . $count . "' name='soli" . $count . "' value='" . $items["idpersonal"] . "' />" . $items["solicitante"];
	$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Enviar Registro' onclick='enviar(\"" . $items["correlativo"] . "\"," . $count . ")' />";

	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);


echo json_encode($json_data);  // send data as json format
