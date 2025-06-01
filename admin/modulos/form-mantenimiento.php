<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$objconfig = new conexion();
	
    $op     = $_POST["op"];
    $cod    = $_POST["cod"];
	
    if($cod!=0)
    {
	$query = "select * from modulos where idmodulo=".$cod;
	// $query = "select * from perfiles where idperfil=".$cod;
	
	$row = $objconfig->execute_select($query);
    }
		
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento de Modulos</h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
				<label>Item</label>
				<input type="text" name="1form_idmodulo" id="idmodulo" value="<?=$row[1]["idmodulo"]?>" class="form-control"  />
				
				<br />
				<label>Descripcion</label>
				<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control" />
				<br />
				<label>Url</label>
				<input type="text"  name="0form_url" id="url" value="<?=$row[1]["url"]?>"  class="form-control"  />
				<br />
				<label>Menu Primcipal</label>
			  	<select id="idpadre_primario" name="0form_idpadre_primario" style="width:260px" class="form-control"  onchange="cambiar_modulos(this.value)" >
                   
                    <?php
					echo "<option value=0>--Seleccione Menu--</option>";

					$queryT = "select * from menu where estareg=1 order by descripcion asc ";
					$itemsT = $objconfig->execute_select($queryT,1);
					foreach($itemsT[1] as $rowT)
					{
					$selected="";
					if($rowT["idpadre_primario"]==$row[1]["idpadre_primario"]){$selected="selected='selected'";}
					echo "<option value='".$rowT["idpadre_primario"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
					
					} 
				
            echo " </select>";
					    ?>
				<br />
				<label>Sub Menu</label>
				<div id="div-padre"></div>
				<br />
				<label>Orden</label>
				<input type="text"  name="0form_orden" id="orden" value="<?=$row[1]["orden"]?>" class="form-control"  />
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
                <button type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" data-dismiss="modal" data-backdrop="false" > Guardar </button>
                <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>


            </div>
		</div>
	</form>

<script>
    cambiar_modulos("<?php $d=0;isset($row[1]["idpadre_primario"])?$d=$row[1]["idpadre_primario"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idpadre"])?$d=$row[1]["idpadre"]:$d=0; echo $d; ?>",1)
 
</script>