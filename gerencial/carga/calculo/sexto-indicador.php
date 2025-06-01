<?php

	/*	Ingreso Motivo Cancelacionde referencia		*/
	
	$sql2 = "select idreferencia,date_part('month',fecreferencia),date_part('year',fecreferencia)
			 from referencia
			 where date_part('month',fecreferencia)='".$mes."' and date_part('year',fecreferencia)='".$anio."' 
			 and idestado=1 and idanulado=0 and idcondreferencia=2
			 group by date_part('month',fecreferencia),date_part('year',fecreferencia),idreferencia";
			 
	$rows2 = $objconfig->execute_select($sql2,1);
	
	foreach($rows2[1] as $tr)
	{
		$RAcep = "select idsuspendido from tipo_suspendido order by idsuspendido asc";
		$RefNoAcepta = $objconfig->execute_select($RAcep,1);
	
		$ntot=0;
		
		foreach($RefNoAcepta[1] as $nAcp)
		{
			$cant_mes= "select count(*) as cantidad from tablero_rechazado where idindicador=6 and anio='".$anio."' 
						and idnoacepta=".$nAcp["idsuspendido"];
			$cMes = $objconfig->execute_select($cant_mes);
			
			$Cons = "Select count(idnoacepta) as valor from referencia_noacepta where idreferencia=".$tr["idreferencia"]." 
					and idnoacepta=".$nAcp["idsuspendido"];
		
			$tMes = $objconfig->execute_select($Cons);
	
			if($cMes[1]["cantidad"] ==0 )
			{
					if ($tMes[1]["valor"]!=0 ){
					$sql55 = "insert into tablero_rechazado(idindicador,idnoacepta,anio,".$meses[$mes].") 
					values(6,".$nAcp["idsuspendido"].",'".$anio."', ".$tMes[1]["valor"].")";
					//echo $sql55;
					$objconfig->execute_select($sql55);
				}
					
			}else{
				$newValor = "select COALESCE(sum($meses[$mes]),0) as cantidad from tablero_rechazado 
							where idindicador=6 and anio='".$anio."' 
						and idnoacepta=".$nAcp["idsuspendido"];
				$nVal = $objconfig->execute_select($newValor);
						
				$ntot = $tMes[1]["valor"]+$nVal[1]["cantidad"];
			//	echo $ntot." ; ";
				$sql5 = "update tablero_rechazado set $meses[$mes]=".$ntot." 
				where idindicador=6 and anio='".$anio."' and idnoacepta=".$nAcp["idsuspendido"];
				$objconfig->execute_select($sql5);
			}
			
			$sumAnio = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as sumatotal 
			from tablero_rechazado where idindicador=6 and anio='".$anio."' and idnoacepta=".$nAcp["idsuspendido"]."
			";
			$TsumAnio = $objconfig->execute_select($sumAnio);
			$sqlSuma = "update tablero_rechazado set sumanio=".$TsumAnio[1]["sumatotal"]." where idindicador=6 and anio='".$anio."' 
			and idnoacepta=".$nAcp["idsuspendido"]." ";
			$objconfig->execute_select($sqlSuma);

		}
	}
	
		$sql1  = "select count(*) as cantidad from tablero where idindicador=6 and anio='".$anio."'";
		$rows1 = $objconfig->execute_select($sql1);
	
		$sAnio = "select sum(".$meses[$mes].")::int as sumatotal 
		from tablero_rechazado where idindicador=6 and anio='".$anio."' ";
		$TAnio = $objconfig->execute_select($sAnio);
				
		if($rows1[1]["cantidad"]==0)
		{
			
			$sql = "insert into tablero(idindicador,anio,".$meses[$mes].") values(6,'".$anio."',".$TAnio[1]["sumatotal"].")";
		} else{
			$sql = "update tablero set ".$meses[$mes]."=".$TAnio[1]["sumatotal"]." where idindicador=6 and anio='".$anio."'";
		}
		$objconfig->execute_select($sql);
	
	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=6";
	$objconfig->execute_select($updInd);
	
	$updInd = "update indicadores set valor_anterior=valor_actual,valor_actual=".$TAnio[1]["sumatotal"]." where idindicador=6";
	$objconfig->execute_select($updInd);

	
?>


