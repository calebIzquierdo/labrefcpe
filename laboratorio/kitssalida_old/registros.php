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
	
	$where = "WHERE 1=1  ";
	if ($est[1]["idnivelreporte"]==1){
		$where ="WHERE 1=1 and  idestablesolicita=".$est[1]["idestablecimiento"]." 
		";

	}

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idkit',
	1 => 'fecharecepcion',
	2 => 'correlativo',
	3 => 'estab_solicita',
	4 => 'umedida',
	5 => 'areatrabajo',
	6 => 'nrocomprobante',
	7 => 'fechacompra',
	8 => 'correlativo',
	9 => 'idkit'
	//10 => 'idkit'

	
	);

	$sql = "SELECT idkit  ";
	$sql.= " FROM vista_kitsalida_det ".$where;


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idkit from vista_kitsalida_det";
	$query1=$objconfig->execute_select($consul,1) ;


	$diagnosticos="";
	$sql = " select correlativo, idkit,fecharecepcion,estab_solicita,umedida,tipmate,materia,marc,";
	$sql .=" idregistro,nombre_usuario,estareg,cantkits,totales,lote";
	$sql.= " FROM vista_kitsalida_det  ".$where;
	/*
	if($idperfil!=1){
		$sql.=" and VS.idusuario='".$_SESSION['id_user']."' ";
	}
	*/
	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (estab_solicita) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR materia LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR marc LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR estab_solicita LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR lote LIKE UPPER ('%".$requestData['search']['value']."%') ";
		//$sql.=" OR correlativo LIKE  ('%".$requestData['search']['value']."%') ";
				
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
		
		$nestedData[] = $items["idkit"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);
		$nestedData[] = $items["estab_solicita"];
		$nestedData[] = $items["umedida"];
		$nestedData[] = $items["tipmate"];
		$nestedData[] = $items["materia"];
		$nestedData[] = $items["marc"];
		if ($items["idregistro"]==0){
			$nestedData[] = $items["cantkits"];
		}else {
			$nestedData[] = $items["totales"];
			//$nestedData[] = $items["lote"];
		}
		$nestedData[] = $items["lote"];
		
			$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_control(2,".$items["idkit"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		//	$nestedData[] = "";
			
			$nestedData[] = "<button class='btn btn-success btn-xs center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idkit"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
		//	$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idkit"].",".$items["idkit"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
		///$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='anular_form(3,".$items["idkit"].")' class='btn btn-outline btn-danger btn-primary btn-xs'>Anular</button>";
		
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

