<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from establecimiento where idestablecimiento=".$cod;
		$row = $objconfig->execute_select($query);
	}

?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento Puesto de Salud</h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
				<label>Item</label>
				<input type="text" name="1form_idestablecimiento" id="idestablecimiento" class="form-control"  value="<?=$row[1]["idestablecimiento"]?>"  />
				<br />

                <label>Ejecutora de Salud</label>
                <select id="idejecutora" name="0form_idejecutora" class="combobox form-control" onchange="cargar_red(this.value,<?php echo $row[1]["idred"]; ?>)"> >
                    <option value="0">--Ejecutora--</option>
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
                <label>Micro Red</label>
                <div id="div-microred" > </div>
				<br />
				<label>Nombre Puesto de Salud</label>
				<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control" />
				<br />
				<div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label>Cod Renaes</label>
                        </div>
        				<div class="col-md-4">
				            <input type="text" name="0form_codrenaes" id="codrenaes" value="<?=$row[1]["codrenaes"]?>" class="form-control" /> 
						</div>
						<div class="col-md-2">
                              <label>Ruc</label>
                        </div>
						<div class="col-md-4">
							<input type="text" name="0form_ruc" id="ruc" value="<?=$row[1]["ruc"]?>" class="form-control" />
						</div> 
						<!--
                        <div class="col-md-2">
                              <label>Cod Sis</label>
                        </div>
                       <div class="col-md-4">
							<input type="text" name="0form_ruc" id="ruc" value="<?=$row[1]["ruc"]?>" class="form-control" />
							<input type="text" name="0form_codsis" id="codsis" value="<?=$row[1]["codsis"]?>" class="form-control" />
				        </div> 
						-->
				</div>
				</div>
				 <br />
				 	<div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                           <label>CATEGORIA</label>
                        </div>
        				<div class="col-md-4">
				        <select id="idcategoria" name="0form_idcategoria"  class="form-control" >
							<option value="0"></option>
							<?php
							$queryT = "select idcategoria, descripcion from categoria where estareg=1";
							$itemsT = $objconfig->execute_select($queryT,1);

							foreach($itemsT[1] as $rowT)
							{
								$selected="";
								if($rowT["idcategoria"]==$row[1]["idcategoria"]){$selected="selected='selected'";}
								echo "<option value='".$rowT["idcategoria"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
							}
							?>
						</select>
						</div>
                        <div class="col-md-2">
                               <label>Tipo Inst</label>
                        </div>
                       <div class="col-md-4">
							<select id="idinstitucion" name="0form_idinstitucion"  class="form-control" >
							<option value="0"></option>
							<?php
							$queryT = "select idinstitucion, descripcion from tipo_institucion where estareg=1";
							$itemsT = $objconfig->execute_select($queryT,1);

							foreach($itemsT[1] as $rowT)
							{
								$selected="";
								if($rowT["idinstitucion"]==$row[1]["idinstitucion"]){$selected="selected='selected'";}
								echo "<option value='".$rowT["idinstitucion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
							}
							?>
						</select>
				        </div> 
				</div>
				</div>
				<br />
				<label>Ubicación Geográfica</label>
				<br/>
				<div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label class="control-label">Departam:</label>
                        </div>
        				<div class="col-md-4">
				            <select id="iddepartamento" name="0form_iddepartamento"  class="form-control combobox" onchange="cargar_datos_provinciaA(this.value,0,2)" >
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
    				<label for="atencion" class="col-md-2 control-label">Estado: </label>
                </div>
				<div class="col-md-4" class="combox">
                    
				
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
				</div>
            </div>
            </div>
             <br />
				<div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label>Longitud</label>
                        </div>
        				<div class="col-md-4">
				            <input type="text" name="0form_longitud" id="longitud" value="<?=$row[1]["longitud"]?>" class="form-control" /> 
						</div>
                        <div class="col-md-2">
                              <label>Latitud</label>
                        </div>
                       <div class="col-md-4">
							<input type="text" name="0form_latitud" id="latitud" value="<?=$row[1]["latitud"]?>" class="form-control" />
				        </div> 
				</div>
				</div>
				 <br />
                <!--
				<label>Dirección</label>
				<input type="text" name="0form_direccion" id="direccion" value="<?=$row[1]["direccion"]?>" class="form-control" />
				<br />
				
				<label>Director</label>
				<input type="text" name="0form_replegal" id="replegal" value="<?=$row[1]["replegal"]?>" class="form-control"  />
				<br />
				<label>Nro. RUC</label>
				<input type="text"  name="0form_ruc" id="nrodocumento" value="<?=$row[1]["ruc"]?>" class="form-control"  />
				<br />
				-->
				
				
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
    cargar_red("<?php $d=0;isset($row[1]["idejecutora"])?$d=$row[1]["idejecutora"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idred"])?$d=$row[1]["idred"]:$d=0; echo $d; ?>")
	cargar_microred("<?php $d=0;isset($row[1]["idred"])?$d=$row[1]["idred"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idmicrored"])?$d=$row[1]["idmicrored"]:$d=0; echo $d; ?>")

    cargar_datos_provinciaA("<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0; echo $d; ?>",2)    
    cargar_datos_distritoA("<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>",2)
     //<![CDATA[
  $(document).ready(function(){
      $('.combobox').combobox()
  });
  //]]>

</script>