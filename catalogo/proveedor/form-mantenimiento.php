<?php
	include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");	
		
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from proveedor where idproveedor=".$cod;
		$row = $objconfig->execute_select($query);
	}
?>
 
<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento de Clientes</h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
				<label>Item</label>
				<input type="text" name="1form_idproveedor" id="codigo" value="<?=$row[1]["idproveedor"]?>" class="form-control"    />
				<br />

				<label>Nombres / Razon Social</label>
				<input type="text" name="0form_razonsocial" id="razonsocial" value="<?=$row[1]["razonsocial"]?>" class="form-control"    />
				<br />
			
				<label>Direccion </label>
				<input type="text" name="0form_direccion" id="direccion" value="<?=$row[1]["direccion"]?>" class="form-control"    />
				<br />
				
				<label for="atencion" class="col-md-3 control-label">Tipo Documento:</label>
				<div class="input-group col-md-8" >	
				<select id="iddocumento" name="0form_iddocumento"  class="col-md-3 control2"  >
                  	<option value="0">--Seleccione el Documento--</option>
                   	<?php
							   
						$queryT = "select iddocumento,descripcion from tipo_documento ";
						$itemsT = $objconfig->execute_select($queryT,1);
										
						foreach($itemsT[1] as $rowT)
						{
		                    $selected="";
		                    if($rowT["iddocumento"]==$row[1]["iddocumento"]){$selected="selected='selected'";}
		                    echo "<option value='".$rowT["iddocumento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						}
                    ?>
				</select>
				
				<label for="atencion" class="col-md-4 control-label">Número Documento: </label>
				<div class="input-group col-md-4" >	
				<input type="text"  name="0form_nrodocumento" id="nrodocumento" value="<?=$row[1]["nrodocumento"]?>"  class="col-md-3 form-control" />
				</div>
				</div>
				</br>

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
				<input type="hidden" name="op" id="op" value="<?php echo $op;?>"  />
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
				<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" value="Agregar" />
				<button type="button" onclick="validar_form(dir);" class="btn btn-default" data-dismiss="modal">Cerrar</button>

			</div>
		</div>
	</form>
