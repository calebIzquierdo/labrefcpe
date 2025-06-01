<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

	$objconfig = new conexion();
  	$idusuario = explode("|",$_SESSION['nombre']);

    $qesp = "select idestablecimiento, idnivelreporte from usuarios where idusuario=".$idusuario[0] ;

    $respecie = $objconfig->execute_select($qesp);
    $idsolic = $respecie[1]["idestablecimiento"];
	
	if ($respecie[1]["idnivelreporte"]==1)
	{
		$where ="WHERE idestablecimiento=".$idsolic ." AND estadoreg!=3";
	} else {
		$where ="WHERE estadoreg!=3";
	}

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;

	$columns = array( 
		0 => 'idotrosresultados',
		1 => 'codbarra',
		2 => 'fecharecepcion',
		3 => 'idestablecimiento',
		4 => 'establecimiento',
		5 => 'razonsocial',
		6 => 'ruc',
		7 => 'edad',
		8 => 'sexo',
		9 => 'enfermedad',
		10 => 'nombre_usuario',
	);

	$sql = "SELECT idotrosresultados FROM view_otrosresultados ".$where;
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "SELECT idotrosresultados FROM view_otrosresultados".$where;
	$query1=$objconfig->execute_select($consul,1) ;

	$sql = "SELECT idotrosresultados, codbarra, fecharecepcion, idestablecimiento, establecimiento, razonsocial, ruc, edad, sexo, enfermedad, nombre_usuario, fechareg, estadoreg ";
	$sql.= "FROM view_otrosresultados ".$where;

	if( !empty($requestData['search']['value']) ) 
	{
		$sql.=" AND  (UPPER (razonsocial) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper (establecimiento) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR ruc LIKE  '%".$requestData['search']['value']."%' ";
		$sql.=" OR codbarra LIKE  '%".$requestData['search']['value']."%' ";
		$sql.=" OR UPPER (nombre_usuario) LIKE UPPER ('%".$requestData['search']['value']."%') ";

		$sql.=" )";
	}
	$query = $objconfig->execute_select($sql,1) ;

	// when there is a search parameter then we have to modify total number filtered rows as per search result.
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";
	$query = $objconfig->execute_select($sql,1) ;

	$data = array();
	foreach($query[1] as $items)
	{
		$nestedData=array();

		$nestedData[] = $items["idotrosresultados"];
		$nestedData[] = $items["codbarra"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);
		$nestedData[] = $items["establecimiento"];
		$nestedData[] = $items["razonsocial"];
		$nestedData[] = $items["ruc"];
		$nestedData[] = $items["edad"]." años";
		$nestedData[] = $items["sexo"] == "F" ? "Femenina" : "Masculino";
		$nestedData[] = $items["enfermedad"];
		$nestedData[] = $items["nombre_usuario"];
		$nestedData[] = "<button class='btn btn-warning center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#userModal' onclick='edit_result_list(1, &apos;".$items["codbarra"]."&apos;)'><span class='glyphicon glyphicon-edit'></span> Editar</button>";
		$nestedData[] = "<button class='btn btn-success center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idotrosresultados"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
		
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

