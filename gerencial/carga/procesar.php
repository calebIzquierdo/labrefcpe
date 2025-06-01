<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$periodo = explode("|",$_POST["periodo"]); 
	
	$mes	= $periodo[0];
	$anio	= $periodo[1];
	
	$meses = array(1=>"Enero",
					2=>"Febrero",
					3=>"Marzo",
					4=>"Abril",
					5=>"Mayo",
					6=>"Junio",
					7=>"Julio",
					8=>"Agosto",
					9=>"Setiembre",
					10=>"Octubre",
					11=>"Noviembre",
					12=>"Diciembre"
				   );
	
	include "calculo/primer-indicador.php"; 
	
	include "calculo/segundo-indicador.php";
	
	include "calculo/tercer-indicador.php";
	
	include "calculo/cuarto-indicador.php";
	
	include "calculo/quinto-indicador.php";
	
	include "calculo/sexto-indicador.php"; 
	
	include "calculo/septimo-indicador.php"; 
	
	include "calculo/octavo-indicador.php";
	
	include "calculo/noveno-indicador.php";
	
	include "calculo/decimo-indicador.php";
	/*
	include "calculo/decimo-indicadorB.php";  
	*/
	
	$sql 	= "select * from meses where anio='$anio' and mes='$mes' ";
	$rows	= $objconfig->execute_select($sql);
	
	if($rows[1]==null)
	{
		$inst = "insert into meses(anio,mes) values('$anio','$mes')";
		$objconfig->execute($inst);
	}
	
?>