<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$sql5 	= "delete from meses ";
	$rows5	= $objconfig->execute_select($sql5);
	
	$sql 	= "delete from tablero_origen";
	$rows	= $objconfig->execute_select($sql);
	
	$sql2 	= "delete from tablero_destino";
	$rows2	= $objconfig->execute_select($sql2);
	
	$sql3 	= "delete from tablero ";
	$rows3	= $objconfig->execute_select($sql3);
	
	$sql4 	= "update indicadores set valor_anterior=0, valor_actual=0, ultimo_mes='' ";
	$rows4	= $objconfig->execute_select($sql4);
	
	$sql6 	= "delete from tablero_rechazado ";
	$rows6	= $objconfig->execute_select($sql6);
	
	$sql7 	= "delete from tablero_ups ";
	$rows7	= $objconfig->execute_select($sql7);
	
	$sql8 	= "delete from tablero_diagnostico ";
	$rows8	= $objconfig->execute_select($sql8);
	
	$sql9 	= "delete from tablero_seguro ";
	$rows9	= $objconfig->execute_select($sql9);
	
	$sql10	= "delete from tablero_diagnostico_envio ";
	$rows10	= $objconfig->execute_select($sql10);
	
	
	
?>