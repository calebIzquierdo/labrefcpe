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
	0 => 'idsalida',
	1 => 'fechasalida',
	2 => 'cantidad',
	3 => 'unidad',
	4 => 'tpmate',
	5 => 'mrcas',
	6 => 'grupo',
	7 => 'modelo',
	8 => 'nombre_usuario',
	9 => 'idsalida',
	10 => 'idsalida'
		
	);

	$sql = "SELECT idsalida  ";
	$sql.= " FROM vista_salida_material ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idsalida from vista_salida_material";
	$query1=$objconfig->execute_select($consul,1) ;

	$diagnosticos="";
	$sql = " select idsalida, fechasalida, cantidad, unidad, tpmate, mrcas, grupo, modelo,nombre_usuario,estareg,aretrabajo";
	$sql.= " FROM vista_salida_material WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (unidad) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (tpmate) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (mrcas) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (grupo) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (modelo) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (aretrabajo) LIKE UPPER ('%".$requestData['search']['value']."%') ";
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
		
		$nestedData[] = $items["idsalida"];
		$nestedData[] = $objconfig->FechaDMY($items["fechasalida"]);
		$nestedData[] = $items["grupo"];
		$nestedData[] = $items["mrcas"];
		$nestedData[] = $items["modelo"];
		$nestedData[] = $items["unidad"];
		$nestedData[] = $items["tpmate"];
		$nestedData[] = number_format($items["cantidad"],2);
		$nestedData[] = $items["aretrabajo"];
			
		if (($items["estareg"]==3)){
			$nestedData[] = "ANULADO";
			$nestedData[] = "ANULADO" ;
		}else {
		//	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idsalida"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
			$nestedData[] = "<button class='btn btn-success btn-xs center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idsalida"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
		//	$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idsalida"].",".$items["idsalida"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
			$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='anular_form(3,".$items["idsalida"].")' class='btn btn-outline btn-danger btn-primary btn-xs'>Anular</button>";
		}
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

