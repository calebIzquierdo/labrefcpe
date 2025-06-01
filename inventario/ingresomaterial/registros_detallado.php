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
	0 => 'idingreso',
	1 => 'fechacompra',
	2 => 'marc',
	3 => 'tipmate',
	4 => 'matel',
	5 => 'cantidad',
	6 => 'nrocomprobante',
	7 => 'fvencimiento',
	8 => 'nrorden',
	9 => 'idingreso',
	10 => 'idingreso',
	11 => 'idingreso',
	12 => 'idingreso',
	13 => 'idingreso'
	
	);

	$sql = "SELECT idingreso  ";
	$sql.= " FROM vista_material_detalle_old ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idingreso from vista_material_detalle_old";
	$query1=$objconfig->execute_select($consul,1) ;

//	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2 
//	";
/*
	if ($idperfil != 1){
        $where = "WHERE idespecialidad=".$idespe;
	}
*/

$diagnosticos="";
	$sql = " select idingreso, fechacompra, unmedida,tipmate,matel,cantidad,fvencimiento,nrocomprobante,estareg,marc,nombre_usuario,model,tip_comp ";
	$sql.= " FROM vista_material_detalle_old WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (unmedida) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (tipmate) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (matel) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (marc) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (tip_comp) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (model) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (nrocomprobante) LIKE UPPER ('%".$requestData['search']['value']."%') ";
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
		
		$nestedData[] = $items["idingreso"];
		$nestedData[] = $objconfig->FechaDMY($items["fechacompra"]);
		$nestedData[] = $items["tip_comp"];
		$nestedData[] = $items["nrocomprobante"];
		$nestedData[] = $items["marc"];
		$nestedData[] = $items["model"];
		$nestedData[] = $items["tipmate"];
		$nestedData[] = $items["unmedida"];
		$nestedData[] = $items["matel"];
		$nestedData[] = number_format($items["cantidad"],2);
		$nestedData[] = $objconfig->FechaDMY($items["fvencimiento"]);
		if (($items["estareg"]==3)){
			$nestedData[] = "ANULADO";
			$nestedData[] = "ANULADO" ;
		}else {
		//	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idingreso"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
			$nestedData[] = "<button class='btn btn-success btn-xs center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idingreso"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
		//	$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idingreso"].",".$items["idingreso"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
			$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='anular_form(3,".$items["idingreso"].")' class='btn btn-outline btn-danger btn-primary btn-xs'>Anular</button>";
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

