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
	0 => 'idconsolidado',
	1 => 'fecharecepcion',
	2 => 'redes',
	3 => 'micro_red',
	2 => 'estab_solicita',
	4 => 'codbarra',
	5 => 'localidad',
	6 => 'codbarra',
	7 => 'vinspec',
	8 => 'vpositiva',
	9 => 'tp_interv',
	10 => 'rpositiva',
	11 => 'mrecibida',
	12 => 'rinspeccionado',
	13 => 'estareg',
	14 => 'idconsolidado',
	15 => 'idconsolidado'
	
	);

	$sql = "SELECT idconsolidado  ";
	$sql.= " FROM vista_consolidado ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idconsolidado from vista_consolidado";
	$query1=$objconfig->execute_select($consul,1) ;

	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2
	";

	$sql = " select idconsolidado, fecharecepcion, estab_solicita,codbarra,localidad, estareg,redes ,micro_red,nombre_usuario,nroreporte";
	$sql.= " FROM vista_consolidado WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (estab_solicita) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper (codbarra) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (localidad) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (redes) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (micro_red) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (nroreporte) LIKE upper ('%".$requestData['search']['value']."%' )";
		
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
		$nestedData[] = $items["idconsolidado"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);
		$nestedData[] = $items["codbarra"];
		$nestedData[] = $items["redes"];
		$nestedData[] = $items["micro_red"];
		$nestedData[] = $items["estab_solicita"];
		$nestedData[] = $items["localidad"];
		$nestedData[] = $items["nroreporte"];
		if ($items["estareg"]==1){
	 	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idconsolidado"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		$nestedData[] = "<button class='btn btn-success center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir_detalles(".$items["idconsolidado"].")'><span class='glyphicon glyphicon-print btn-xs'></span> </button>";
		$nestedData[] = $items["nombre_usuario"];
		//$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idconsolidado"].",".$items["idconsolidado"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
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

