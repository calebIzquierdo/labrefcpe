<?php
	
	$sQl  = "select idcondreferencia from condicion_referencia order by idcondreferencia asc ";
	$Rows = $objconfig->execute_select($sQl,1);
	
	foreach($Rows[1] as $rw)
	{
		
	$Sql_1  = "select count(*) as cantidad from tablero where idindicador=1 and anio='".$anio."' and idcondreferencia=".$rw["idcondreferencia"];
	
	$rows1 = $objconfig->execute_select($Sql_1);
	
	$sql2 = "select date_part('year',fecreferencia),date_part('month',fecreferencia) ,count(*) as valor,idcondreferencia
			 from referencia
			 where date_part('month',fecreferencia)='".$mes."' and date_part('year',fecreferencia)='".$anio."' and idestado=1 and idanulado=0 and idcondreferencia=".$rw["idcondreferencia"]."
			 group by date_part('month',fecreferencia),date_part('year',fecreferencia),idcondreferencia"; 
	
	$rows2 = $objconfig->execute_select($sql2);
	
		if($rows1[1]["cantidad"]==0)
		{
			$sql2 = "insert into tablero(idindicador,idcondreferencia, anio,".$meses[$mes].") values(1,".$rw["idcondreferencia"].",'".$anio."',".$rows2[1]["valor"].")";
		}else{
			$sql2 = "update tablero set ".$meses[$mes]."=".$rows2[1]["valor"]." where idindicador=1 and anio='".$anio."' and idcondreferencia=".$rw["idcondreferencia"] ;
			
		}

		$objconfig->execute($sql2);
	
	}
	
	
	
	// Indicadores por tipo de Poblacion
	
	$tiPob  = "select idpoblacion from tipo_poblacion order by idpoblacion asc ";
	$TipPobla = $objconfig->execute_select($tiPob,1);
	
	foreach($TipPobla[1] as $rP)
	{
		
		$sQl  = "select idcondreferencia from condicion_referencia order by idcondreferencia asc ";
		$Rows = $objconfig->execute_select($sQl,1);
	
		foreach($Rows[1] as $rw)
		{
			
		$Sql_1  = "select count(*) as cantidad from tablero where idindicador=1 and anio='".$anio."' 
		and idcondreferencia=".$rw["idcondreferencia"]." and idpoblacion=".$rP["idpoblacion"];
		
		$rows1 = $objconfig->execute_select($Sql_1);
		
		$sql2 = "select date_part('year',fecreferencia),date_part('month',fecreferencia) ,count(*) as valor,idcondreferencia,idpoblacion
				 from referencia
				 where date_part('month',fecreferencia)='".$mes."' and date_part('year',fecreferencia)='".$anio."' and idestado=1 
				 and idanulado=0 and idcondreferencia=".$rw["idcondreferencia"]." and idpoblacion=".$rP["idpoblacion"]."
				 group by date_part('month',fecreferencia),date_part('year',fecreferencia),idcondreferencia,idpoblacion"; 
		
		$rows2 = $objconfig->execute_select($sql2);
		
			if($rows1[1]["cantidad"]==0)
			{
				$sql2 = "insert into tablero(idindicador,idcondreferencia,idpoblacion, anio,".$meses[$mes].") 
				values(1,".$rw["idcondreferencia"].",".$rP["idpoblacion"].",'".$anio."',".$rows2[1]["valor"].")";
			}else{
				$sql2 = "update tablero set ".$meses[$mes]."=".$rows2[1]["valor"]." where idindicador=1 
				and anio='".$anio."' and idcondreferencia=".$rw["idcondreferencia"]." and idpoblacion=".$rP["idpoblacion"] ;
				
			}

			$objconfig->execute($sql2);
		
		}
	}
	
	$sql3 = "select count(*) as valor
			 from referencia
			 where date_part('month',fecreferencia)='".$mes."' and date_part('year',fecreferencia)='".$anio."' and idestado=1 and idanulado=0 "; 
	
	$rows3 = $objconfig->execute_select($sql3);
	
	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=1";
	$objconfig->execute($updInd);
	
	$updInd = "update indicadores set valor_anterior=valor_actual,valor_actual=".$rows3[1]["valor"]." where idindicador=1";
	//echo $upInd2; 
	$objconfig->execute($updInd);
	
?>