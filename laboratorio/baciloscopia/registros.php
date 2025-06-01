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
	0 => 'idaedes',
	1 => 'fecharecepcion',
	2 => 'redes',
	3 => 'micro_red',
	2 => 'estab_solicita',
	4 => 'codbarra',
	5 => 'zona',
	6 => 'codbarra',
	7 => 'vinspec',
	8 => 'vpositiva',
	9 => 'tp_interv',
	10 => 'rpositiva',
	11 => 'mrecibida',
	12 => 'rinspeccionado',
	13 => 'estareg',
	14 => 'idaedes',
	15 => 'idaedes'
	
	);

	$sql = "SELECT idaedes  ";
	$sql.= " FROM vista_aedes ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idaedes from vista_aedes";
	$query1=$objconfig->execute_select($consul,1) ;

	//$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2 ";

	$sql = " select idaedes, fecharecepcion, estab_solicita,codbarra, poblacion, tp_interv,estareg,redes ,micro_red";
	$sql.= " FROM vista_aedes WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (estab_solicita) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (tp_interv) LIKE UPPER ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (redes) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (micro_red) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR codbarra LIKE  ('%".$requestData['search']['value']."%' )";
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
		$nestedData[] = $items["idaedes"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);
		$nestedData[] = $items["codbarra"];
		$nestedData[] = $items["redes"];
		$nestedData[] = $items["micro_red"];
		$nestedData[] = $items["estab_solicita"];
		
		if ($items["estareg"]==1){
			$nestedData[] = "<button class='btn btn-success center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idaedes"].")'><span class='glyphicon glyphicon-print'></span> </button>";
			$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idaedes"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		
		//$nestedData[] = "";
	//	$nestedData[] = "";
	//	$nestedData[] = "";
		$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idaedes"].",".$items["idaedes"].")' class='btn btn-outline btn-danger btn-xs'>Elimar</button>";
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

