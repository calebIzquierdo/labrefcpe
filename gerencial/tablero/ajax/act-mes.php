<?php
	include_once("../../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$idindicador 	= $_POST["idindicador"];
	$anio			= $_POST["anio"];
	$mes			= $_POST["mes"];
			
	$meses = array("1"=>"enero",
				 "2"=>"febrero",
				 "3"=>"marzo",
				 "4"=>"abril",
				 "5"=>"mayo",
				 "6"=>"junio",
				 "7"=>"julio",
				 "8"=>"agosto",
				 "9"=>"setiembre",
				 "10"=>"octubre",
				 "11"=>"noviembre",
				 "12"=>"diciembre");

		$queryI = "select * from indicadores where idindicador=".$idindicador;
		$row = $objconfig->execute_select($queryI);
	
		$sqlMes = "select ".$meses[$mes]." as valor from tablero 
				 where anio='".$anio."' and idindicador=".$idindicador;
		$rowMes=$objconfig->execute_select($sqlMes);


	if($row[1]["valor_actual"]==$rowMes[1]["valor"]){$color="yellow";}
	if($row[1]["valor_actual"]>$rowMes[1]["valor"]){$color="green";}
	if($row[1]["valor_actual"]<$rowMes[1]["valor"]){$color="red";}

	echo number_format($rowM[1]["val"],2)."|".$color."|".number_format($rowMes[1]["valor"],2);
	
?>