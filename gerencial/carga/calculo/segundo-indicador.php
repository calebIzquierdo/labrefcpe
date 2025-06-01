<?php

	$sql1  = "select count(*) as cantidad from tablero where idindicador=2 and anio='".$anio."'  ";
	$rows1 = $objconfig->execute_select($sql1);
	
	$sum ="select date_part('year',fecreferencia),date_part('month',fecreferencia) ,count(*) as valor
			 from referencia
			 where date_part('month',fecreferencia)='".$mes."' and date_part('year',fecreferencia)='".$anio."' and idestado=1 and idanulado=0 
			 group by date_part('month',fecreferencia),date_part('year',fecreferencia)
			 ";
	$suma = $objconfig->execute_select($sum);
	
	if($rows1[1]["cantidad"]==0)
	{
		$sql3 = "insert into tablero(idindicador,anio,".$meses[$mes].") values(2,'".$anio."',".$suma[1]["valor"].")";
	}else{
		$sql3 = "update tablero set ".$meses[$mes]."=".$suma[1]["valor"]." where idindicador=2 and anio='".$anio."'";
	}
	$objconfig->execute($sql3);
	
		
	$sql2 = "select date_part('year',fecreferencia),date_part('month',fecreferencia),idorigen_establecimiento,
			count(*) as valor from referencia
			 where date_part('year',fecreferencia)='".$anio."' and date_part('month',fecreferencia)=".$mes." 
			 and idestado=1 and idanulado=0 group by date_part('month',fecreferencia),date_part('year',fecreferencia),idorigen_establecimiento"; 
	
	
	$rows2 = $objconfig->execute_select($sql2,1);
	foreach($rows2[1] as $r)
	{
		$sql2  = "select count(*) as cantidad from tablero_origen where idindicador=2 and anio='".$anio."' and idorigen_establecimiento=".$r["idorigen_establecimiento"];
		$rows2 = $objconfig->execute_select($sql2);
		
		if($rows2[1]["cantidad"]==0)
		{
			$sql2 = "insert into tablero_origen(idindicador,idorigen_establecimiento,anio,".$meses[$mes].") values(2,".$r["idorigen_establecimiento"].",'".$anio."',".$r["valor"].")";
			$sql_2 = "insert into tablero(idindicador,anio,".$meses[$mes].") values(2,'".$anio."',".$rows2[1]["valor"].")";
		
		}else{
			$sql2 = "update tablero_origen set ".$meses[$mes]."=".$r["valor"]." where idindicador=2 and anio='".$anio."' and idorigen_establecimiento=".$r["idorigen_establecimiento"];
			$sql_2 = "update tablero set ".$meses[$mes]."=".$rows2[1]["valor"]." where idindicador=2 and anio='".$anio."'";
		}
		//echo $sql3."<br>";
		$objconfig->execute($sql2);
		$objconfig->execute($sql_2);
		
		$sumAnio = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as sumatotal 
			from tablero_origen where idindicador=2 and anio='".$anio."' and idorigen_establecimiento=".$r["idorigen_establecimiento"]."
			and idtiporeferencia=0";
		$TsumAnio = $objconfig->execute_select($sumAnio);
			$sqlSuma = "update tablero_origen set sumanio=".$TsumAnio[1]["sumatotal"]." where idindicador=2 and anio='".$anio."' 
			and idorigen_establecimiento=".$r["idorigen_establecimiento"]." and idtiporeferencia=0";
			$objconfig->execute_select($sqlSuma);
	}
	
	$sqlVal = " select date_part('month',fecreferencia) ,count(*) as valor from referencia
				where date_part('month',fecreferencia)=".$mes." and date_part('year',fecreferencia)='".$anio."' and idestado=1 
				and idanulado=0 
				group by date_part('month',fecreferencia),date_part('year',fecreferencia)";
				
	$rowsVal = $objconfig->execute_select($sqlVal);	 
			 
	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=2";
	$objconfig->execute($updInd);
	
	$updInd2 = "update indicadores set valor_anterior=valor_actual,valor_actual=".$rowsVal[1]["valor"]." where idindicador=2";
	$objconfig->execute($updInd2);
	
	/*
	Ingreso segun el tipo de referencia
	*/
	
	$tRef = "select idtiporeferencia from tipo_referencia";
	$tipRef = $objconfig->execute_select($tRef,1);
	
	foreach($tipRef[1] as $tr)
	{
		$sql_1 = "select date_part('year',fecreferencia),date_part('month',fecreferencia),idorigen_establecimiento ,count(*) as valor
				  from referencia
				 where date_part('year',fecreferencia)='".$anio."' and date_part('month',fecreferencia)=".$mes." 
				 and idestado=1 and idanulado=0 and idtiporeferencia=".$tr["idtiporeferencia"]."
				 group by date_part('month',fecreferencia),date_part('year',fecreferencia),idorigen_establecimiento"; 
		
		$rows_2 = $objconfig->execute_select($sql_1,1);
		
		foreach($rows_2[1] as $rA2)
		{
			$sql22  = "select count(*) as cantidad from tablero_origen where idindicador=2 and anio='".$anio."' 
					  and idorigen_establecimiento=".$rA2["idorigen_establecimiento"]." and idtiporeferencia=".$tr["idtiporeferencia"];
			$rows22 = $objconfig->execute_select($sql22); 
			
			if($rows22[1]["cantidad"]==0)
			{
				$sql44 = "insert into tablero_origen(idindicador,idorigen_establecimiento,anio,".$meses[$mes].",idtiporeferencia) 
				values(2,".$rA2["idorigen_establecimiento"].",'".$anio."', ".$rA2["valor"].", ".$tr["idtiporeferencia"].")";
			}else{
				$sql44 = "update tablero_origen set ".$meses[$mes]."=".$rA2["valor"]." where idindicador=2 and anio='".$anio."' 
				and idorigen_establecimiento=".$r["idorigen_establecimiento"]." and idtiporeferencia=".$tr["idtiporeferencia"];
			}
			//echo $sql3."<br>";
			$objconfig->execute_select($sql44);
			
			$sumAnio2 = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as sumatotal 
			from tablero_origen where idindicador=2 and anio='".$anio."' and idorigen_establecimiento=".$rA2["idorigen_establecimiento"]."
			and  idtiporeferencia=".$tr["idtiporeferencia"];
			$TsumAnio2 = $objconfig->execute_select($sumAnio2);
			$sqlSuma2 = "update tablero_origen set sumanio=".$TsumAnio2[1]["sumatotal"]." where idindicador=2 and anio='".$anio."' 
			and idorigen_establecimiento=".$rA2["idorigen_establecimiento"]." and  idtiporeferencia=".$tr["idtiporeferencia"];
			$objconfig->execute_select($sqlSuma2);
		}
	}
	
	
	
?>