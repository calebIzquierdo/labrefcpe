<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

		
	$objconfig = new conexion();

   /* $idusuario = explode("|",$_SESSION['nombre']);

    $qesp = "select idespecialidad from usuarios where idusuario=".$idusuario[0] ;

    $respecie = $objconfig->execute_select($qesp);
    $idespe = $respecie[1]["idespecialidad"];

*/
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idcorrelativo',
	1 => 'rdes',
	2 => 'mred',
	3 => 'procedencia',
	4 => 'anios',
	5 => 'correlativo',
	6 => 'correlativo',
	7 => 'idcorrelativo'
	
	);

	$sql = "SELECT idcorrelativo  ";
	$sql.= " FROM vista_correlativo ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idcorrelativo from vista_correlativo";
	$query1=$objconfig->execute_select($consul,1) ;

//	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2 
//	";
/*
	if ($idperfil != 1){
        $where = "WHERE idespecialidad=".$idespe;
	}
*/

$diagnosticos="";
	$sql = " select idcorrelativo, anios, procedencia,nombre_usuario,estado,codrenaes,codrenae,mred,rdes,correlativo ";
	$sql.= " FROM vista_correlativo WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (procedencia) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		
		$sql.=" OR upper (rdes) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (mred) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR UPPER (codrenaes) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (nombre_usuario) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		
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

	//$n=0;

	foreach($query[1] as $items)
		{

           
		$nestedData=array();
		
		$nestedData[] = $items["idcorrelativo"];
		$nestedData[] = $items["codrenae"];
		$nestedData[] = $items["rdes"];
		$nestedData[] = $items["mred"];
		$nestedData[] = $items["procedencia"];
		$nestedData[] = $items["anios"];
		$nestedData[] = $items["correlativo"]-1;
		$nestedData[] = $items["estado"];
		$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idcorrelativo"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		$nestedData[] = $items["nombre_usuario"];
		
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

