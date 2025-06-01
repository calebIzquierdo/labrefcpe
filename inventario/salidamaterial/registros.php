<?php

    session_start();
    

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

		
	$objconfig = new conexion();

   $idusuario = explode("|",$_SESSION['nombre']);

    $qesp = "select idespecialidad,idperfil from usuarios where idusuario=".$idusuario[0] ;

    $respecie = $objconfig->execute_select($qesp);
    $idespe = $respecie[1]["idespecialidad"];
	
	$idperfil = $respecie[1]['idperfil'];

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idsalida',
	1 => 'fechasalida',
	2 => 'nrorden',
	3 => 'solicitado',
	4 => 'entregadoo',
	5 => 'areatrabajo',
	6 => 'nrocomprobante',
	7 => 'fechacompra',
	8 => 'nrorden',
	9 => 'idsalida',
	10 => 'idsalida'

	
	);

	$sql = "SELECT idsalida  ";
	$sql.= " FROM vista_salida ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idsalida from vista_salida";
	$query1=$objconfig->execute_select($consul,1) ;

	$diagnosticos="";
	$sql = " select S.correlativo, VS.idsalida,VS.fechasalida,VS.nrorden,VS.tipingreso,VS.solicitado,VS.entregadoo,VS.areatrabajo ,VS.nombre_usuario,VS.estareg";
	$sql.= " FROM vista_salida as VS inner join salida as S on VS.idsalida=S.idsalida WHERE VS.estareg!=3";
	if($idperfil!=1){
		$sql.=" and VS.idusuario='".$_SESSION['id_user']."' ";
	}
	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (solicitado) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (tipingreso) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR correlativo LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (entregadoo) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (areatrabajo) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		//$sql.=" OR nrorden LIKE  ('%".$requestData['search']['value']."%') ";
				
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
		$nestedData[] = $items["correlativo"];
		$nestedData[] = $objconfig->FechaDMY($items["fechasalida"]);
		$nestedData[] = $items["nrorden"];
		$nestedData[] = $items["solicitado"];
		$nestedData[] = $items["tipingreso"];
		$nestedData[] = $items["entregadoo"];
		$nestedData[] = $items["areatrabajo"];
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

