<?php

	$queryI = "select * from indicadores where idindicador=".$idindicador;
		$row = $objconfig->execute_select($queryI);

	
	if($row[1]["valor_actual"]==$row[1]["valor_anterior"]){$color="yellow";}
	if($row[1]["valor_actual"]>$row[1]["valor_anterior"]){$color="green";}
	if($row[1]["valor_actual"]<$row[1]["valor_anterior"]){$color="red";}
	
	$meses = array("1"=>"Enero",
				 "2"=>"Febrero",
				 "3"=>"Marzo",
				 "4"=>"Abril",
				 "5"=>"Mayo",
				 "6"=>"Junio",
				 "7"=>"Julio",
				 "8"=>"Agosto",
				 "9"=>"Setiembre",
				 "10"=>"Octubre",
				 "11"=>"Noviembre",
				 "12"=>"Diciembre");
	 
?>

<div class="datos_indicador">
	<div class="row">
		<div class="col-md-12">
		<div class="col-md-2">
			<label class="control-label">Indicador </label>
		</div>
		<div class="col-md-3">
			<textarea rows="1" cols="26" readonly="readonly"><?=strtoupper($row[1]["descripcion"])?></textarea>
		</div>
		<div class="col-md-1">	</div>
		<?php 
		
		if ($idindicador==1){
		?>
		<div class="col-md-2">
			<label class="control-label"> Tipo Poblacion</label>
		</div>
		<div class="col-md-3">
			<select name="idesta" id="idesta" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos</option>
				<?php
				$idEstab = "select idpoblacion, descripcion from tipo_poblacion order by descripcion asc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rowA)
					{
						echo "<option value='".$rowA["idpoblacion"]."'>".$rowA["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
		}
						
			else if ($idindicador==2 ){
						
			?>
			<div class="col-md-1">
			<label class="control-label">EE.SS. ORIGEN </label>
		</div>
		<div class="col-md-5">
			<select name="idesta" id="idesta" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos</option>
				<?php
				$idEstab = "select idorigen_establecimiento from referencia where idestado=1 and idanulado=0 group by idorigen_establecimiento order by idorigen_establecimiento asc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rA)
					{
						$sqlA = "select idestablecimiento, descripcion, codrenaes  from establecimiento where idestablecimiento=".$rA["idorigen_establecimiento"];
						$rowA = $objconfig->execute_select($sqlA);
						echo "<option value='".$rowA[1]["idestablecimiento"]."'>".$rowA[1]["codrenaes"]." - ".$rowA[1]["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		
		<?php 
			}
			if ($idindicador==4  ){
			?>
			<div class="col-md-2">
			<label class="control-label">Tipo Referencia</label>
		</div>
		<div class="col-md-3">
			<select name="idtiporeferencia" id="idtiporeferencia" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos</option>
				<?php
				$idEstab = "select idorigen_establecimiento from referencia where idestado=1 and idanulado=0 group by idorigen_establecimiento order by idorigen_establecimiento asc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);
				
				$idEstab = "select idtiporeferencia, descripcion from tipo_referencia order by descripcion asc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rowA)
					{
						echo "<option value='".$rowA["idtiporeferencia"]."'>".$rowA["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
			}
			if ($idindicador==7  ){
			?>
			<div class="col-md-2">
			<label class="control-label">Condición Referencia</label>
		</div>
		<div class="col-md-3">
			<select name="idesta" id="idesta" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="1">ORIGEN</option>
			<option value="2">DESTINO</option>
			</select>	
		</div>
		<?php 
			}
			if ($idindicador==8){
			?>
			<div class="col-md-1">
			<label class="control-label">UPS</label>
		</div>
		<div class="col-md-4">
			<select name="idesta" id="idesta" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<?php
				$idEstab = "select idespecialidad from tablero_diagnostico group by idespecialidad"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rA)
					{
						$sqlA = "select idups, descripcion   from ups where idups=".$rA["idespecialidad"];
						$rowA = $objconfig->execute_select($sqlA);
						echo "<option value='".$rowA[1]["idups"]."'>".$rowA[1]["codrenaes"]." - ".$rowA[1]["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
			}
			if ($idindicador==9){
			?>
			<div class="col-md-2">
			<label class="control-label">Tipo Referencia</label>
		</div>
		<div class="col-md-3">
			<select name="idesta" id="idesta" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<?php
				$idEstab = "select idtiporeferencia from tablero_seguro group by idtiporeferencia order by idtiporeferencia asc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rA)
					{
						$sqlA = "select idtiporeferencia, descripcion   from tipo_referencia where idtiporeferencia=".$rA["idtiporeferencia"];
						$rowA = $objconfig->execute_select($sqlA);
						echo "<option value='".$rowA[1]["idtiporeferencia"]."'>".$rowA[1]["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
			}
			if ($idindicador==10){
			?>
			<div class="col-md-1">
			<label class="control-label">UPS</label>
		</div>
		<div class="col-md-4">
			<select name="idesta" id="idesta" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos</option>
			<?php
				$idEstab = "select idespecialidad from tablero_diagnostico_envio group by idespecialidad"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rA)
					{
						$sqlA = "select idups, descripcion   from ups where idups=".$rA["idespecialidad"];
						$rowA = $objconfig->execute_select($sqlA);
						echo "<option value='".$rowA[1]["idups"]."'>".$rowA[1]["codrenaes"]." - ".$rowA[1]["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
			}
			else {
		?>
		<!--
		<div class="col-md-2">
		<label class="control-label">Comentario</label>
		</div>
		<div class="col-md-3">
			<textarea rows="1" cols="26" readonly="readonly"><?=strtoupper(utf8_encode($row[1]["comentario_indicador"]))?></textarea>
		</div>   -->
			<?php 
			}
				?>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-md-12">
		<div class="col-md-2">
			<label class="control-label">Formula</label>
		</div>
		<div class="col-md-3">
			<textarea rows="1" cols="26" readonly="readonly"><?=strtoupper(utf8_encode($row[1]["formula_texto"]))?></textarea>
		</div>
		<div class="col-md-1">	</div>
		<?php 
		if ($idindicador==1){
		?>
		<div class="col-md-2">
			<label class="control-label"> Condición Referencia</label>
		</div>
		<div class="col-md-3">
			<select name="idtiporeferencia" id="idtiporeferencia" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos</option>
				<?php
				$idEstab = "select idcondreferencia, descripcion from condicion_referencia order by descripcion asc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rowA)
					{
						echo "<option value='".$rowA["idcondreferencia"]."'>".$rowA["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
			}
		if ($idindicador==2 ){			
		?>

		<div class="col-md-1">
			<label class="control-label">Tipo Referencia</label>
		</div>
		<div class="col-md-3">
			<select name="idtiporeferencia" id="idtiporeferencia" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos</option>
				<?php
				$idEstab = "select idtiporeferencia, descripcion from tipo_referencia order by descripcion asc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rowA)
					{
						echo "<option value='".$rowA["idtiporeferencia"]."'>".$rowA["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
			<div class="col-md-2">
			<select name="limit" id="limit" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos E.S.</option>
			<option value="5">5</option>
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="50">50</option>
			<option value="100">100</option>
			</select>	
		</div>
		
		
		<?php 
			}
			if ( $idindicador==7 ){
			
		?>
		
		<div class="col-md-2">
			<label class="control-label">Tipo Referencia</label>
		</div>
		<div class="col-md-3">
			<select name="idtiporeferencia" id="idtiporeferencia" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
				<?php
				$idEstab = "select idtiporeferencia, descripcion from tipo_referencia order by descripcion desc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rowA)
					{
						echo "<option value='".$rowA["idtiporeferencia"]."'>".$rowA["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
			
		<?php 
			}
			
		if ($idindicador==4)
		{	
		?>
		<div class="col-md-1">
			<label class="control-label">EE.SS. DESTINO </label>
		</div>
		<div class="col-md-5">
			<select name="idestable" id="idestable" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos</option>
				<?php
				$idEstab2 = "select codemp from referencia where idestado=2 and idanulado=0 group by codemp order by codemp asc"; 
				$rowEst2 = $objconfig->execute_select($idEstab2,1);	
					
					foreach($rowEst2[1] as $rA2)
					{
						$sqlA2 = "select idhospital, descripcion, codrenaes  from hospitales where idhospital=".$rA2["codemp"];
						$rowA2 = $objconfig->execute_select($sqlA2);
						echo "<option value='".$rowA2[1]["idhospital"]."'>".$rowA2[1]["codrenaes"]." - ".$rowA2[1]["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
			}
			
		if ($idindicador==6)
		{	
	
		?>
		<div class="col-md-1">
			<label class="control-label">MOTIVO </label>
		</div>
		<div class="col-md-5">
			<select name="idestable" id="idestable" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<option value="0">Todos</option>
				<?php
				$sA2 = "select idnoacepta, idindicador from tablero_rechazado where idindicador=".$idindicador;
						$rwoA2 = $objconfig->execute_select($sA2,1);
									
					foreach($rwoA2[1] as $rA2)
					{
						$idEstab2 = "select idsuspendido, descripcion from tipo_suspendido where idsuspendido=".$rA2["idnoacepta"]; 
						$rowEst2 = $objconfig->execute_select($idEstab2);	
						echo "<option value='".$rowEst2[1]["idsuspendido"]."'>".$rowEst2[1]["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
			}
			if ($idindicador==9){
		?>
		<div class="col-md-2">
			<label class="control-label"> Tipo Poblacion</label>
		</div>
		<div class="col-md-3">
			<select name="idtiporeferencia" id="idtiporeferencia" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<?php
				$idEstab = "select idpoblacion, descripcion from tipo_poblacion order by descripcion desc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rowA)
					{
						echo "<option value='".$rowA["idpoblacion"]."'>".$rowA["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
			}
		if ($idindicador==10){
		?>
		<div class="col-md-2">
			<label class="control-label"> Tipo Referencia</label>
		</div>
		<div class="col-md-3">
			<select name="idtiporeferencia" id="idtiporeferencia" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<?php
				$idEstab = "select idtiporeferencia, descripcion from tipo_referencia order by descripcion desc"; 
				$rowEst = $objconfig->execute_select($idEstab,1);	
					
					foreach($rowEst[1] as $rowA)
					{
						echo "<option value='".$rowA["idtiporeferencia"]."'>".$rowA["descripcion"]."</option>";
					}
				?>
			</select>	
		</div>
		<?php 
		
		}
		?>
		</div>
	</div>
	<hr/>
	<div class="row">
	<div class="col-md-12">
		<div class="col-md-2">
		<label class="control-label">Año </label>
	</div>
	<div class="col-md-2">
		<select name="anio" id="anio" class="form-control" onchange="actualizar_datos_indicador(<?php echo $idindicador; ?>);">
			<?php
				$sqlA = "select anio from meses group by anio";
				$rowA = $objconfig->execute_select($sqlA,1);
				foreach($rowA[1] as $rA)
				{
					echo "<option value='".$rA["anio"]."'>".$rA["anio"]."</option>";
				}
			?>
		</select>	
	</div>
	<div class="col-md-1">
			<label class="control-label">Mes</label>
		</div>
		<div class="col-md-3">
			<select  name="mes" id="mes" class="form-control" onchange="actualizar_datos_mes(<?php echo $idindicador; ?>);">
			<option value="0"></option>
				<?php
					$sqlA = "select mes from meses order by mes";
					$rowA = $objconfig->execute_select($sqlA,1);
					foreach($rowA[1] as $rA)
					{
						$selected="";
						if($row["mes"]==$rA["mes"]){$selected="selected='selected'";}
						echo "<option value='".$rA["mes"]."' ".$selected." >".strtoupper($meses[$rA["mes"]])."</option>";
					}
				?>
			</select>
		</div>
		<div class="col-md-2">
			<label for="atencion" class="control-label">Valor Mes</label>
		</div>
		<div class="col-md-2">
			<input type="text" readonly="readonly" name="ValorMes" value="" id="ValorMes" class="form-control" />							
		</div>
		
	
	</div>
	</div>
	<br/>
	<div class="row">
	<div class="col-md-12">
	<div class="col-md-2">
			<label class="control-label">Ultimo Mes </label>
		</div>
		<div class="col-md-2">
		<input type="text" readonly="readonly" name="ultMes" value="<?php echo $row[1]["ultimo_mes"];?>" id="ultMes" class="form-control" />	
		</div>
		<div class="col-md-2">
			<label for="atencion" class="control-label">Valor Ultimo Mes</label>
		</div>
		<div class="col-md-2">
			<input type="text" readonly="readonly" name="vActual" value="<?php echo number_format($row[1]["valor_actual"],2);?>" id="vActual" class="form-control" />							
			<div id="div-grafico-tendencia"></div>
		</div>
		<div class="col-md-2">
			<label for="atencion" class="control-label">Tendencia</label>
		</div>
		<div class="col-md-2">
			<input type="text" disabled="disabled" name="Tendencia" id="Tendencia" style="background-color: <?php echo $color; ?>; border: 1px #000000 solid;" class="form-control"/>							
		</div>
	
	</div>
		
	</div>

		</div>
	<br/>