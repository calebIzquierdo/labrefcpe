<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	$idusuario = explode("|",$_SESSION['nombre']);
	$iduser = $idusuario[0];
	
	
	if($cod!=0)
	{
		$query = "select * from tipo_examen where idtipo_examen=".$cod;
		$row = $objconfig->execute_select($query);
	}
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento de Examen </h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
			</div>
			<div class="modal-body">
				<label>Item</label>
				<input type="text" name="1form_idtipo_examen" id="codigo" value="<?=$row[1]["idtipo_examen"]?>" readonly class="form-control"  />
				<br />
				<label>Unidad</label>
                <select id="idarea" name="0form_idarea" class="form-control" onchange="cargar_subarea(this.value,<?=$row[1]["idareatrabajo"]?>)" >
                    <option value="0"></option>
                    <?php
                    $queryT = "select idarea, descripcion from areas where estareg=1 order by descripcion asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        if($rowT["idarea"]==$row[1]["idarea"]){$selected="selected='selected'";}
                        echo "<option value='".$rowT["idarea"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
                </select>
                <br />
				<label>Unidad Trabajo</label>
                <div id="div-subarea" name="div-subarea"></div>
				 <br />
				<label>Descripcion</label>
				<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control"  />
				</br>
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-2">
                            <label>Convenio</label>
                        </div>
						<div class="col-md-4">
							<select id="tipatencion" name="tipatencion" class="form-control" placeholder="Resultado" data-toggle="tooltip" data-placement="top" title="Resultado"  >
								<option value="0"></option>
								<?php
								$queryT = "select idtipoatencion, descripcion from tipo_atencion where estareg=1 order by descripcion asc";
								$itemsT = $objconfig->execute_select($queryT,1);

								foreach($itemsT[1] as $rowT)
								{
									$selected="";
									if($rowT["idtipoatencion"]==$row[1]["idtipoatencion"]){$selected="selected='selected'";}
									echo "<option value='".$rowT["idtipoatencion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
								}
								?>
							</select>
							
						</div>
						<div class="col-md-1">
							 <label>Precio</label>
						</div>
						<div class="col-md-3">
                            <input type="text" name="valor" id="valor" value=""  class="form-control" placeholder="Costo" data-toggle="tooltip" data-placement="top" title="Costo de Prueba" />
                        </div>
						<div class="col-md-1">
							<input type="button" onclick="agregar_prueba();" name="prueb" id="prueb" class="btn btn-success"  value="Agregar" />
						</div>

					</div>
				</div>
				</br>
				<div style="height:280px;  overflow-x:hidden;" >
				<div class="row">

				<div class="col-sm-12">
				<div class="panel panel-info ">
				
					<div class="panel-heading">LISTADO DE PRECIOS SEGUN CONVENIO </div>
					
					<div class="panel-body">
						<table class="table table-striped table-bordered table-hover table-responsive" id="tbprueba" name="tbprueba" >
							<thead>

							<tr>
								<td >#</td>
								<td >Convenio</td>
								<td >Costo</td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_prue=0;
			  
							$sqlT = "select  e.idtipoatencion, e.descripcion as tipprueba, m.valor 
									from tipo_examen_precio as m
									inner join tipo_atencion as e on(e.idtipoatencion=m.idtipoatencion)
									where m.idtipo_examen=".$cod." ";
							$rowTr = $objconfig->execute_select($sqlT,1);
							foreach($rowTr[1] as $rRt)
							{
								$count_prue++;

								?>
								<tr id='itemprueba<?php echo $count_prue; ?>' name='itemprueba<?php echo $count_prue; ?>' >
									<td >
										
										<?php echo $count_prue ; ?>
									</td>
									<td>
										<input type='hidden' name='idtipoatencion<?php echo $count_prue; ?>' id='idtipoatencion<?php echo $count_prue; ?>' value='<?php echo $rRt["idtipoatencion"]; ?>' />
										<?php echo strtoupper($rRt["tipprueba"] ); ?>
									</td>
									<td>
										<input type='hidden' name='valor<?php echo $count_prue; ?>' id='valor<?php echo $count_prue; ?>' value='<?php echo $rRt["valor"]; ?>' />
										<?php echo strtoupper($rRt["valor"] ); ?>
									</td>
							
								
									<td >
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_prue; ?>)' title='Borrar REgistro' />
									</td>
								</tr>
								
							<?php }?>
							</tbody>
						</table>
						<input type="hidden" id="contar_prueba" name="contar_prueba" value="<?php echo $count_prue; ?>" />
						<input type="hidden" id="contar_prueba2" name="contar_prueba2" value="<?php echo $count_prue; ?>" />
						<script> var  count_prue=<?php echo $count_prue; ?> </script>
						</div>
						</div>
						</div>
					</div>
				</div>

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
		
			</div>
			<div class="modal-footer">

				<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" value="Agregar" />
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

			</div>
		</div>
	</form>
	
	
<script type="text/javascript">
    cargar_subarea(<?php echo $row[1]["idarea"];?>,<?php echo $row[1]["idareatrabajo"];?>)
    
    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
	/*
	// Para usar un tooltip especifico hacer de la siguiente manera
	// <input type="text" rel="txtTooltip" title="**Escribir el mensaje a mostrar**" data-toggle="tooltip" data-placement="bottom">
	
	$(document).ready(function() {
	$('input[rel="txtTooltip"]').tooltip();
	});
	*/
	// Para usar un tooltip sin especificar tag en especial
	$(function () {
	$('[data-toggle="tooltip"]').tooltip()
	})
	
</script>