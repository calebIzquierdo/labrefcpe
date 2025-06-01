<?php
	include("../../objetos/class.conexion.php");
	include("../../objetos/class.funciones.php");

	$objconfig = new conexion();

	$nrodoc = $_POST["nrodoc"];
	$tdoc	= $_POST["tdoc"];

	$nref = trim($_POST["nrodoc"]);

	$query = "select count(*) as cant FROM paciente WHERE nrodocumento='".$nref."' and iddocumento='".$tdoc."'";
	$row = $objconfig->execute_select($query);

	if($row[1]["cant"]!=0)
	{
		echo "El numero de Documento ya Existe|1";
	}else{
		echo "no|0";
		//echo "Aun no ha Asignado el Precio de Compra de los Productos|0";
	}
?>
