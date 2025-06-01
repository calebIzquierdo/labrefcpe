<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from materiales where idmaterial=".$cod;
		$row = $objconfig->execute_select($query);
	}
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento de Material y/o Insumos </h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
				<input type="hidden" name="1form_idmaterial" id="codigo" value="<?=$row[1]["idmaterial"]?>" class="form-control"  />
				<br />

				<label >Clase:</label>
				<select id="idtipomaterial" name="0form_idtipomaterial"  class="form-control"  >
                  	<option value="0">--Seleccione el Documento--</option>
                   	<?php
							   
						$queryT = "select idtipomaterial,descripcion from tipo_material where estareg=1 ";
						$itemsT = $objconfig->execute_select($queryT,1);
										
						foreach($itemsT[1] as $rowT)
						{
		                    $selected="";
		                    if($rowT["idtipomaterial"]==$row[1]["idtipomaterial"]){$selected="selected='selected'";}
		                    echo "<option value='".$rowT["idtipomaterial"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						}
                    ?>
				</select>
				<br />
				<label >Unidad Medida:</label>
				<select id="idunidad" name="0form_idunidad"  class="form-control" >
                  	<option value="0">--Seleccione el Documento--</option>
                   	<?php
							   
						$queryT = "select idunidad,descripcion from unidad_medida where estareg=1 ";
						$itemsT = $objconfig->execute_select($queryT,1);
										
						foreach($itemsT[1] as $rowT)
						{
		                    $selected="";
		                    if($rowT["idunidad"]==$row[1]["idunidad"]){$selected="selected='selected'";}
		                    echo "<option value='".$rowT["idunidad"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						}
                    ?>
				</select>
				<br />
				<label>Descripción</label>
				<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control"  />
				<br />
				<label>Cantidad Determinantes</label>
				<input type="text" name="0form_cantprueba" id="cantprueba" value="<?=$row[1]["cantprueba"]?>" class="form-control"  />
				<br />
				<label>Denominación Técnica</label>
				<input type="text" name="0form_denominacion" id="denominacion" value="<?=$row[1]["denominacion"]?>" class="form-control"  />
				<br />
				<label>Metodología</label>
				<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
					<label for="atencion" class="control-label">Descripción</label>
					</div>
					<div class="col-md-8">
					<input type="text" name="metodos" id="metodos" value="" class="form-control"  />
					</div>
					<div class="col-md-1">
						<input type="button" onclick="agregar_metod();" class="btn btn-info"  value="Agregar" />
					</div>
				</div>
				</div>
				</br>
				<div style="height:180px;  overflow-x:hidden;" >
				<div class="row">

				<div class="col-sm-12">
				<div class="panel panel-info class ">
				
					<div class="panel-heading">Lista de Metodologias</div>
					
					<div class="panel-body table-responsive">
						<table class="table table-striped table-hover table-active table-condensed" id="tbmetodologia" name="tbmetodologia" >
							 <thead class="thead-light">

							<tr align ="center" class="bg-success">
								<td >#</td>
								<td >Descripción</td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_metodo=0;
			  
							$sqlT = "select m.idmaterial,m.descripcion
										from material_metodo as m
										where m.idmaterial=".$cod." order by  m.descripcion asc";
						
							$rowTr = $objconfig->execute_select($sqlT,1);
							foreach($rowTr[1] as $rRt)
							{
								$count_metodo++;
							//	$tp_int = $objconfig->execute_select("select descripcion from tipo_intervencion where idtipointervencion=".$rRt["idtipointervencion"]);
							
								?>
								<tr id='itemmetodologia<?=$count_metodo;?>' name='itemmetodologia<?=$count_metodo;?>' align ="center"  >
									<td >
										<input type='hidden' name='idmaterial<?=$count_metodo;?>' id='idmaterial<?=$count_metodo;?>' value='<?php echo $rRt["idmaterial"]; ?>' />
										<?php echo $count_metodo ; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='descripcion<?=$count_metodo;?>' id='descripcion<?=$count_metodo;?>' value='<?php echo $rRt["descripcion"]; ?>' />
										<?php echo strtoupper($rRt["descripcion"] ); ?>
									</td>
									<td >
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_metodo(<?=$count_metodo;?>)' title='Borrar REgistro' />
									</td>
								</tr>
								
							<?php }?>
							</tbody>
							<tfoot class="">
							
							<tr align ="center" class="bg-success thead-light">
								<td >#</td>
								<td >Descripción</td>
								<td ></td>
							</tr>
						  </tfoot>
						</table>
						<input type="hidden" id="contar_metodo" name="contar_metodo" value="<?=$count_metodo;?>" />
						<input type="hidden" id="contar_metodo2" name="contar_metodo2" value="<?=$count_metodo;?>" />
						<script> var  count_metodo=<?=$count_metodo;?> </script>
						</div>
						</div>
						</div>
					</div>
					</div>
				<br />
				<label>Muestras Biológicas</label>
				<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
					<label for="atencion" class="control-label">Descripción</label>
					</div>
					<div class="col-md-8">
					<input type="text" name="mbiolog" id="mbiolog" value="" class="form-control"  />
					</div>
					<div class="col-md-1">
						<input type="button" onclick="agregar_mbio();" class="btn btn-info"  value="Agregar" />
					</div>
				</div>
				</div>
				</br>
				<div style="height:180px;  overflow-x:hidden;" >
				<div class="row">

				<div class="col-sm-12">
				<div class="panel panel-info class ">
				
					<div class="panel-heading">Lista de Muestras Biológicas</div>
					
					<div class="panel-body table-responsive">
						<table class="table table-striped table-hover table-active table-condensed" id="tbmuestras" name="tbmuestras" >
							 <thead class="thead-light">

							<tr align ="center" class="bg-success">
								<td >#</td>
								<td >Descripción</td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_muestra=0;
			  
							$sqlT2 = "select m.idmaterial,m.descripcion
										from material_mbiolo as m
										where m.idmaterial=".$cod." order by  m.descripcion asc";
						
							$rowTr2 = $objconfig->execute_select($sqlT2,1);
							foreach($rowTr2[1] as $rRt2)
							{
								$count_muestra++;
							
							
								?>
								<tr id='itemmuestra<?=$count_muestra;?>' name='itemmuestra<?=$count_muestra;?>' align ="center"  >
									<td >
										<input type='hidden' name='idmaterial<?=$count_muestra;?>' id='idmaterial<?=$count_muestra;?>' value='<?php echo $rRt2["idmaterial"]; ?>' />
										<?php echo $count_muestra ; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='descripcion<?=$count_muestra;?>' id='idotros<?=$count_muestra;?>' value='<?php echo $rRt2["descripcion"]; ?>' />
										<?php echo strtoupper($rRt2["descripcion"] ); ?>
									</td>
									<td >
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_muestra(<?=$count_muestra;?>)' title='Borrar REgistro' />
									</td>
								</tr>
								
							<?php }?>
							</tbody>
							<tfoot class="">
							
							<tr align ="center" class="bg-success thead-light">
								<td >#</td>
								<td >Descripción</td>
								<td ></td>
							</tr>
						  </tfoot>
						</table>
						<input type="hidden" id="contar_muestra" name="contar_muestra" value="<?=$count_muestra;?>" />
						<input type="hidden" id="contar_muestra2" name="contar_muestra2" value="<?=$count_muestra;?>" />
						<script> var  count_muestra=<?=$count_muestra;?> </script>
						</div>
						</div>
						</div>
					</div>
					</div>
				<br />
				<label>Caracteristicas</label>
				<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
					<label for="atencion" class="control-label">Descripción</label>
					</div>
					<div class="col-md-8">
					<input type="text" name="caracteres" id="caracteres" value="" class="form-control"  />
					</div>
					<div class="col-md-1">
						<input type="button" onclick="agregar_caracter();" class="btn btn-info"  value="Agregar" />
					</div>
				</div>
				</div>
				</br>
				<div style="height:180px;  overflow-x:hidden;" >
				<div class="row">

				<div class="col-sm-12">
				<div class="panel panel-info class ">
				
					<div class="panel-heading">Lista de Caracteristicas Técnicas</div>
					
					<div class="panel-body table-responsive">
						<table class="table table-striped table-hover table-active table-condensed" id="tbcaracteristicas" name="tbcaracteristicas" >
							 <thead class="thead-light">

							<tr align ="center" class="bg-success">
								<td >#</td>
								<td >Descripción</td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_caracter=0;
			  
							$sqlT3 = "select m.idmaterial,m.descripcion
										from material_caracteristicas as m
										where m.idmaterial=".$cod." order by  m.descripcion asc";
						
							$rowTr3 = $objconfig->execute_select($sqlT3,1);
						
							foreach($rowTr3[1] as $rRt3)
							{
								$count_caracter++;
														
								?>
								<tr id='itemcaracteristica<?=$count_caracter;?>' name='itemcaracteristica<?=$count_caracter;?>' align ="center"  >
									<td >
										<input type='hidden' name='idmaterial<?=$count_caracter;?>' id='idmaterial<?=$count_caracter;?>' value='<?php echo $rRt3["idmaterial"]; ?>' />
										<?php echo $count_caracter ; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='descripcion<?=$count_caracter;?>' id='idotros<?=$count_caracter;?>' value='<?php echo $rRt3["descripcion"]; ?>' />
										<?php echo strtoupper($rRt3["descripcion"] ); ?>
									</td>
									<td >
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_caracter(<?=$count_caracter;?>)' title='Borrar Registro' />
									</td>
								</tr>
								
							<?php }?>
							</tbody>
							<tfoot class="">
							
							<tr align ="center" class="bg-success thead-light">
								<td >#</td>
								<td >Descripción</td>
								<td ></td>
							</tr>
						  </tfoot>
						</table>
						<input type="hidden" id="contar_caracteres" name="contar_caracteres" value="<?=$count_caracter;?>" />
						<input type="hidden" id="contar_caracteres2" name="contar_caracteres2" value="<?=$count_caracter;?>" />
						<script> var  count_caracter=<?=$count_caracter;?> </script>
						</div>
						</div>
						</div>
					</div>
					</div>
				<br />
				<label>Documentación</label>
				<input type="text" name="0form_documentos" id="documentos" value="<?=$row[1]["documentos"]?>" class="form-control"  />
				<br />
				<label>Otros detalle</label>
				<input type="text" name="0form_especificaiones" id="especificaiones" value="<?=$row[1]["especificaiones"]?>" class="form-control"  />
				<!--
				<textarea id="especificaiones" name="0form_especificaiones" rows="4" cols="68" class="form-control"  ><?=$row[1]["especificaiones"]?></textarea>
				<input type="text" name="0form_especificaiones" id="especificaiones" value="<?=$row[1]["especificaiones"]?>" class="form-control"  />
				-->
				<br />
				<label>Tiene Vencimiento</label>
				<select id="idvence" name="0form_idvence"  class="form-control" >
                  	<option value="0">--Seleccione el Documento--</option>
                   	<?php
							   
						$queryT = "select idcondicion,descripcion from tipo_condicion where estareg=1 and idcondicion in (1,2)  ";
						$itemsT = $objconfig->execute_select($queryT,1);
										
						foreach($itemsT[1] as $rowT)
						{
		                    $selected="";
		                    if($rowT["idcondicion"]==$row[1]["idvence"]){$selected="selected='selected'";}
		                    echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						}
                    ?>
				</select>
				<br />

		<label>Estado</label>
				
				<?php
					$checked = "checked='checked'";
                    $checked1 = "checked='checked'";
                    $mensaje = "Activo";
					$class = "btn btn-primary"; 
					$estareg = 1;
					if(isset($row[1]["estareg"]))
					{
						$estareg = $row[1]["estareg"];
						if($estareg==0)
						{
							$checked = "";
							 $mensaje = "Inactivo";
							 $class = "btn btn-danger"; 
						}
					}
                   
				?>

				<input type="checkbox" name="estado" id="estado" onclick="cambiarestado(this,'estareg');" class="checkbox-inline" <?php echo $checked;?> />
				<button type='button' class='<?php echo $class;?>' name="boton01" id="boton01" > <?php echo $mensaje;?> </button>
								
				<input type="hidden" name="0form_estareg" id="estareg" value="<?=$estareg?>"  />
				<input type="hidden" name="op" id="op" value="<?=$op?>"  />
				<br />
				<!--
				<label>Adjuntar</label>
				<input type="file" name="user_image" id="user_image" />
				<span id="user_uploaded_image"></span> 
				-->
			</div>
			<div class="modal-footer">
		<!--		<input type="hidden" name="user_id" id="user_id" />
				<input type="hidden" name="operation" id="operation" /> -->
				<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" value="Guardar" />
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

			</div>
		</div>
	</form>
	
	
<script type="text/javascript">
       tipserv(<?php echo $row[1]["idservicio"]; ?>)
   
</script>