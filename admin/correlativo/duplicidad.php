<?php
	include("../../objetos/class.conexion.php");
	include("../../objetos/class.funciones.php");

	$objconfig = new conexion();

	$idestable = $_POST["ides"];
	$anio = $_POST["anio"];

	$query = "select count(*) as cant FROM correlativo_estable WHERE idestablesolicita=".$idestable." and  idanio= ".$anio."  and estareg=1 ";
	// echo $query."\n" ;
	$row = $objconfig->execute_select($query);
	// echo "cantidad: ".$row[1]["cant"]."\n" ;
	if($row[1]["cant"]!=0)
	{
		echo "El codigo ya se encuetra registrado|1";
	}else{
		echo "no|0";
		//echo "Aun no ha Asignado el Precio de Compra de los Productos|0";
	}
?>
