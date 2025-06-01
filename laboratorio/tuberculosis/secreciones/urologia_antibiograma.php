<?php
	include("../../../objetos/class.conexion.php");
	$objconfig = new conexion();
	$result  = $_POST["cod"];
	$iduro  = $_POST["idsecre"];
	$rcuent  = $_POST["rcuento"];
	
	$query = "select * from secreciones where idsecreciones=".$iduro;
		$row = $objconfig->execute_select($query);
	
	// Ziehl Neelsen:
	
?>	

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
							$count_diagn=0;
							$sqlF = "select  prp.idsecreciones, prp.idantibiograma, prp.idtipoantibiograma, p.descripcion as antibio, 
									 td.descripcion as tipantibio
									from secreciones_antibiograma as prp
									inner join antibiograma as p on(p.idantibiograma=prp.idantibiograma)
									inner join tipo_antibiograma as td on(td.idtipoantibiograma=prp.idtipoantibiograma)
									
									where prp.idsecreciones=".$iduro ;
									$sqlF;
							$rowF = $objconfig->execute_select($sqlF,1);
							foreach($rowF[1] as $rF)
							{
								$count_diagn++;

								?>
								<tr id='itemdiagnostico<?php echo $count_diagn; ?>' name='itemdiagnostico<?php echo $count_diagn; ?>' >
									<td >
										<input type='hidden' name='idantibiograma<?php echo $count_diagn; ?>' id='idantibiograma<?php echo $count_diagn; ?>' value='<?php echo $rF["idantibiograma"]; ?>' />
										<?php echo $count_diagn ; ?>
									</td>
									<td>
										<input type='hidden' name='idtipoantibiograma<?php echo $count_diagn; ?>' id='idtipoantibiograma<?php echo $count_diagn; ?>' value='<?php echo $rF["idtipoantibiograma"]; ?>' />
										<?php echo strtoupper($rF["antibio"] ); ?>
									</td>
									<td>
										<input type='hidden' name='iddiagnostico<?php echo $count_diagn; ?>' id='iddiagnostico<?php echo $count_diagn; ?>' value='<?php echo $rF["iddiagnostico"]; ?>' />
										<?php echo strtoupper($rF["tipantibio"] ); ?>
									</td>

									<td >
									<!--
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_diagn; ?>)' title='Borrar REgistro' />
									-->
									</td>
									
								</tr>
							<?php }?>
							</tbody>
						</table>
						<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_diagn; ?>" />
						<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_diagn; ?>" />
						<script> var  count_diagn=<?php echo $count_diagn; ?> </script>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	</br>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-1">
				<label for="atencion" class="control-label">Etiología:  </label>
			</div>

			<div class="col-md-2">
		
				<select name="0form_idetiologia" id="idetiologia" class="form-control"  >
					<option value="0"></option>
					<?php
					$queryT2 = "select idetiologia, descripcion from tipo_etiologia where estareg=1 order by descripcion asc ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						if($rowT2["idetiologia"]==$row[1]["idetiologia"]){$selected="selected='selected'";}
						echo "<option value='".$rowT2["idetiologia"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-md-1">
				<label for="atencion" class="control-label">Gram:  </label>
			</div>

			<div class="col-md-2">
				<input type="text" name="0form_gram" id="gram" class="form-control" value="<?php echo $row[1]["gram"]; ?>" placeholder="Grama" data-toggle="tooltip" data-placement="top" title="Grama" />
			</div>
			<div class="col-md-1">
				<label for="atencion" class="control-label">Ziehl Neelsen:  </label>
			</div>

			<div class="col-md-2">
				<input type="text" name="0form_ziehl" id="ziehl" class="form-control" value="<?php echo $row[1]["ziehl"]; ?>" placeholder="Ziehl Neelsen" data-toggle="tooltip" data-placement="top" title="Ziehl Neelsen" />
			</div>
			<div class="col-md-1">
				<label for="atencion" class="control-label">Ex. Directo:  </label>
			</div>

			<div class="col-md-2">
				<input type="text" name="0form_exfisico" id="exfisico" class="form-control" value="<?php echo $row[1]["exfisico"]; ?>" placeholder="Exmane Fisico" data-toggle="tooltip" data-placement="top" title="Exmane Fisico" />
			</div>

		</div>
	</div>
	 </br>
	