<?php

	include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");	
		
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from cliente where idcliente=".$cod;
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
				<input type="hidden" name="1form_idcliente" id="codigo" value="<?=$row[1]["idcliente"]?>" class="form-control"    />
				<label>Nombres / Razon Social</label>
				<input type="text" name="0form_razonsocial" id="razonsocial" value="<?=$row[1]["razonsocial"]?>" class="form-control"    />
				<br />
				
				<label>Direccion </label>
				<input type="text" name="0form_direccion" id="direccion" value="<?=$row[1]["direccion"]?>" class="form-control"    />
				<br />
				<div class="row">
					<div class="col-sm-12">
						<div class="col-md-2">	
						<label for="atencion"  class="control-label text-left">Tipo Documento:</label>
					</div>
					<div class=" col-md-4" >	
					<select id="iddocumento" name="0form_iddocumento"  class="form-control" >
                  	<option value="0"></option>
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
					</div>
					<div class="col-md-2">	
					<label for="atencion" class="control-label">Número Documento: </label>
					</div>
					<div class="col-md-4" >	
					<input type="text"  name="0form_ruc" id="ruc" value="<?=$row[1]["ruc"]?>"  class="form-control" />
					<!-- Solo para prueba de consulta Dni - Sis 
					<input type="text" onkeypress="if (event.keyCode==13){ buscar_dni(this.value);}" name="nrodocumento" id="nrodocumento" value=" " class="form-control" wfd-id="id29">
					-->
					</div>
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

			</div>
		</div>
	</form>
<script>
      
  /*  cargar_datos_departamentoA("<?php $d=0;isset($row[1]["idpais"])?$d=$row[1]["idpais"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0; echo $d; ?>",2)
  */
    cargar_datos_provinciaA("<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0; echo $d; ?>",2)    
    cargar_datos_distritoA("<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>",2)
    /*
    cargar_datos_sectoresA("<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>","<?php $d=0;isset($row[1]["idsector"])?$d=$row[1]["idsector"]:$d=0; echo $d; ?>",2) 
    */
</script>