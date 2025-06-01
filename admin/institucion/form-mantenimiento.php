<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from institucion where codemp=".$cod;
		$row = $objconfig->execute_select($query);
	}

		
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento Red de Salud</h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
				<label>Item</label>
				<input type="text" name="1form_codemp" id="codigo" class="form-control"  value="<?=$row[1]["codemp"]?>"  />
				<br />
				<label>Red de Salud</label>
				<input type="text" name="0form_razonsocial" id="descripcion" value="<?=$row[1]["razonsocial"]?>" class="form-control" />
				<br />
				<label for="atencion" class="col-md-2 control-label">Departam:</label>
				<div class="input-group col-md-8 control-labe" >	
				<select id="iddepartamento" name="0form_iddepartamento"  class="col-md-2 combox " onchange="cargar_datos_provinciaA(this.value,0,2)" >
                  	<option value="0">--Departamento--</option>
                            <?php
                                $queryT = "select iddepartamento, descripcion from departamento where idpais=2 and  estareg=1";
                                $itemsT = $objconfig->execute_select($queryT,1);

                                foreach($itemsT[1] as $rowT)
                                {
                                    $selected="";
                                    if($rowT["iddepartamento"]==$row[1]["iddepartamento"]){$selected="selected='selected'";}
                                    echo "<option value='".$rowT["iddepartamento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                                }
                            ?>
                       </select>
				</select>
				
				<label for="atencion" class="col-md-3 control-label">Provincia: </label>
				<div class="input-group col-md-4" class="combox">	
				<div id="div-provinciaB" > </div>
				</div>
				</div>
				</br>

				<label for="atencion" class="col-md-2 control-label">Distrito:</label>
				<div class="input-group col-md-8" >	
				<div id="div-distritoB" > </div>
				

				<label for="atencion" class="col-md-3 control-label">Vía: </label>
				<div class="input-group col-md-4" class="combox">	
				<select id="idtipovia" name="0form_idtipovia" class="col-md-2 form-control">
                            <option value="0">--Via--</option>
                            <?php
				$queryT = "select idtipovia, descripcion from tipo_via where estareg=1 order by descripcion";
				$itemsT = $objconfig->execute_select($queryT,1);
								
				foreach($itemsT[1] as $rowT)
				{
                                    $selected="";
                                    if($rowT["idtipovia"]==$row[1]["idtipovia"]){$selected="selected='selected'";}
                                    echo "<option value='".$rowT["idtipovia"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
				}
                            ?>
				</select>

				</div>
				</div>
				

				<br />
				<label>Dirección</label>
				<input type="text" name="0form_direccion" id="direccion" value="<?=$row[1]["direccion"]?>" class="form-control" />
				<br />
				<label>Rep. Legal</label>
				<input type="text" name="0form_replegal" id="replegal" value="<?=$row[1]["replegal"]?>" class="form-control"  />
				<br />
				<label>Nro. RUC</label>
				<input type="text"  name="0form_ruc" id="nrodocumento" value="<?=$row[1]["ruc"]?>" class="form-control"  />
				<br />
				<label>Notas</label>
				<textarea rows="2" class="form-control" id="notas" name="0form_notas" > <?=$row[1]["notas"]?> </textarea>
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
		<!--		<input type="hidden" name="user_id" id="user_id" />
				<input type="hidden" name="operation" id="operation" /> -->
                <button type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" data-dismiss="modal" data-backdrop="false" > Guardar </button>
                <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>


            </div>
		</div>
	</form>

<script>
      
  //  cargar_datos_departamentoA("<?php $d=0;isset($row[1]["idpais"])?$d=$row[1]["idpais"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0; echo $d; ?>",2)

 //   cargar_datos_provinciaA("<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0; echo $d; ?>",2)
 //   cargar_datos_distritoA("<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>",2)

  //  cargar_datos_sectoresA("<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>","<?php $d=0;isset($row[1]["idsector"])?$d=$row[1]["idsector"]:$d=0; echo $d; ?>",2)

</script>