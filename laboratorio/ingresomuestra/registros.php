<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
	$carpeta = "../../upload/referencia";

		
	$objconfig = new conexion();

	$idusuario = explode("|",$_SESSION['nombre']);

    $qesp = "select editar from usuarios where idusuario=".$idusuario[0] ;
    $ed = $objconfig->execute_select($qesp);
    $edita = $ed[1]["editar"];

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idingresomuestra',
	1 => 'fecharecepcion',
	2 => 'rdes',
	3 => 'mred',
	4 => 'procedencia',
	5 => 'tipoatencion',
	6 => 'nombre_usuario',
	7 => 'estado_examen',
	8 => 'codbarra',
	9 => 'idingresomuestra',
	10 => 'idingresomuestra',
	11 => 'idingresomuestra'
	
	);

	$sql = "SELECT idingresomuestra  ";
	$sql.= " FROM vista_muestra ";


	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idingresomuestra from vista_muestra";
	$query1=$objconfig->execute_select($consul,1) ;

//	$where ="WHERE 1=1 and  idcontrareferencia=0 and idanulado =0 and idcondreferencia!=2 
//	";
/*
	if ($idperfil != 1){
        $where = "WHERE idespecialidad=".$idespe;
	}
*/

$diagnosticos="";
	$sql = " select idingresomuestra, fecharecepcion, tipoatencion, procedencia,nombre_usuario,estareg,estado_examen,mred,rdes,codbarra ";
	$sql.= " FROM vista_muestra WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (codbarra) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR upper (tipoatencion) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR upper (procedencia) LIKE upper ('%".$requestData['search']['value']."%' )";
		$sql.=" OR UPPER (estado_examen) LIKE UPPER ('%".$requestData['search']['value']."%') ";
	//	$sql.=" OR UPPER (nombre_cliente) LIKE UPPER ('%".$requestData['search']['value']."%') ";
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

            $diagnosticos="";

            $row6 = $objconfig->execute_select("select idtipo_examen from muestra_det 
													where idingresomuestra=".$items["idingresomuestra"],1);
            $n=0;
            foreach($row6[1] as $r6)
            {
                $n++;
            	$rowsDiag = $objconfig->execute_select("SELECT descripcion FROM tipo_examen WHERE idtipo_examen =".$r6["idtipo_examen"]);
            	$diagnosticos.=$n.".-".$rowsDiag[1]["descripcion"]." ";
            }
			
			$subarea="";

            $rowA = $objconfig->execute_select("select idareatrabajo from muestra_det 
													where idingresomuestra=".$items["idingresomuestra"],1);
            $n=0;
            foreach($rowA[1] as $r6A)
            {
                $n++;
            	$rowsSub = $objconfig->execute_select("SELECT descripcion FROM area_trabajo WHERE idareatrabajo =".$r6A["idareatrabajo"]);
            	$subarea.=$n.".-".$rowsSub[1]["descripcion"]." ";
            }
			
			
			
		$nestedData=array();
		
		$nestedData[] = $items["idingresomuestra"];
		$nestedData[] = $objconfig->FechaDMY($items["fecharecepcion"]);
		$nestedData[] = $items["codbarra"];
		$nestedData[] = $items["procedencia"];
	$nestedData[] = $items["tipoatencion"];
	//	$nestedData[] = $items["nombre_cliente"];
		$nestedData[] = $diagnosticos;
		$nestedData[] = $subarea;
		$nestedData[] = $items["estado_examen"];
		
		if ($items["estareg"]==1){
		$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idingresomuestra"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		$nestedData[] = "<button type='button'  onclick='anular_referencia(".$items["idingresomuestra"].",".$items["idingresomuestra"].")' class='btn btn-outline btn-danger btn-xs'>Elimar Registro</button>";
	//	} else if (($items["estareg"]==2)){
		} else if (($items["estareg"]==2 && $edita==1)){
			//$nestedData[] = "PROCESADO";
			$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idingresomuestra"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
			$nestedData[] = "PROCESADO";
		}else {
			$nestedData[] = "ANULADO";
			$nestedData[] = "ANULADO" ;
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

