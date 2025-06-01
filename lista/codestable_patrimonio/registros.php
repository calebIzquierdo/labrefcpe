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
	1 => 'codrenaes',
	2 => 'procedencia',
	3 => 'procedencia',
	4 => 'anios',
	5 => 'correlativo',
	6 => 'correlativo',
	7 => 'ruc',
	7 => 'idcorrelativo'
	
	);

	$sql = "SELECT idcorrelativo  ";
	$sql.= " FROM vista_correlativo_patrimonio ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idcorrelativo from vista_correlativo_patrimonio";
	$query1=$objconfig->execute_select($consul,1) ;

	$sql = " select idcorrelativo, anios, procedencia,nombre_usuario,estado,codrenaes,correlativo,idestablesolicita,codrenae,idpriva,ruc ";
	$sql.= " FROM vista_correlativo_patrimonio WHERE estareg=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (procedencia) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (codrenaes) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (ruc) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		
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

	$count=0;

	foreach($query[1] as $items)
		{
           
		$nestedData=array();
		$count++;
		
		$nestedData[] = $items["idcorrelativo"];
		$nestedData[] = "<input type='hidden' id='codren".$count."' name='codren".$count."' value='".strtoupper($items["codrenae"])."' />".strtoupper($items["codrenae"]);
		$nestedData[] = "<input type='hidden' id='ruc".$count."' name='ruc".$count."' value='".strtoupper($items["ruc"])."' />".strtoupper($items["ruc"]);
		$nestedData[] = "<input type='hidden' id='estab".$count."' name='estab".$count."' value='".$items["codrenae"]."|".$items["procedencia"]."|".$items["idestablesolicita"]."' />".strtoupper($items["procedencia"]);
		$nestedData[] = "<input type='hidden' id='anio".$count."' name='nro".$count."' value='".$items["anios"]."' />".strtoupper($items["anios"]);
		$nestedData[] = "<input type='hidden' id='anionro".$count."' name='anionro".$count."' value='".$items["anios"]."|".$items["correlativo"]."' />".strtoupper($items["correlativo"]);

		$nestedData[] = "<img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$items["idcorrelativo"].",".$count.",".$items["idpriva"].")' />";
	
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

