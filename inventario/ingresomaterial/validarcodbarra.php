<?php
	include("../../objetos/class.conexion.php");
	include("../../objetos/class.funciones.php");

	$objconfig = new conexion();

	$codba = trim($_POST["nrocodb"]);

	$query = "select count(codbarra) as cant FROM muestra WHERE UPPER(codbarra) LIKE UPPER('".$codba."') and estareg=1 ";
	$row = $objconfig->execute_select($query);

	if($row[1]["cant"]!=0)
	{
		echo "El codigo ya se encuetra registrado|1";
	}else{
		echo "no|0";
		//echo "Aun no ha Asignado el Precio de Compra de los Productos|0";
	}
?>
