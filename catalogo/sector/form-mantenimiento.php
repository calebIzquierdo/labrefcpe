<?php
	include("../../objetos/class.conexion.php");

	$objconfig = new conexion();

	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];

	if($cod!=0)
	{
		$query = "select * from sector where idsector=".$cod;
		$row = $objconfig->execute_select($query);
	}
	else {$query = "select max(idsector)+1 as codubigeo from sector";
		$row = $objconfig->execute_select($query);}
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times; </button>
                <h4 class="modal-title">Mantimiento de Barrios</h4>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
            </div>
            <div class="modal-body">

                <label>Item</label>
                <input type="text" name="1form_idsector" id="idsector" value="<?=$row[1]["idsector"]?>" class="form-control" />
                <br />

				<label>Codigo Ubigeo</label>
                <input type="text"  name="0form_codubigeo" id="codubigeo" value="<?=$row[1]["codubigeo"]?>" class="form-control" />
                <br />

                <label>Pais</label>
                <select id="pais" name="0form_idpais" class="form-control" onchange="cargar_datos_departamento(this.value,0,1)" >
					<option value="0">--Seleccione el Pais--</option>
					<?php
						$queryT = "select * from pais where estareg=1";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["idpais"]==$row[1]["idpais"]){$selected="selected='selected'";}
							echo "<option value='".$rowT["idpais"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						}
					?>
				</select>
				<br/>

				<label>Departamento</label>
                <div id="div-departamento"></div>
                <br />

                <label>Provincia</label>
                <div id="div-provincia"></div>
                <br />

                <label>Distrito</label>
                <div id="div-distrito"></div>
                <br />

                <label>Descripcion</label>
                <input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control" />
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
				<div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
				</div>
				<div class="modal-footer">
				<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Agregar" />
				<button type="button" class="btn btn-default" onclick="regresar_index(carpeta)" data-dismiss="modal">Cerrar</button>
				</div>
        </div>
    </form>

<script>
    cargar_datos_departamento("<?php $d=0;isset($row[1]["idpais"])?$d=$row[1]["idpais"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0; echo $d; ?>",1)
    cargar_datos_provincia("<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0; echo $d; ?>",1)
    cargar_datos_distrito("<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>",1)
</script>
