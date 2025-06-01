<?php
	$sql1  = "select count(*) as cantidad from tablero where idindicador=5 and anio='".$anio."'";
	$rows1 = $objconfig->execute_select($sql1);
	
	$sql = "select date_part('year',fecreferencia),date_part('month',fecreferencia) ,count(*) as valor
			 from referencia
			 where date_part('month',fecreferencia)='".$mes."' and date_part('year',fecreferencia)='".$anio."' and idestado=1 and idanulado=0 and idcondreferencia=2
			 group by date_part('month',fecreferencia),date_part('year',fecreferencia)"; 
	
	$rows2 = $objconfig->execute_select($sql);
	
	if($rows1[1]["cantidad"]==0)
	{
		$sql = "insert into tablero(idindicador,anio,".$meses[$mes].") values(5,'".$anio."',".$rows2[1]["valor"].")";
	} else{
		$sql = "update tablero set ".$meses[$mes]."=".$rows2[1]["valor"]." where idindicador=5 and anio='".$anio."'";
	}
	$objconfig->execute($sql);
	
	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=5";
	$objconfig->execute($updInd);
	
	$updInd = "update indicadores set valor_anterior=valor_actual,valor_actual=".$rows2[1]["valor"]." where idindicador=5";
	$objconfig->execute($updInd);
	
	
	
?>


