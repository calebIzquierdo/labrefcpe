<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

		
	$objconfig = new conexion();
	
	 $idusuario = explode("|",$_SESSION['nombre']);

    $qesp = "select idusuario, idejecutora, idmicrored,idestablecimiento,idespecialidad,idtipo_topico,idred,
			idservicio,idtiposervicio, idnivelreporte,idvencimiento from usuarios where idusuario=".$_SESSION['id_user'] ;

    $est = $objconfig->execute_select($qesp);
    $idesta = $est[1]["idestablecimiento"];
	
	switch ($est[1]["idnivelreporte"]) 
	{
		case 1:
		   if($est[1]["idestablecimiento"]==388 || $est[1]["idestablecimiento"]==402 ){
				$where =" WHERE estareg=1 and idestablesolicita=388 or idestablesolicita=402";
			}else {
				$where =" WHERE estareg=1 and idestablesolicita IN(select idestablecimiento 
						from vista_establecimiento where idestablesolicita=".$est[1]["idestablecimiento"].") ";
			}
			break;
		case 2:
			$where =" WHERE estareg=1 and idestablesolicita IN(select idestablecimiento 
						from vista_establecimiento where idmicrored=".$est[1]["idmicrored"].") ";
			break;
		case 3:
			$where =" WHERE estareg=1 and idestablesolicita IN(select idestablecimiento 
						from vista_establecimiento where idred=".$est[1]["idred"].") ";
			break;
		case 4:
			 $where =" WHERE estareg=1 and idestablesolicita IN(select idestablecimiento 
						from vista_establecimiento where idejecutora=".$est[1]["idejecutora"].") ";
			break;
		default:
			$where =" WHERE estareg=1  ";
	}

	

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idcodigobarra',
	1 => 'rdes',
	2 => 'mred',
	3 => 'procedencia',
	4 => 'nombre_correlativo',
	5 => 'fechareg',
	6 => 'horareg',
	7 => 'idcodigobarra',
	8 => 'idcodigobarra'
	
	);

	$sql = "SELECT idcodigobarra  ";
	$sql.= " FROM vista_codigos_barra ".$where;


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idcodigobarra from vista_codigos_barra ".$where;
	$query1=$objconfig->execute_select($consul,1) ;


	$sql = " select idcodigobarra, final_correlativo, nombre_correlativo,fechareg, procedencia,nombre_usuario,estado,mred,rdes,codrenaes,horareg  ";
	$sql.= " FROM vista_codigos_barra ".$where;
	
	//echo $sql;
	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (procedencia) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper (mred) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (rdes) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (codrenaes) LIKE upper ('%".$requestData['search']['value']."%' )";
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
		
		$nestedData[] = $items["idcodigobarra"];
		$nestedData[] = $items["codrenaes"];
		$nestedData[] = $items["rdes"];
		$nestedData[] = $items["mred"];
		$nestedData[] = $items["procedencia"];
		$nestedData[] = $items["nombre_correlativo"];
		$nestedData[] = $items["final_correlativo"];
		$nestedData[] = $objconfig->FechaDMY2($items["fechareg"]);
		$nestedData[] = $items["horareg"];
		$nestedData[] = "<button type='button' onclick='excel_ficha(".$items["idcodigobarra"].")' class='btn btn-outline btn-success btn-xs'><img src='../img/xls.png' alt='Exportar Excsl' width='20' height='20'></button>";
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

