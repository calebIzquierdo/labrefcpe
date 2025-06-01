<?php

    //session_start();
    //$idperfil = $_SESSION['idperfil'];


	include("../../objetos/class.conexion.php");


		
	$objconfig = new conexion();

    $idtm=$_GET["idtm"];
	
	$where ="";
	$consul = "select mt.idmaterial,tm.descripcion as tipo,mt.descripcion as matel,um.descripcion AS unmedida ,COALESCE (sm.cantidad,0) as cant 	     
		from materiales mt
		inner join stock_material sm on sm.idmaterial=mt.idmaterial
		inner join unidad_medida um ON um.idunidad = mt.idunidad
		inner join tipo_material tm on tm.idtipomaterial=mt.idtipomaterial";

	if($idtm !=-1){
		$where =" where mt.idtipomaterial = ".$idtm;
		$consul = $consul.$where;
	}

	$query=$objconfig->execute_select($consul,1) ;
    
    $data = array();
	foreach($query[1] as $items)
		{		
		$nestedData=array();
		
		$nestedData[] = $items["idmaterial"];
		$nestedData[] = $items["tipo"];
		$nestedData[] = $items["matel"];
		$nestedData[] = $items["unmedida"];
		$nestedData[] = $items["cant"];	
		
		$data[] = $nestedData;
		}
    
	echo json_encode($data);  // send data as json format

?>

