<?php
	$sql1  = "select count(*) as cantidad from tablero where idindicador=1 and anio='".$anio."'";
	//echo $sql1;
	$rows1 = $objconfig->execute_select($sql1);
	
	$sql2 = "select date_part('year',fechaingreso),date_part('month',fechaingreso) ,count(*) as valor
			 from productores
			 where date_part('month',fechaingreso)=".$mes." and date_part('year',fechaingreso)=".$anio." group by date_part('month',fechaingreso),date_part('year',fechaingreso)";

	$rows2 = $objconfig->execute_select($sql2);
	
	if($rows1[1]["cantidad"]==0)
	{
		$sql3 = "insert into tablero(idindicador,anio,".$meses[$mes].") values(1,'".$anio."',".$rows2[1]["valor"].")";
	}else{
		$sql3 = "update tablero set ".$meses[$mes]."=".$rows2[1]["valor"]." where idindicador=1 and anio='".$anio."'";
	}
	$objconfig->execute($sql3);
	
	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=1";
	$objconfig->execute($updInd);
	
	$updInd2 = "update indicadores set valor_anterior=valor_actual,valor_actual=".$rows2[1]["valor"]." where idindicador=1";
	// echo $upInd2; 
	$objconfig->execute($updInd2);
	
?>