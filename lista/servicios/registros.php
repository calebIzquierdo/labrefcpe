<?php

session_start();
$idperfil = $_SESSION['idperfil'];

include("../../objetos/class.cabecera.php");
include("../../objetos/class.conexion.php");


$objconfig = new conexion();
$idusuario = explode("|",$_SESSION['nombre']);

$qesp = "select idespecialidad from usuarios where idusuario=".$idusuario[0] ;
$respecie = $objconfig->execute_select($qesp);
$idespe = $respecie[1]["idespecialidad"];

// storing  request (ie, get/post) global array to a variable
$requestData = $_REQUEST;
// Inicio de la consulta
$columns = array(
    // datatable column index  => database column name
    0 => 'idequipamiento',
    1 => 'fechaingreso',
    2 => 'oficinas',
    3 => 'areas',
    4 => 'nombre_equip',
    5 => 'marc',
    6 => 'modelos',
    7 => 'nombrepc',
    8 => 'ip',
    9 => 'codpatrimonio',
    10 => 'idequipamiento'
);

$sql = "SELECT idequipamiento  ";
$sql.= " FROM vista_equipos ";


$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData;


$consul = "select idequipamiento from vista_equipos";
$query1=$objconfig->execute_select($consul,1) ;

$sql = " select idequipamiento,oficinas, areas, fechaingreso,nombre_equip, nombrepc, marc, modelos, ip, codpatrimonio, idequipo,idpc,idespecialidad ";
$sql.= " FROM vista_equipos WHERE idespecialidad=".$idespe;

if( !empty($requestData['search']['value']) )
{
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND  (UPPER (nombre_equip) LIKE UPPER ('%".$requestData['search']['value']."%') ";
    $sql.=" OR upper (oficinas) LIKE upper ('%".$requestData['search']['value']."%' )";
    $sql.=" OR upper (areas) LIKE upper ('%".$requestData['search']['value']."%' )";
    $sql.=" OR upper (nombrepc) LIKE upper ('%".$requestData['search']['value']."%' )";
    $sql.=" OR upper (codpatrimonio) LIKE upper ('%".$requestData['search']['value']."%' )";
    $sql.=" OR upper (ip) LIKE ('%".$requestData['search']['value']."%') ";
    $sql.=" OR UPPER (marc) LIKE UPPER ('%".$requestData['search']['value']."%') ";
    $sql.=" OR UPPER (modelos) LIKE UPPER ('%".$requestData['search']['value']."%') ";
    $sql.=" )";
}

$query=$objconfig->execute_select($sql,1) ;

// when there is a search parameter then we have to modify total number filtered rows as per search result. 
$query = $objconfig->CantidadFilas($sql);
$totalData = $query ;
$totalFiltered = $totalData;


$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";


/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */

$query = $objconfig->execute_select($sql,1) ;

$data = array();

$n=0;

foreach($query[1] as $items)
{

    $n++;

    $nestedData=array();

    $nestedData[] = $n;
    //$nestedData[] = $items["idequipamiento"];
    //$nestedData[] = $objconfig->FechaDMY($items["fechaingreso"]);
    $nestedData[] = "<input type='hidden' id='idoficina".$n."' name='idoficina".$n."' value='".strtoupper($items["oficinas"])."' />".strtoupper($items["oficinas"]);
    $nestedData[] = "<input type='hidden' id='iddependencia".$n."' name='iddependencia".$n."' value='".strtoupper($items["areas"])."' />".strtoupper($items["areas"]);
    $nestedData[] = $items["marc"];
    $nestedData[] = "<input type='hidden' id='nombre_equip".$n."' name='nombre_equip".$n."' value='".strtoupper($items["nombre_equip"])."' />".strtoupper($items["nombre_equip"]);
    $nestedData[] = $items["nombrepc"];
    // $nestedData[] = $items["nombre_equip"];
    $nestedData[] = $items["ip"];
    $nestedData[] = "<input type='hidden' id='codpatrimonio".$n."' name='codpatrimonio".$n."' value='".strtoupper($items["codpatrimonio"])."' />".strtoupper($items["codpatrimonio"]);
    $nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' onclick='enviar(".$items["idequipamiento"].",$n)' class='btn btn-outline btn-warning btn-primary btn-xs'>Ok</button>";

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

