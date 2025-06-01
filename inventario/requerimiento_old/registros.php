<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];
//echo $idperfil;
//exit();

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

		
	$objconfig = new conexion();

 
	$requestData = $_REQUEST;
	// Inicio de la consulta 

	$columns = array( 
	// datatable column index  => database column name
	0 => 'idrequerimiento',
	1 => 'correlativo',
	2 => 'fecharequerimiento',
	3 => 'idarea',
	4 => 'area',
	5 => 'idarea_trabajo',
	6 => 'subarea',
	7 => 'idpersonal',
	8 => 'solicitante',
	9 => 'estareg',
	10 => 'nombres',
	11 => 'nombres'

	
	);

	$sql = "SELECT idrequerimiento  ";
	$sql.= " FROM vista_requerimiento ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idrequerimiento from vista_requerimiento";
	$query1=$objconfig->execute_select($consul,1) ;

//	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2 
//	";
/*
	if ($idperfil != 1){
        $where = "WHERE idespecialidad=".$idespe;
	}
*/

	$diagnosticos="";
	$sql = " select vs.* ";
	$sql.= " FROM vista_requerimiento vs WHERE estareg!=3";
	if($idperfil!=1){
		$sql.=" and vs.idusuario='".$_SESSION['id_user']."' ";
	}
	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (area) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (subarea) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (solicitante) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (nombres) LIKE UPPER ('%".$requestData['search']['value']."%') ";		
		$sql.=" OR UPPER (correlativo) LIKE UPPER ('%".$requestData['search']['value']."%') ";		
		
		$sql.=" )";
		
	}
//echo $sql;
//exit();
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
		
		$nestedData[] = $items["idrequerimiento"];
		$nestedData[] = $items["correlativo"];
		$nestedData[] = $objconfig->FechaDMY($items["fecha"]);
		$nestedData[] = $items["area"];
		$nestedData[] = $items["subarea"];
		$nestedData[] = $items["solicitante"];		
		if (($items["estareg"]==3)){
			$nestedData[] = "ANULADO";
		}else {
			$nestedData[] = "<button class='btn btn-success btn-xs center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idrequerimiento"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
		//	$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idsalida"].",".$items["idsalida"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
			if (($items["estareg"]==4)){
				$nestedData[] = "<span>---</span>";
				$nestedData[] = "<span>---</span>";
			}else{
				$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='anular_form(3,".$items["idrequerimiento"].")' class='btn btn-outline btn-danger btn-primary btn-xs'>Anular</button>";
				$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idrequerimiento"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
			}
		    
		}
		if($items["estareg"]==4){
			$nestedData[] = '<p style="color:#51B924">'.$items["estado"].'</p>';
		}else{
			$nestedData[] = $items["estado"];
		}
		$nestedData[] = $items["nombres"];
		
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

