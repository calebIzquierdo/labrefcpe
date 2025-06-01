<?php
	include_once("../../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$idindicador 	= $_POST["idindicador"];
	$anio			= $_POST["anio"];
	$mes			= $_POST["mes"];
	$idestable		= $_POST["idestable"];
	$tipoRef		= $_POST["tref"];
		
	$meses = array("01"=>"enero",
				 "02"=>"febrero",
				 "03"=>"marzo",
				 "04"=>"abril",
				 "05"=>"mayo",
				 "06"=>"junio",
				 "07"=>"julio",
				 "08"=>"agosto",
				 "09"=>"setiembre",
				 "10"=>"octubre",
				 "11"=>"noviembre",
				 "12"=>"diciembre");

	if( $idindicador==2)
	{
		$queryM = "select ".$meses[$mes]."  as val from tablero_origen
				   where idindicador=".$idindicador." and anio='".$anio."' and idorigen_establecimiento=".$idestable;
		$rowM 	= $objconfig->execute_select($queryM);
		
		$sqlA = "select ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero_origen 
				 where anio='".$anio."' and idindicador=".$idindicador." and idorigen_establecimiento=".$idestable;
		
		$rowA=$objconfig->execute_select($sqlA);
		
		$queryI = "select * from indicadores where idindicador=".$idindicador;
		$rowM = $objconfig->execute_select($queryI);
		
			if($rowM[1]["valor_actual"]==$rowA[1]["valor"]){$color="yellow";}
			if($rowM[1]["valor_actual"]>$rowA[1]["valor"]){$color="green";}
			if($rowM[1]["valor_actual"]<$rowA[1]["valor"]){$color="red";}
		
			echo number_format($rowM[1]["valor_actual"],2)."|".$color."|";
	}
	
	if($idindicador==3 )
	{
		$queryM = "select ".$meses[$mes]."  as val from tablero_sector
				   where idindicador=".$idindicador." and anio='".$anio."' and idsector=".$idsector;
		$rowM 	= $objconfig->execute_select($queryM);
		
		$sqlA = "select ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero_sector 
				 where anio='".$anio."' and idindicador=".$idindicador." and idsector=".$idsector;
		$rowA=$objconfig->execute_select($sqlA);
	}
	
	if( $idindicador==4)
	{
		$queryM = "select ".$meses[$mes]."  as val from tablero_destino
				   where idindicador=".$idindicador." and anio='".$anio."' and codemp=".$idestable." and idtiporeferencia=".$tipoRef;
		$rowM 	= $objconfig->execute_select($queryM);
		
		$sqlA = "select ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero_destino 
				 where anio='".$anio."' and idindicador=".$idindicador." and codemp=".$idestable." and idtiporeferencia=".$tipoRef;
		$rowA=$objconfig->execute_select($sqlA);
		
		$queryI = "select * from indicadores where idindicador=".$idindicador;
		$rowM = $objconfig->execute_select($queryI);
		
			if($rowM[1]["valor_actual"]==$rowA[1]["valor"]){$color="yellow";}
			if($rowM[1]["valor_actual"]>$rowA[1]["valor"]){$color="green";}
			if($rowM[1]["valor_actual"]<$rowA[1]["valor"]){$color="red";}
		
			echo number_format($rowM[1]["valor_actual"],2)."|".$color."|";
			
	}
	if($idindicador==6)
	{
		$queryM = "select ".$meses[$mes]."  as val from tablero
				   where idindicador=".$idindicador." and anio='".$anio."' ";
		$rowM 	= $objconfig->execute_select($queryM);
		
		$sqlA = "select ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero 
				 where anio='".$anio."' and idindicador=".$idindicador." ";
		$rowA=$objconfig->execute_select($sqlA);
		
		$queryI = "select * from indicadores where idindicador=".$idindicador;
		$rowM = $objconfig->execute_select($queryI);
		
			if($rowM[1]["valor_actual"]==$rowA[1]["valor"]){$color="yellow";}
			if($rowM[1]["valor_actual"]>$rowA[1]["valor"]){$color="green";}
			if($rowM[1]["valor_actual"]<$rowA[1]["valor"]){$color="red";}
		
			echo number_format($rowM[1]["valor_actual"],2)."|".$color."|";
	}
	
	if($idindicador==10)
	{
		$queryM = "select ".$meses[$mes]."  as val from tablero
				   where idindicador=".$idindicador." and anio='".$anio."' ";
		$rowM 	= $objconfig->execute_select($queryM);
		
		$sqlA = "select ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero 
				 where anio='".$anio."' and idindicador=".$idindicador." ";
		$rowA=$objconfig->execute_select($sqlA);
		
		$queryI = "select * from indicadores where idindicador=".$idindicador;
		$rowM = $objconfig->execute_select($queryI);
		
			if($rowM[1]["valor_actual"]==$rowA[1]["valor"]){$color="yellow";}
			if($rowM[1]["valor_actual"]>$rowA[1]["valor"]){$color="green";}
			if($rowM[1]["valor_actual"]<$rowA[1]["valor"]){$color="red";}
		
			echo number_format($rowM[1]["valor_actual"],2)."|".$color."|";
	}
	
	/*
	if($idindicador==3 || $idindicador==7)
	{
		$queryM = "select ".$meses[$mes]."  as val from tablero_sector
				   where idindicador=".$idindicador." and anio='".$anio."' and idsector=".$idsector;
		$rowM 	= $objconfig->execute_select($queryM);
		
		$sqlA = "select ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero_sector 
				 where anio='".$anio."' and idindicador=".$idindicador." and idsector=".$idsector;
		$rowA=$objconfig->execute_select($sqlA);
	}
	
	if($idindicador==4)
	{
		$queryM = "select ".$meses[$mes]."  as val from tablero_productos
		where idindicador=".$idindicador." and anio='".$anio."' and idtipoproducto=".$idsector;
		$rowM 	= $objconfig->execute_select($queryM);
	
		$sqlA = "select ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero_productos
		where anio='".$anio."' and idindicador=".$idindicador." and idtipoproducto=".$idsector;
		$rowA=$objconfig->execute_select($sqlA);
	}
	if($idindicador==8)
	{
		$queryM = "select DISTINCT ".$meses[$mes]."  as val from tablero_productor
				   where idindicador=".$idindicador." and anio='".$anio."' and idproductor=".$idsector." ";
		$rowM 	= $objconfig->execute_select($queryM);
		
		$sqlA = "select DISTINCT ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero_productor
				 where anio='".$anio."' and idindicador=".$idindicador." and idproductor=".$idsector;
		$rowA=$objconfig->execute_select($sqlA);
	}

	if($idindicador==9 || $idindicador==10)
	{
		$queryM = "select ".$meses[$mes]."  as val from tablero_certificados
		where idindicador=".$idindicador." and anio='".$anio."' and idcertificado=".$idsector;
		$rowM 	= $objconfig->execute_select($queryM);
	
		$sqlA = "select ".$meses[substr("00".(int)($mes-1),strlen("00".(int)($mes-1))-2)]." as valor from tablero_certificados
		where anio='".$anio."' and idindicador=".$idindicador." and idcertificado=".$idsector;
		$rowA=$objconfig->execute_select($sqlA);
	}
	
	
	
	if($rowM[1]["val"]==$rowA[1]["valor"]){$color="yellow";}
	if($rowM[1]["val"]>$rowA[1]["valor"]){$color="green";}
	if($rowM[1]["val"]<$rowA[1]["valor"]){$color="red";}

	echo number_format($rowM[1]["val"],2)."|".$color."|".number_format($rowAMes[1]["valor"],2);
	*/
?>