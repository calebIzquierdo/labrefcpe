<?php
	
// Pacientes Recibidos	
	$sql = "select date_part('year',fecreferencia),date_part('month',fecreferencia) ,count(*) as valor,idespecialidad,idtiporeferencia
			from referencia
			where date_part('year',fecreferencia)='".$anio."' and date_part('month',fecreferencia)=".$mes." and idestado=1 and idanulado=0 
			group by date_part('year',fecreferencia),date_part('month',fecreferencia),idespecialidad,idtiporeferencia";
			 
	$rows1 = $objconfig->execute_select($sql,1);
	
	foreach($rows1[1] as $r)
	{
		$sql2  = "select count(*) as cantidad from tablero_ups where idindicador=7 and anio='".$anio."' and idespecialidad=".$r["idespecialidad"]. " 
				 and  idtiporeferencia=".$r["idtiporeferencia"]." and idestado=1";
		$rows2 = $objconfig->execute_select($sql2);
		
		if($rows2[1]["cantidad"]==0)
		{
			$sql3 = "insert into tablero_ups(idindicador,idestado,idtiporeferencia,idespecialidad,anio,".$meses[$mes].") 
			values(7,1,".$r["idtiporeferencia"].",".$r["idespecialidad"].",'".$anio."',".$r["valor"].")";
			$sql1 = "insert into tablero(idindicador,anio,".$meses[$mes].") values(3,'".$anio."',".$rows2[1]["valor"].")";
		}else{
			$sql3 = "update tablero_ups set ".$meses[$mes]."=".$r["valor"]." where idindicador=7 and anio='".$anio."' 
			and idespecialidad=".$r["idespecialidad"]." and idtiporeferencia=".$r["idtiporeferencia"]." and idestado=1";
		}

		$objconfig->execute_select($sql1);
		$objconfig->execute_select($sql3);
		
		$sumAnio = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as sumatotal 
					from tablero_ups where idindicador=7 and anio='".$anio."' and idespecialidad=".$r["idespecialidad"]. " 
					and idtiporeferencia=".$r["idtiporeferencia"]." and idestado=1";
		$TsumAnio = $objconfig->execute_select($sumAnio);
		
		$sqlSuma = "update tablero_ups set sumanio=".$TsumAnio[1]["sumatotal"]." where idindicador=7 and anio='".$anio."' and idespecialidad=".$r["idespecialidad"]. " 
			 and  idtiporeferencia=".$r["idtiporeferencia"]." and idestado=1";
		$objconfig->execute_select($sqlSuma);
			
	}
	
// Pacientes Enviados 
	
	$sql = "select date_part('year',fecreferencia),date_part('month',fecreferencia) ,count(*) as valor,idespecialidad,idtiporeferencia
			from referencia
			where date_part('year',fecreferencia)='".$anio."' and date_part('month',fecreferencia)=".$mes." and idestado=2 and idanulado=0 
			group by date_part('year',fecreferencia),date_part('month',fecreferencia),idespecialidad,idtiporeferencia";
			 
	$rows1 = $objconfig->execute_select($sql,1);
	
	foreach($rows1[1] as $r)
	{
		$sql2  = "select count(*) as cantidad from tablero_ups where idindicador=7 and anio='".$anio."' and idespecialidad=".$r["idespecialidad"]. " 
				 and  idtiporeferencia=".$r["idtiporeferencia"]." and idestado=2";
		$rows2 = $objconfig->execute_select($sql2);
		
		if($rows2[1]["cantidad"]==0)
		{
			$sql3 = "insert into tablero_ups(idindicador,idestado,idtiporeferencia,idespecialidad,anio,".$meses[$mes].") 
			values(7,2,".$r["idtiporeferencia"].",".$r["idespecialidad"].",'".$anio."',".$r["valor"].")";
		//	echo $sql3."</br>";
		}else{
			$sql3 = "update tablero_ups set ".$meses[$mes]."=".$r["valor"]." where idindicador=7 and anio='".$anio."' 
			and idespecialidad=".$r["idespecialidad"]." and idtiporeferencia=".$r["idtiporeferencia"]." and idestado=2";
		}
		
	//	echo $sql3."<br>";
		$objconfig->execute_select($sql3);
		
		$sumAnio = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as sumatotal 
			from tablero_ups where idindicador=7 and anio='".$anio."' and idespecialidad=".$r["idespecialidad"]. " 
				 and  idtiporeferencia=".$r["idtiporeferencia"]." and idestado=2";
		$TsumAnio = $objconfig->execute_select($sumAnio);
		
			$sqlSuma = "update tablero_ups set sumanio=".$TsumAnio[1]["sumatotal"]." where idindicador=7 and anio='".$anio."' and idespecialidad=".$r["idespecialidad"]. " 
				 and  idtiporeferencia=".$r["idtiporeferencia"]." and idestado=2";
			$objconfig->execute_select($sqlSuma);
			
	}

	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=7";
	$objconfig->execute_select($updInd);
	
	
	$sumAnio = "select sum(sumanio)::int as sumatotal 
					from tablero_ups where idindicador=7 and anio='".$anio."' ";
	$TsumAnio = $objconfig->execute_select($sumAnio);
	
	$updInd2 = "update indicadores set valor_anterior=valor_actual,valor_actual=".$TsumAnio[1]["sumatotal"]." where idindicador=7";
	$objconfig->execute_select($updInd2);
	
?>