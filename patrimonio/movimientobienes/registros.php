<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];
//echo json_encode($_SESSION);
	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

		
	$objconfig = new conexion();

 
	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name fechainventario usuario
	0 => 'idinventario',
	1 => 'nroinventario',
	2 => 'fechainventario',
	3 => 'usuario',
	4 => 'idinventario',
	5 => 'idinventario'
	
	);

	$sql = "SELECT idinventario  ";
	$sql.= " FROM inventario_cabecera ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idinventario from inventario_cabecera WHERE estareg!=3";
	$query1=$objconfig->execute_select($consul,1) ;

	$diagnosticos="";
	//$sql = " select I.correlativo, VI.idingreso, VI.fecharecepcion, VI.comprob, VI.nrocomprobante,VI.estareg,VI.fechacompra,VI.tipingreso,VI.proveedores,VI.nrorden,VI.nombre_usuario";
	/*$sql = " select IC.nroinventario, IC.fechainventario ,MR.descripcion as microred, E.descripcion as ejecutora, R.descripcion as red,ES.descripcion as establecimiento,U.nombres as usuario";
	$sql.= " FROM inventario_cabecera as IC inner join ejecutora as E on IC.idejecutora =E.idejecutora 
	inner join microred as MR on IC.idmicrored=MR.idmicrored
	inner join red as R on IC.idred =R.idred 
	inner join establecimiento ES on IC.idestablecimiento=ES.idestablecimiento
	inner join usuarios as U on IC.idusuario=U.idusuario
	WHERE IC.estado!=3 ";
	if($idperfil!=1){
		$sql.=" and IC.idusuario='".$_SESSION['id_user']."' ";
	}*/
	/* if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (proveedores) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		//$sql.=" OR UPPER (fechacompra) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (tipingreso) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER(comprob) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR  nrocomprobante LIKE  '%".$requestData['search']['value']."%' ";
		$sql.=" OR nrorden LIKE '%".$requestData['search']['value']."%' ";
		
		$sql.=" )";
		
	} */

	$query=$objconfig->execute_select($sql,1) ;

	// when there is a search parameter then we have to modify total number filtered rows as per search result.
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";

	 /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
	//echo $sql;
	$query = $objconfig->execute_select($sql,1) ;

	$data = array();

	$n=0;

	foreach($query[1] as $items)
		{
			$n++;
		$nestedData=array();
		$nestedData[] = $n;
		$nestedData[] = $items["nroinventario"];
		$nestedData[] = $items["usuario"];
		$nestedData[] = $items["fechainventario"];
		$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='anular_form(3,".$items["idingreso"].")' class='btn btn-outline btn-danger btn-primary btn-xs'>Anular</button>";
     	$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idingreso"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		
		$nestedData[] = $items["usuario"];
		
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

