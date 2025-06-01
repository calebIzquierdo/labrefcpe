<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from tipo_prueba where idtipoprueba=".$cod;
		$row = $objconfig->execute_select($query);
	}
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento de Tiepo Pruebas </h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
				<label>Item</label>
				<input type="text" name="1form_idtipoprueba" id="codigo" value="<?=$row[1]["idtipoprueba"]?>" readonly class="form-control"  />
				<br />
				<label>Unidad</label>
                <select id="idtipo_examen" name="0form_idtipo_examen" class="form-control" onchange="cargar_subarea(this.value,<?=$row[1]["idtipo_examentrabajo"]?>)" >
                    <option value="0"></option>
                    <?php
                    $queryT = "select idtipo_examen, descripcion from tipo_examen where estareg=1 order by descripcion asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        if($rowT["idtipo_examen"]==$row[1]["idtipo_examen"]){$selected="selected='selected'";}
                        echo "<option value='".$rowT["idtipo_examen"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
                </select>
                <br />
				<label>Descripcion</label>
				<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control"  />
				<br />
				<label for="atencion" class="control-label">Referencia Adultos:</label>
				<br />
				<textarea name="0form_referencia" id="referencia" class="form-control " rows="2" cols="70"><?php echo $row[1]["referencia"]; ?></textarea>
				<br />
				<label for="atencion" class="control-label">Referencia Niños:</label>
				<br />
				<textarea name="0form_referencia_ninos" id="referencia_ninos" class="form-control " rows="2" cols="70"><?php echo $row[1]["referencia_ninos"]; ?></textarea>
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
		
			</div>
			<div class="modal-footer">

				<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" value="Agregar" />
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

			</div>
		</div>
	</form>
	
	
<script type="text/javascript">
    cargar_subarea(<?php echo $row[1]["idtipo_examen"];?>,<?php echo $row[1]["idtipo_examentrabajo"];?>)
    
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