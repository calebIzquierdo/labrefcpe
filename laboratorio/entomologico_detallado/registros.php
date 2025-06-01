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
	0 => 'identomologia',
	1 => 'fecharecepcion',
	2 => 'redes',
	3 => 'micro_red',
	2 => 'estab_solicita',
	4 => 'codbarra',
	5 => 'local',
	6 => 'estareg',
	7 => 'identomologia',
	8 => 'identomologia'
	
	);

	$sql = "SELECT identomologia  ";
	$sql.= " FROM vista_entomologia ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select identomologia from vista_entomologia";
	$query1=$objconfig->execute_select($consul,1) ;

//	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2 ";

	$sql = " select identomologia, fecharecepcion, estab_solicita,codbarra, local, estareg,redes ,micro_red";
	$sql.= " FROM vista_entomologia WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (estab_solicita) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper (codbarra) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (local) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (redes) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (micro_red) LIKE upper ('%".$requestData['search']['value']."%' )";
		
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

		//$nestedData[] = $n;
		$nestedData[] = $items["identomologia"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);
		$nestedData[] = $items["codbarra"];
		$nestedData[] = $items["redes"];
		$nestedData[] = $items["micro_red"];
		$nestedData[] = $items["estab_solicita"];
		$nestedData[] = $items["local"];
		$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["identomologia"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		if ($items["estareg"]==1){
	 	$nestedData[] = "<button class='btn btn-success center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir_detalles(".$items["identomologia"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
		//$nestedData[] = "";
		$nestedData[] = "";
		$nestedData[] = "";
		//$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["identomologia"].",".$items["identomologia"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
		} 
		
		

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

