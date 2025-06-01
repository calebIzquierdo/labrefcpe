<?php

    //session_start();
    //$idperfil = $_SESSION['idperfil'];

	
	include("../../../objetos/class.conexion.php");
	

	$objconfig = new conexion();

	$red=$_GET["red"];
	$mred=$_GET["mred"];
	$eess=$_GET["eess"];
	$area=$_GET["area"];
	$sarea=$_GET["sarea"];

	// storing  request (ie, get/post) global array to a variable 
	$requestData = $_REQUEST;
	// Inicio de la consulta 
	$columns = array( 
        0 => 'subarea',
        1 => 'responsable',
        2 => 'bien',
        3 => 'codpatrimonial',
        4 => 'codpatrimoniallab',
	5 => 'nroserie',
	6 => 'modelos',	
        7 => 'marca',
	8 => 'color',
        9 => 'estado'
       
	);


	$sql1 = "SELECT idinventariodetalle FROM inventario_Detalle";
	$query1 = $objconfig->CantidadFilas($sql1);
	$totalData = $query1 ;
	$totalFiltered = $totalData;


	$consul = "SELECT idinventariodetalle FROM inventario_Detalle";
	$query1 = $objconfig->execute_select($consul, 1) ;


	$sql = "select at.descripcion as subarea,p.nombres as responsable,m.descripcion as bien ,invdet.codpatrimonial,
	invdet.codpatrimoniallab,invdet.nroserie,mo.descripcion as modelos,ma.descripcion as marca
	,invdet.color,invdet.estado
	from inventario_Detalle invdet
	inner join inventario_cabecera invcab on invcab.idinventario=invdet.idinventario
	inner join areas ar on ar.idarea = invdet.idarea
	inner join area_trabajo at on at.idareatrabajo=invdet.idareatrabajo
	inner join materiales m on m.idmaterial=invdet.idmaterial
	inner join personal p on p.idpersonal=invdet.idpersonal
	inner join modelo mo on mo.idmodelo=invdet.idmodelo
	inner join marcas ma on ma.idmarca=invdet.idmarca
	";
	//where invcab.idred='' and invcab.idmicrored='' and invcab.idestablecimiento=''
	
    if($red !=-1 && $mred =='undefined' && $eess =='undefined' && $area =='undefined' && $sarea =='undefined'){
		$where =" where invcab.idred = ".$red;
		$sql = $sql.$where;
	}
   
	if($red !=-1 && $mred !='undefined' && $eess =='undefined' && $area =='undefined' && $sarea =='undefined'){
		$where =" where invcab.idred = ".$red." and invcab.idmicrored=".$mred;
		$sql = $sql.$where;
	}

	if($red !=-1 && $mred !='undefined' && $eess !='undefined' && $area =='undefined' && $sarea =='undefined'){
		$where =" where invcab.idred = ".$red." and invcab.idmicrored=".$mred." and invcab.idestablecimiento=".$eess;
		$sql = $sql.$where;
	}

	if($red !=-1 && $mred !='undefined' && $eess !='undefined' && $area !='undefined' && $sarea !='undefined'){
		$where =" where invcab.idred = ".$red." and invcab.idmicrored=".$mred." and invcab.idestablecimiento=".$eess." and invdet.idarea=".$area." and invdet.idareatrabajo=".$sarea;
		$sql = $sql.$where;
	}

	/*if( !empty($requestData['search']['value']) ) 
	{
		$sql.=" WHERE ( UPPER(at.descripcion) LIKE UPPER('%".$requestData['search']['value']."%') ";
		$sql.=" OR m.descripcion  LIKE ('%".$requestData['search']['value']."%')";
	}*/
	
	$sql.=" ORDER BY at.descripcion ".$requestData['order'][0]['dir']." ";



	//echo $sql;
	//exit();
	$query = $objconfig->execute_select($sql,1) ;
	//var_dump($query);
	//echo $query[1];
	//exit();
	$data = array();
	foreach($query[1] as $items)
		{		
		$nestedData=array();
		
		$nestedData[] = $items["subarea"];
		$nestedData[] = $items["responsable"];
		$nestedData[] = $items["bien"];
		$nestedData[] = $items["codpatrimonial"];
		$nestedData[] = $items["codpatrimoniallab"];
		$nestedData[] = utf8_encode($items["nroserie"]);
		$nestedData[] = $items["modelos"];
		$nestedData[] = $items["marca"];
		$nestedData[] = $items["color"];
		$nestedData[] = $items["estado"];	
		
		$data[] = $nestedData;
		}
    

	//echo json_encode($data);  // send data as json format
	//$totalFiltered=$totalData;
	$totalFiltered=0;
	$json_data = array(
        "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
        "recordsTotal"    => intval( $totalData ),  // total number of records
        "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            => $data   // total data array
    );
	echo json_encode($json_data);  // send data as json format
?>

