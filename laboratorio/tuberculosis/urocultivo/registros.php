<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];

	include("../../../objetos/class.cabecera.php");	
	include("../../../objetos/class.conexion.php");
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
	0 => 'idurocultivo',
	1 => 'fecharecepcion',
	2 => 'estab_solicita',
	3 => 'pacientes',
	4 => 'nrodocumento',
	5 => 'edadactual',
	6 => 'nrorecibo',
	7 => 'codbarra',
	8 => 'tipmuestra',
	9 => 'medico_solicita',
	10 => 'nombre_usuario',
	11 => 'fechadigitacion',
	12 => 'estareg',
	13 => 'idurocultivo',
	14 => 'idurocultivo'
	
	);

	$sql = "SELECT idurocultivo  ";
	$sql.= " FROM vista_urocultivo ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idurocultivo from vista_urocultivo";
	$query1=$objconfig->execute_select($consul,1) ;

	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2
	";
/*
	if ($idperfil != 1){
        $where = "WHERE idespecialidad=".$idespe;
	}
*/


	$sql = " select idurocultivo, fecharecepcion, pacientes,edadactual,tipmuestra,  nrodocumento, nrorecibo,tipseguro, codbarra,
			tipmuestra, medico_solicita, estab_solicita,nombre_usuario,fechadigitacion,estareg,estado_examen ";
	$sql.= " FROM vista_urocultivo WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (pacientes) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper (estab_solicita) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR nrodocumento LIKE  '%".$requestData['search']['value']."%' ";
		$sql.=" OR upper (codbarra) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (pacientes) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR nrorecibo LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR UPPER (tipmuestra) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (medico_solicita) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (nombre_usuario) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR  (edadactual) LIKE ('%".$requestData['search']['value']."%') ";
		$sql.=" OR  upper (estado_examen) LIKE upper ('%".$requestData['search']['value']."%') ";

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
		$nestedData[] = $items["idurocultivo"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);$nestedData[] = $items["codbarra"];
		$nestedData[] = $items["estab_solicita"];
		$nestedData[] = $items["pacientes"];
		$nestedData[] = $items["nrodocumento"];
		$nestedData[] = $items["edadactual"];
		$nestedData[] = $items["tipmuestra"];
		$nestedData[] = $items["medico_solicita"];
		$nestedData[] = $items["estado_examen"];
		if ($items["estareg"]==1){
		$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idurocultivo"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		$nestedData[] = "<button class='btn btn-success center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idurocultivo"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
		//$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(3,".$items["idurocultivo"].")' class='btn btn-outline btn-info btn-info btn-xs'>Resultado</button>";
		$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idurocultivo"].",".$items["idurocultivo"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
		} else if (($items["estareg"]==2)){
			$nestedData[] = "PROCESADO";
			$nestedData[] = "<button class='btn btn-success center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idurocultivo"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
			$nestedData[] = "PROCESADO";
		}else {
			$nestedData[] = "ANULADO";
			$nestedData[] = "ANULADO" ;
			$nestedData[] = "ANULADO";
		}
		$nestedData[] = $items["nombre_usuario"];
		$nestedData[] = $items["fechadigitacion"];
		
		

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

