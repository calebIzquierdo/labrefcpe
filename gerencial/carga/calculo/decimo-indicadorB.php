<?php
	$sql1 = "select date_part('year',c.fechareg),date_part('month',c.fechareg),empresa
			from detmovimiento_detalle as dd
			inner join detmovimiento as d on(dd.itemdetmovimiento=d.item_detmovimiento)
			inner join cabmovimiento as c on(d.nromovimiento=c.nromovimiento and d.idtipomovimiento=c.idtipomovimiento)
			where c.idtipomovimiento=1 and date_part('year',c.fechareg)=".$anio." and date_part('month',c.fechareg)=".$mes."
			group by date_part('year',c.fechareg),date_part('month',c.fechareg),empresa";
	
	$rows1 = $objconfig->execute_select($sql1);
	
	$tipo = explode("|",$rows1[1]["empresa"]);
	for($i=0;$i<count($tipo);$i++)
	{
		if($tipo[$i]!=0)
		{
			$sql2 = "select date_part('year',c.fechareg),date_part('month',c.fechareg),count(*) as valor
					from detmovimiento_detalle as dd
					inner join detmovimiento as d on(dd.itemdetmovimiento=d.item_detmovimiento)
					inner join cabmovimiento as c on(d.nromovimiento=c.nromovimiento and d.idtipomovimiento=c.idtipomovimiento)
					where c.idtipomovimiento=1 and date_part('year',c.fechareg)=".$anio." and date_part('month',c.fechareg)=".$mes." and empresa like '%".$tipo[$i]."%'
					group by date_part('year',c.fechareg),date_part('month',c.fechareg)";
			//echo $sql2."<br>";
			$rows2 = $objconfig->execute_select($sql2);
			
			$sql3  = "select count(*) as cantidad from tablero_empr_cert where idindicador=10 and anio='".$anio."' and idempresa=".$tipo[$i];
			$rows3 = $objconfig->execute_select($sql3);
			
			if($rows3[1]["cantidad"]==0)
			{
				$sql4 = "insert into tablero_empr_cert(idindicador,idempresa,anio,".$meses[$mes].") values(10,".$tipo[$i].",'".$anio."',".$rows2[1]["valor"].")";
			}else{
				$sql4 = "update tablero_empr_cert set ".$meses[$mes]."=".$rows2[1]["valor"]." where idindicador=10 and anio='".$anio."' and idempresa=".$tipo[$i];
			}
			//echo $sql4."<br>";
			$objconfig->execute($sql4);
		}
		
	}
	
	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=10";
	$objconfig->execute($updInd);
	/*
	$updInd2 = "update indicadores set valor_anterior=valor_actual,valor_actual=".$rows2[1]["valor"]." where idindicador=1";
	$objconfig->execute($updInd2);
	*/
	
?>