<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];
//echo json_encode($_SESSION);
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
	1 => 'fecharecepcion',
	2 => 'tipingreso',
	3 => 'proveedores',
	4 => 'proveedores',
	5 => 'comprob',
	6 => 'nrocomprobante',
	7 => 'fechacompra',
	8 => 'nrorden',
	9 => 'idingreso',
	10 => 'idingreso',
	11 => 'idingreso'
	
	);

	$sql = "SELECT idingreso  ";
	$sql.= " FROM vista_ingresomaterial ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idingreso from vista_ingresomaterial WHERE estareg!=3";
	$query1=$objconfig->execute_select($consul,1) ;

//	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2 
//	";
/*
	if ($idperfil != 1){
        $where = "WHERE idespecialidad=".$idespe;
	}
*/

$diagnosticos="";
	$sql = " select I.correlativo, VI.idingreso, VI.fecharecepcion, VI.comprob, VI.nrocomprobante::TEXT,VI.estareg,VI.fechacompra,";
	$sql.= "VI.tipingreso,VI.proveedores,VI.nrorden::TEXT,VI.nombre_usuario";
	$sql.= " FROM vista_ingresomaterial as VI inner join ingreso as I on VI.idingreso=I.idingreso  WHERE VI.estareg!=3 ";
	/*
	if($idperfil!=1){
		$sql.=" and VI.idusuario='".$_SESSION['id_user']."' ";
	}
	*/
	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (proveedores) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		//$sql.=" OR UPPER (fechacompra) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (tipingreso) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(comprob) LIKE UPPER ('%".$requestData['search']['value']."%') ";
	//	$sql.=" OR nrocomprobante LIKE '%".$requestData['search']['value']."%' ";
	//	$sql.=" OR to_char(nrorden) LIKE '%".$requestData['search']['value']."%' ";
		
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
		$nestedData[] = $items["correlativo"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);
		$nestedData[] = $items["nrorden"];
		$nestedData[] = $items["tipingreso"];
		$nestedData[] = $items["proveedores"];
		$nestedData[] = $items["comprob"];
		$nestedData[] = $items["nrocomprobante"];
		$nestedData[] = $items["fechacompra"];
		if (($items["estareg"]==3)){
			$nestedData[] = "ANULADO";
			$nestedData[] = "ANULADO" ;
		}else {
			
			$nestedData[] = "<button class='btn btn-success btn-xs center-block' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#impresiones' onclick='imprimir(".$items["idingreso"].")'><span class='glyphicon glyphicon-print'></span> Imprimir</button>";
		//	$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idingreso"].",".$items["idingreso"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
			$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='anular_form(3,".$items["idingreso"].")' class='btn btn-outline btn-danger btn-primary btn-xs'>Anular</button>";
                        $nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idingreso"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
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

