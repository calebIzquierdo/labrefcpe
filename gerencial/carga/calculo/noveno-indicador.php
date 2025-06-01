<?php

	/*	Ingreso Tipo de Seguro */

	
	$sql2 = "select idseguro from referencia
			 where date_part('month',fecreferencia)=".$mes." and date_part('year',fecreferencia)='".$anio."' 
			 and idanulado=0 group by idseguro ";
			 
	$rows2 = $objconfig->execute_select($sql2,1);
	
	foreach($rows2[1] as $idseg)
	{
		
			$tipob = "select idpoblacion from tipo_poblacion ";
			
			$tipoba = $objconfig->execute_select($tipob,1);
			
			foreach($tipoba[1] as $idPob)
			{
				
				$tipr = "select idtiporeferencia from tipo_referencia ";
			
				$tipre = $objconfig->execute_select($tipr,1);
				
				foreach($tipre[1] as $tipref)
				{
				
					$sql1= "select count(*) as cantidad from tablero_seguro where idindicador=9 and anio='".$anio."' 
								and idpoblacion=".$idPob["idpoblacion"]." and idseguro=".$idseg["idseguro"]." 
								and idtiporeferencia=".$tipref["idtiporeferencia"];
						
					$rows1 = $objconfig->execute_select($sql1);
					
					$Cons = "select count(*) as valor from referencia where date_part('month',fecreferencia)=".$mes." 
							and date_part('year',fecreferencia)='".$anio."' and idpoblacion=".$idPob["idpoblacion"]."
							and idestado=1 and idanulado=0 and idtiporeferencia=".$tipref["idtiporeferencia"]." 
							and idseguro=".$idseg["idseguro"]." ";
								
					$tMes = $objconfig->execute_select($Cons);
					
					if ($tMes[1]["valor"]!=0 )
					{
					
						if($rows1[1]["cantidad"]==0 )
						{
							$sql55 = "insert into tablero_seguro(idindicador,idestado,idtiporeferencia,
							idseguro,idpoblacion,anio,".$meses[$mes].") 
							values(9,1,".$tipref["idtiporeferencia"].",".$idseg["idseguro"].",".$idPob["idpoblacion"].",
							'".$anio."', ".$tMes[1]["valor"].")";
						//	echo $sql55." op1; ";
						} 
						else{
							$sql55 = "update tablero_seguro set $meses[$mes]=".$tMes[1]["valor"]." 
							where idindicador=9 and anio='".$anio."' and idpoblacion=".$idPob["idpoblacion"]." 
										and idseguro=".$idseg["idseguro"];
						//	echo $sql55." op2; ";
						}
					
						$objconfig->execute_select($sql55);
					}
				}
				
				$sumAnio = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as sumatotal 
							from tablero_seguro where idindicador=9 and anio='".$anio."' and idpoblacion=".$idPob["idpoblacion"]." 
							and idseguro=".$idseg["idseguro"];
		
				$TsumAnio = $objconfig->execute_select($sumAnio);
				$sqlSuma = "update tablero_seguro set sumanio=".$TsumAnio[1]["sumatotal"]." 
				where idindicador=9 and anio='".$anio."' and idpoblacion=".$idPob["idpoblacion"]." 
									and idseguro=".$idseg["idseguro"];
				$objconfig->execute_select($sqlSuma);

			}
	}

	/*
		$sql1  = "select count(*) as cantidad from tablero where idindicador=9 and anio='".$anio."'";
		$rows1 = $objconfig->execute_select($sql1);
	
		$sAnio = "select sum(".$meses[$mes].")::int as sumatotal 
		from tablero_seguro where idindicador=9 and anio='".$anio."' ";
		$TAnio = $objconfig->execute_select($sAnio);
				
		
		if($rows1[1]["cantidad"]==0)
		{
			
			$sql = "insert into tablero(idindicador,anio,".$meses[$mes].") values(6,'".$anio."',".$TAnio[1]["sumatotal"].")";
		} else{
			$sql = "update tablero set ".$meses[$mes]."=".$TAnio[1]["sumatotal"]." where idindicador=9 and anio='".$anio."'";
		}
		$objconfig->execute_select($sql);
	
		$updInd = "update indicadores set ultimo_mes='".strtoupper($meses[$mes])."' where idindicador=9";
		$objconfig->execute_select($updInd);
		
		$updInd = "update indicadores set valor_anterior=valor_actual,valor_actual=".$TAnio[1]["sumatotal"]." where idindicador=9";
		$objconfig->execute_select($updInd);
		*/
		
?>
