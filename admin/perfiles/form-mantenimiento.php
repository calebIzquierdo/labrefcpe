<?php
    include("../../objetos/class.conexion.php");
	
    $objconfig = new conexion();
	
    $op     = $_POST["op"];
    $cod    = $_POST["cod"];
	
    if($cod!=0)
    {
	$query = "select * from perfiles where idperfil=".$cod;
	$row = $objconfig->execute_select($query);
    }
?>
<<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times; </button>
                <h4 class="modal-title">Mantimiento de Perfiles</h4>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
            </div>

        <div class="modal-body">
                <label>Código</label>
                <input type="text" name="1form_idperfil" id="codigo" value="<?=$row[1]["idperfil"]?>"   class="form-control"  />
                <br />
                 <label>Descripcion</label>
                <input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>"   class="form-control"  />
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
        <!--        <input type="hidden" name="user_id" id="user_id" />
                <input type="hidden" name="operation" id="operation" /> -->
                <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" value="Agregar" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </form>




