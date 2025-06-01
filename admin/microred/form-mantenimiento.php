<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
    $idred=0;
    $idejecutora=0;

	if($cod!=0)
	{
		$query = "select * from microred where idmicrored=".$cod;
		$row = $objconfig->execute_select($query);
		$idred=$row[1]["idred"];
        $idejecutora=$row[1]["idejecutora"];
	}

		
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content"  >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento Micro Red de Salud</h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
				<label>Item</label>
				<input type="text" name="1form_idmicrored" id="idmicrored" class="form-control"  value="<?=$row[1]["idmicrored"]?>"  />
				<br />

				<label>Ejecutora de Salud</label>
				<select id="idejecutora" name="0form_idejecutora" class="combobox form-control" onchange="cargar_red(this.value,<?php echo $row[1]["idred"]; ?>)">>
                <option value="0">--Red de Salud--</option>
                <?php
				$queryT = "select idejecutora, descripcion from ejecutora where estareg=1 order by descripcion";
				$itemsT = $objconfig->execute_select($queryT,1);
								
				foreach($itemsT[1] as $rowT)
				{
                    $selected="";
                    if($rowT["idejecutora"]==$row[1]["idejecutora"]){$selected="selected='selected'";}
                    echo "<option value='".$rowT["idejecutora"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
				}
				?>
				</select>

				<br />
				<label>Red Salud</label>
				<div id="div-red" > </div>
				<br />
				<label>Micro Red</label>
				<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control" />
				<br />
				<label>Ubicación Geográfica</label>
				<br/>
				<div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label class="control-label">Departam:</label>
                        </div>
        				<div class="col-md-4">
				            <select id="iddepartamento" name="0form_iddepartamento"  class="form-control" onchange="cargar_datos_provinciaA(this.value,0,2)" >
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
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Provincia:</label>
                        </div>
                        <div class="col-md-4">
				            <div id="div-provinciaB" > </div>
				        </div>
				</div>
				</div>
				</br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label class="control-label">Distrito:</label>
                        </div>
                        <div class="col-md-4">
                        <div id="div-distritoB" > </div>
                        </div>
                <div class="col-md-2">
    				<label for="atencion" class="col-md-2 control-label">Vía: </label>
                </div>
				<div class="col-md-4" class="combox">
                    <select id="idtipovia" name="0form_idtipovia" class="form-control">
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
            </div>
				

				<label>Dirección</label>
				<input type="text" name="0form_direccion" id="direccion" value="<?=$row[1]["direccion"]?>" class="form-control" />
				<br />
				
				<label>Director</label>
				<input type="text" name="0form_replegal" id="replegal" value="<?=$row[1]["replegal"]?>" class="form-control"  />
				<br />
				<label>Nro. RUC</label>
				<input type="text"  name="0form_ruc" id="nrodocumento" value="<?=$row[1]["ruc"]?>" class="form-control"  />
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
    cargar_red(<?php echo $idejecutora; ?>,<?php echo $idred; ?>)
  // cargar_datos_departamentoA("<?php $d=0;isset($row[1]["idpais"])?$d=$row[1]["idpais"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0; echo $d; ?>",2)

    cargar_datos_provinciaA("<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0; echo $d; ?>",2)    
    cargar_datos_distritoA("<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>",2)

    //cargar_datos_sectoresA("<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>","<?php $d=0;isset($row[1]["idsector"])?$d=$row[1]["idsector"]:$d=0; echo $d; ?>",2)
  //<![CDATA[
  $(document).ready(function(){
      $('.combobox').combobox()
  });
  //]]>
</script>