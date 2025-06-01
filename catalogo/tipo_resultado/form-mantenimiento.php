<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from tipo_resultado where idresultado=".$cod;
		$row = $objconfig->execute_select($query);
	}
?>


<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times; </button>
                <h4 class="modal-title">Mantimiento Tipo Resultado</h4>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
            </div>
            <div class="modal-body">

                <label>Codigo</label>
                <input type="text" name="1form_idresultado" id="codigo" value="<?=$row[1]["idresultado"]?>" class="form-control" readonly/>
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
                <br />
               
            </div>
            <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
			<div class="modal-footer">
				<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Agregar" />
				<button type="button" class="btn btn-default" onclick="regresar_index(carpeta)" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>


