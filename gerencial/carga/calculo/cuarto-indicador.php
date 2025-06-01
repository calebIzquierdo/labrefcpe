<?php

	$sql1  = "select count(*) as cantidad from tablero where idindicador=4 and anio='".$anio."'  ";
	$rows1 = $objconfig->execute_select($sql1);
	
	
	$sum ="select date_part('year',fviaje),date_part('month',fviaje) ,count(*) as valor
			 from referencia
			 where date_part('month',fviaje)='".$mes."' and date_part('year',fviaje)='".$anio."' 
			 and idestado=2 and idanulado=0 
			 group by date_part('month',fviaje),date_part('year',fviaje)
			 ";
	$suma = $objconfig->execute_select($sum);
	
	if($rows1[1]["cantidad"]==0)
	{
		$sql3 = "insert into tablero(idindicador,anio,".$meses[$mes].") values(4,'".$anio."',".$suma[1]["valor"].")";
	}else{
		$sql3 = "update tablero set ".$meses[$mes]."=".$suma[1]["valor"]." where idindicador=4 and anio='".$anio."'";
	}
	$objconfig->execute($sql3);
	
			
	$sql2 = "select date_part('year',fviaje),date_part('month',fviaje),codemp ,count(*) as valor from referencia
			 where date_part('year',fviaje)='".$anio."' and date_part('month',fviaje)=".$mes." 
			 and idestado=2 and idanulado=0 group by date_part('month',fviaje),date_part('year',fviaje),codemp"; 
	
	$rows2 = $objconfig->execute_select($sql2,1);
	
	foreach($rows2[1] as $r)
	{
		$sql2  = "select count(*) as cantidad from tablero_destino where idindicador=4 and anio='".$anio."' and codemp=".$r["codemp"];
		$rows2 = $objconfig->execute_select($sql2);
		
		if($rows2[1]["cantidad"]==0)
		{
			$sql4 = "insert into tablero_destino(idindicador,codemp,anio,".$meses[$mes].") values(4,".$r["codemp"].",'".$anio."',".$r["valor"].")";
		}else{
			$sql4 = "update tablero_destino set ".$meses[$mes]."=".$r["valor"]." where idindicador=4 and anio='".$anio."' and codemp=".$r["codemp"];
		}
		//echo $sql3."<br>";
		$objconfig->execute_select($sql4);
	}
	
	
	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=4";
	$objconfig->execute($updInd);
	
	$updInd = "update indicadores set valor_anterior=valor_actual,valor_actual=".$suma[1]["valor"]." where idindicador=4";
	$objconfig->execute($updInd);
	
	
	/*
	Ingreso segun el tipo de referencia
	*/
	
	$tRef = "select idtiporeferencia from tipo_referencia";
	$tipRef = $objconfig->execute_select($tRef,1);
	
	foreach($tipRef[1] as $tr)
	{
		$sql_1 = "select date_part('year',fviaje),date_part('month',fviaje),codemp ,count(*) as valor
				  from referencia
				 where date_part('year',fviaje)='".$anio."' and date_part('month',fviaje)=".$mes." 
				 and idestado=2 and idanulado=0 and idtiporeferencia=".$tr["idtiporeferencia"]."
				 group by date_part('month',fviaje),date_part('year',fviaje),codemp"; 
		
		$rows_2 = $objconfig->execute_select($sql_1,1);
		
		foreach($rows_2[1] as $rA2)
		{
			$sql22  = "select count(*) as cantidad from tablero_destino where idindicador=4 and anio='".$anio."' 
					  and codemp=".$rA2["codemp"]." and idtiporeferencia=".$tr["idtiporeferencia"];
			$rows22 = $objconfig->execute_select($sql22); 
			
			if($rows22[1]["cantidad"]==0)
			{
				$sql44 = "insert into tablero_destino(idindicador,codemp,anio,".$meses[$mes].",idtiporeferencia) 
				values(4,".$rA2["codemp"].",'".$anio."', ".$rA2["valor"].", ".$tr["idtiporeferencia"].")";
			}else{
				$sql44 = "update tablero_destino set ".$meses[$mes]."=".$rA2["valor"]." where idindicador=4 and anio='".$anio."' 
				and codemp=".$r["codemp"]." and idtiporeferencia=".$tr["idtiporeferencia"];
			}
			//echo $sql3."<br>";
			$objconfig->execute_select($sql44);
		}
	}
	

	
?>


