<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

		
	$objconfig = new conexion();

    $idusuario = explode("|",$_SESSION['nombre']);

    $qesp = "select idusuario, idejecutora, idmicrored,idestablecimiento,idespecialidad,idtipo_topico,idred,
			idservicio,idtiposervicio, idnivelreporte,idvencimiento,editar from usuarios where idusuario=".$idusuario[0] ;

    $est = $objconfig->execute_select($qesp);
    $idesta = $est[1]["idestablecimiento"];
	
	//$where = "WHERE 1=1";
	$where = "WHERE idpago=0 and estareg=1 and idusuario=".$idusuario[0];
	/*
	if ($est[1]["idnivelreporte"]==1){
		$where ="WHERE idpago=0 and estareg=1 and  idestablesolicita=".$est[1]["idestablecimiento"]." 
		";

	}*/

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idpago',
	1 => 'fecharecepcion',
	2 => 'rdes',
	3 => 'mred',
	4 => 'procedencia',
	5 => 'tipoatencion',
	6 => 'nombre_usuario',
	7 => 'estado_examen',
	8 => 'codbarra',
	9 => 'idpago',
	10 => 'idpago',
	11 => 'idpago'
	
	);

	$sql = "SELECT idpago  ";
	$sql.= " FROM vista_pagos ".$where;
//$sql.= " FROM vista_pagos where idpago=0 and estareg=1";

	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idpago from vista_pagos where idpago=0 and  estareg=1";
	$query1=$objconfig->execute_select($consul,1) ;

//	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2 
//	";
/*
	if ($idperfil != 1){
        $where = "WHERE idespecialidad=".$idespe;
	}
*/

$diagnosticos="";
	$sql = " select idpago, fecharecepcion, tipoatencion, procedencia,nombre_usuario,estareg,estado_examen,mred,rdes,codbarra,tipexamen,nrodocumento ";
	$sql.= " FROM vista_pagos WHERE  1=1";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (codbarra) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper (tipoatencion) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (procedencia) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR UPPER (estado_examen) LIKE UPPER ('%".$requestData['search']['value']."%') ";
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
		
		$nestedData[] = $items["idpago"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);
		$nestedData[] = $items["codbarra"];
		$nestedData[] = $items["procedencia"];
		$nestedData[] = $items["tipoatencion"];
		$nestedData[] = $items["tipexamen"];
		$nestedData[] = $items["tip_comprob"];
		$nestedData[] = $items["nrodocumento"];
		
		$nestedData[] = "<button type='button'  onclick='imprimir(1,".$items["idpago"].")' class='btn btn-success btn-xs'>Imprimir</button>";
		$nestedData[] = "<button type='button'   class='btn btn-danger btn-xs '>Anular</button>";
		//$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(3,".$items["idpago"].")' class='btn btn-danger btn-xs '>Anular</button>";
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

