<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from seriedoc where idseriedoc=".$cod;
		$row = $objconfig->execute_select($query);
	}

		
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Creacion de serie</h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="1form_idseriedoc" id="1form_idseriedoc" value="<?php echo $cod;?>" />
			</div>
			<div class="modal-body">
				<label>Serie:</label>
				<input type="text" name="0form_seriedoc" id="seriedoc" class="form-control"  value="<?=$row[1]["seriedoc"]?>"  />
				<br />
				<label>Valor:</label>
				<input type="number" name="0form_valor" id="valor" value="<?=$row[1]["valor"]?>" class="form-control" />
            <br/>
              
                            <label class="control-label">Comprobante:</label>
				            <select id="idcomprobante" name="0form_idcomprobante"  class="form-control">
                  	        <option value="0">--Seleccionar--</option>
                            <?php
                                $queryT = "select idcomprobante, descripcion from tipo_comprobante where  estareg=1";
                                $itemsT = $objconfig->execute_select($queryT,1);

                                foreach($itemsT[1] as $rowT)
                                {
                                    $selected="";
                                    if($rowT["idcomprobante"]==$row[1]["idtipocomprobante"]){$selected="selected='selected'";}
                                    echo "<option value='".$rowT["idcomprobante"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                                }
                            ?>
                      	 	</select>
				
                <br />
				<?php
					$checked = "checked='checked'";
                    $checked1 = "checked='checked'";
                    $mensaje = "Activo";
					$class = "btn btn-primary"; 
					$estareg = 1;
					if(isset($row[1]["estado"]))
					{
						$estareg = $row[1]["estado"];
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
                <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
			</div>
			<div class="modal-footer">
		<!--	<input type="hidden" name="user_id" id="user_id" />
				<input type="hidden" name="operation" id="operation" /> -->
                <button type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" > Guardar </button>
                <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>


            </div>
		</div>
	</form>

<script>
      
  //  cargar_datos_departamentoA("<?php $d=0;isset($row[1]["idpais"])?$d=$row[1]["idpais"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0; echo $d; ?>",2)

    cargar_datos_provinciaA("<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0; echo $d; ?>",2)
    cargar_datos_distritoA("<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>",2)

  //  cargar_datos_sectoresA("<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>","<?php $d=0;isset($row[1]["idsector"])?$d=$row[1]["idsector"]:$d=0; echo $d; ?>",2)

</script>