<?php

    //session_start();
    //$idperfil = $_SESSION['idperfil'];


	include("../../objetos/class.conexion.php");


		
	$objconfig = new conexion();

    $idtm=$_GET["idtm"];
    $idlab=$_GET["idlab"];
	
	$where ="";
	$consul = "select idkit,cantidad,idmaterial, serie,fvencimiento,idejecutora,idred,idmicrored,idestablecimiento,
				correlativo,fecharecepcion, idejecutorasolicita,idredsolicita,idmicroredsolicita,idestablesolicita,
				fechadigitacion,micro_solicita,estab_solicita,red_solicita,eje_solicita,umedida,tipmate,materia,marc,
				lote,idregistro,cantkits,totales
				/*um.descripcion AS unmedida ,COALESCE (sm.cantidad,0) as cant 	   */  	     
				from vista_kitsalida_det 
		";

	if($idtm ==0 && $idlab ==0 ){
		$where =" where 1=1 order by estab_solicita asc ";
	}elseif ($idlab ==0 && $idtm !=0){
		$where =" where idmaterial = ".$idtm." order by estab_solicita asc";
	}elseif($idlab !=0 && $idtm ==0){
		$where =" where idestablesolicita = ".$idlab." order by estab_solicita asc";;
	} else {
		$where =" where idestablesolicita = ".$idlab." and idmaterial = ".$idtm." order by estab_solicita asc";;
	}
	$consul = $consul.$where;
	//echo $consul;
	$query=$objconfig->execute_select($consul,1) ;
	
    $count =0;
    $saldo =0;
    $TotalSaldo =0;
	
    $data = array();
	foreach($query[1] as $items)
		{		
		$count++;
		$nestedData=array();
		
		if($items["idregistro"]==0){
			$saldo= $items["cantkits"];
		}else {
			$saldo = $items["totales"];
		}
		
		$TotalSaldo += $saldo;
		
		$nestedData[] = $count;
		$nestedData[] = $items["estab_solicita"];
		$nestedData[] = $items["materia"];
		$nestedData[] = $items["marc"];
		$nestedData[] = $items["lote"];
		$nestedData[] = $saldo;	
		//$nestedData[] = $TotalSaldo;	
		
		$data[] = $nestedData;
		}
    
	echo json_encode($data);  // send data as json format

?>

