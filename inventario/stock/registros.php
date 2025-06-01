<?php

    session_start();
    $idperfil = $_SESSION['idperfil'];

	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
			
	$objconfig = new conexion();

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
	// datatable column index  => database column name
	0 => 'idstock',
	1 => 'unmedida',
	2 => 'matel',
	3 => 'model',
	3 => 'marc',
	4 => 'cantidad',
	5 => 'idstock',
	6 => 'idstock',
	7 => 'idstock',
	8 => 'idstock'
	);
	
	$sql = "SELECT idstock ";
	$sql.= " FROM vista_stock ";
	
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;


	$consul = "select idingreso from vista_stock";
	$query1=$objconfig->execute_select($consul,1) ;

	$diagnosticos="";
	$sql = " select idstock, unmedida, matel, marc, model,cantidad, tipmate,idunidad , idtipomaterial,idmarca,idtipobien,
				idmaterial,idmodelo ,vensim,lote,fvencimiento";
	$sql.= " from vista_stock WHERE 1=1 ";

	if( !empty($requestData['search']['value']) ) 
	{
			
		// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND  (UPPER (unmedida) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (tipmate) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (matel) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (model) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (marc) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR UPPER (vensim) LIKE UPPER ('%".$requestData['search']['value']."%') ";
		$sql.=" OR cast(cantidad as varchar) LIKE '".$requestData['search']['value']."%' ";
		$sql.=" OR cast(lote as varchar) LIKE '".$requestData['search']['value']."%' ";
		
		$sql.=" )";
		
	}

	$query=$objconfig->execute_select($sql,1) ;

	// when there is a search parameter then we have to modify total number filtered rows as per search result.
	$query = $objconfig->CantidadFilas($sql);
	$totalData = $query ;
	$totalFiltered = $totalData;
	
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['length']."  offset ".$requestData['start']." ";

	$query = $objconfig->execute_select($sql,1) ;

	$data = array();

	//$n=0;

	foreach($query[1] as $items)
		{
		
		/*	$fechavenc="";
            $row6 = $objconfig->execute_select("select fvencimiento from ingreso_det 
												where idmaterial=".$items["idmaterial"]." and idmodelo=".$items["idmodelo"]." and idingreso in (select idingreso from ingreso where estareg != 3) 
												group by fvencimiento order by fvencimiento asc
												",1);
            $n=0;
            foreach($row6[1] as $r6)
            {
                $n++;
            	$fechavenc.=$n.".- ".$objconfig->FechaDMY2($r6["fvencimiento"])."  ";
            }
		*/		
		$nestedData=array();
				
		$nestedData[] = $items["idstock"];
		$nestedData[] = strtoupper($items["tipmate"]);
		$nestedData[] = strtoupper($items["marc"]);
		$nestedData[] = strtoupper($items["model"]);
		$nestedData[] = strtoupper($items["unmedida"]);
		$nestedData[] = strtoupper($items["matel"]);
		$nestedData[] = $items["lote"];
		$nestedData[] = number_format($items["cantidad"],2);
		$nestedData[] = $items["vensim"];
	//	$nestedData[] = number_format($items["cantidad"],2);
		$nestedData[] = $objconfig->FechaDMY2($items["fvencimiento"]);
		//$nestedData[] = $fechavenc;
		//$nestedData[] = "<button type='button'  data-target='#userModal' data-toggle='modal' data-backdrop='static' data-keyboard='false' onclick='cargar_form(2,".$items["idsalida"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
	//	$nestedData[] = "<button type='button'  onclick='cargar_form(2,".$items["idsalida"].")' class='btn btn-outline btn-warning btn-primary btn-xs'>Editar</button>";
		
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



