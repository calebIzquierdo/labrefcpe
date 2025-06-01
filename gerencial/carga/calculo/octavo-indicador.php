<?php

	/*	Ingreso Tipo de diagnostico */
	
	$tipD = "select idtiporeferencia from tipo_referencia ";
			
	$tDi = $objconfig->execute_select($tipD,1);
	
	foreach($tDi[1] as $tpDiag)
	{
		
	
		$sql2 = "select idespecialidad from referencia
				 where date_part('month',fecreferencia)=".$mes." and date_part('year',fecreferencia)='".$anio."' 
				 and idestado=1 and idanulado=0 and  idtiporeferencia=".$tpDiag["idtiporeferencia"]."
				 group by idespecialidad ";
				 
		$rows2 = $objconfig->execute_select($sql2,1);
	
	foreach($rows2[1] as $tr)
	{
		
			$diag = "select iddiagnostico from referencia_diagnostico group by iddiagnostico ";
			
			$diagnos = $objconfig->execute_select($diag,1);
			
			foreach($diagnos[1] as $idDiag)
			{
				$sql1= "select count(iddiagnostico) as cantidad from tablero_diagnostico where idindicador=8 and anio='".$anio."' 
							and iddiagnostico=".$idDiag["iddiagnostico"]." and idtiporeferencia=".$tpDiag["idtiporeferencia"]." and idespecialidad=".$tr["idespecialidad"];
				$rows1 = $objconfig->execute_select($sql1);
				
				$Cons = "select count(iddiagnostico) as valor from referencia_diagnostico where iddiagnostico=".$idDiag["iddiagnostico"]." 
						and idreferencia in (select idreferencia from referencia
						where date_part('month',fecreferencia)=".$mes." and date_part('year',fecreferencia)='".$anio."' 
						and idestado=1 and idanulado=0 and idtiporeferencia=".$tpDiag["idtiporeferencia"]." and idespecialidad=".$tr["idespecialidad"]."
						) and idtipodiagnostico=2 and idprioridad=1
						";

				$tMes = $objconfig->execute_select($Cons);
				
				if ($tMes[1]["valor"]!=0 ){
				
					if($rows1[1]["cantidad"]==0 )
					{
						$sql55 = "insert into tablero_diagnostico(idindicador,idestado,idtiporeferencia,
						idespecialidad,iddiagnostico,anio,".$meses[$mes].") 
						values(8,1,".$tpDiag["idtiporeferencia"].",".$tr["idespecialidad"].",".$idDiag["iddiagnostico"].",'".$anio."', ".$tMes[1]["valor"].")";
					} 
					else{
						$sql55 = "update tablero_diagnostico set $meses[$mes]=".$tMes[1]["valor"]." 
						where idindicador=8 and anio='".$anio."' and iddiagnostico=".$idDiag["iddiagnostico"]." 
									and  idtiporeferencia=".$tpDiag["idtiporeferencia"]." and idespecialidad=".$tr["idespecialidad"];
					}
					
					$objconfig->execute($sql55);
				}
				
				$sumAnio = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as sumatotal 
							from tablero_diagnostico where idindicador=8 and anio='".$anio."' and iddiagnostico=".$idDiag["iddiagnostico"]." 
							and idtiporeferencia=".$tpDiag["idtiporeferencia"]." and idespecialidad=".$tr["idespecialidad"];
		
				$TsumAnio = $objconfig->execute_select($sumAnio);
				$sqlSuma = "update tablero_diagnostico set sumanio=".$TsumAnio[1]["sumatotal"]." 
				where idindicador=8 and anio='".$anio."' and iddiagnostico=".$idDiag["iddiagnostico"]." 
									and idtiporeferencia=".$tpDiag["idtiporeferencia"]." and idespecialidad=".$tr["idespecialidad"];
				$objconfig->execute_select($sqlSuma);

			}
		}
	}
	
		$sql1  = "select count(*) as cantidad from tablero where idindicador=8 and anio='".$anio."'";
		$rows1 = $objconfig->execute_select($sql1);
	
		$sAnio = "select sum(".$meses[$mes].")::int as sumatotal 
		from tablero_diagnostico where idindicador=8 and anio='".$anio."' ";
		$TAnio = $objconfig->execute_select($sAnio);
				
		if($rows1[1]["cantidad"]==0)
		{
			
			$sql = "insert into tablero(idindicador,anio,".$meses[$mes].") values(6,'".$anio."',".$TAnio[1]["sumatotal"].")";
		} else{
			$sql = "update tablero set ".$meses[$mes]."=".$TAnio[1]["sumatotal"]." where idindicador=8 and anio='".$anio."'";
		}
		$objconfig->execute_select($sql);
	
	$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=8";
	$objconfig->execute_select($updInd);
	
	$updInd = "update indicadores set valor_anterior=valor_actual,valor_actual=".$TAnio[1]["sumatotal"]." where idindicador=8";
	$objconfig->execute_select($updInd);

	

	
?>


-