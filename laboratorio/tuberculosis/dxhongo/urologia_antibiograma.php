<?php
	include("../../../objetos/class.conexion.php");
	$objconfig = new conexion();
	
?>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-3">
				<label for="atencion" class="control-label">Diagnóstico:  </label>
			</div>

			<div class="col-md-9">
				<select id="idresultado" name="0form_idresultado" class="form-control" <?php echo $readonly; ?> >
					<option value="0"></option>
					<?php
					$queryT2 = "select idresultado, descripcion from tipo_resultado where estareg=1 order by descripcion asc ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						if($rowT2["idresultado"]==$row[1]["idresultado"]){$selected="selected='selected'";}
						echo "<option value='".$rowT2["idresultado"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
			</div>

		</div>
	</div>
	</br>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-3">
				<label for="atencion" class="control-label">Antibiograma:  </label>
			</div>

			<div class="col-md-4">
				<select id="antibiograma" name="antibiograma" class="form-control" <?php echo $readonly; ?> >
					<option value="0"></option>
					<?php
					$queryT2 = "select idantibiograma, descripcion from antibiograma where estareg=1 order by descripcion asc ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						if($rowT2["idantibiograma"]==$row[1]["idantibiograma"]){$selected="selected='selected'";}
						echo "<option value='".$rowT2["idantibiograma"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-md-1">
				<label for="atencion" class="control-label">Tipo:  </label>
			</div>
			<div class="col-md-3">
				<select id="tipo_antigrama" name="tipo_antigrama" class="form-control" <?php echo $readonly; ?> >
					<option value="0"></option>
					<?php
					$queryT2 = "select idtipoantibiograma, descripcion from tipo_antibiograma where estareg=1 order by idtipoantibiograma asc ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						if($rowT2["idtipoantibiograma"]==$row[1]["idtipoantibiograma"]){$selected="selected='selected'";}
						echo "<option value='".$rowT2["idtipoantibiograma"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-md-1">
				<input type="button" onclick="agregar_antigrama();" name="action" id="action" class="btn btn-success"  value="Agregar" />
			</div>
		</div>
	</div>
	</br>
	<div style="height:180px;  overflow-x:hidden;" >
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info ">
					<div class="panel-heading">LISTADO DE ANTIGRAMA </div>
					<div class="panel-body">
						<table class="table table-striped table-bordered table-hover table-responsive" id="tbdiagnostico" name="tbdiagnostico" >
							<thead>

							<tr>
								<td >Item</td>
								<td >Antigrama</td>
								<td >Tipo</td>
								<td > </td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_enf=0;
							$sqlF = "select  prp.idreferencia, p.iddiagnostico, p.descripcion as tipoenferm, p.codigo, td.descripcion as tipdiag, 
									prp.idtipodiagnostico, pd.idprioridad, pd.descripcion as prio
									from referencia_diagnostico as prp
									inner join diagnostico as p on(p.iddiagnostico=prp.iddiagnostico)
									inner join tipo_diagnostico as td on(td.idtipodiagnostico=prp.idtipodiagnostico)
									inner join prioridad_diagnostico as pd on(pd.idprioridad=prp.idprioridad)
									where prp.idreferencia=".$cod." and prp.idcontrareferencia=0";
							$rowF = $objconfig->execute_select($sqlF,1);
							foreach($rowF[1] as $rF)
							{
								$count_enf++;

								?>
								<tr id='itemdiagnostico<?php echo $count_enf; ?>' name='itemdiagnostico<?php echo $count_enf; ?>' >
									<td >
										<input type='hidden' name='idreferencia<?php echo $count_enf; ?>' id='idreferencia<?php echo $count_enf; ?>' value='<?php echo $rF["idreferencia"]; ?>' />
										<?php echo $count_enf ; ?>
									</td>
									<td>
										<input type='hidden' name='idprioridad<?php echo $count_enf; ?>' id='idprioridad<?php echo $count_enf; ?>' value='<?php echo $rF["idprioridad"]; ?>' />
										<?php echo strtoupper($rF["prio"] ); ?>
									</td>
									<td>
										<input type='hidden' name='iddiagnostico<?php echo $count_enf; ?>' id='iddiagnostico<?php echo $count_enf; ?>' value='<?php echo $rF["iddiagnostico"]; ?>' />
										<?php echo strtoupper($rF["codigo"] ); ?>
									</td>
									<td>
										<?php echo strtoupper($rF["tipoenferm"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idtipodiagnostico<?php echo $count_enf; ?>' id='idtipodiagnostico<?php echo $count_enf; ?>' value='<?php echo $rF["idtipodiagnostico"]; ?>' />
										<?php echo strtoupper($rF["tipdiag"] ); ?>
									</td>
									<td >
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Borrar REgistro' />
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_enf; ?>" />
						<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_enf; ?>" />
						<script> var  count_enf=<?php echo $count_enf; ?> </script>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	