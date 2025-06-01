<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from area_trabajo where idareatrabajo=".$cod;
		$row = $objconfig->execute_select($query);
	}
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content modal-lg">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title text-center">Mantimiento de Áreas de Servicio por Ejecutoras </h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
				<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">	<label>Codigo</label></div>
                    <div class="col-md-1">  <input type="text"  name="1form_idareatrabajo" id="codigo" value="<?=$row[1]["idareatrabajo"]?>" class="form-control" readonly   />
					</div>
				
				<div class="col-md-1">	<label>Unidad Ejecutora</label></div>
				<div class="col-md-8">  
				<select id="idejecutora" name="0form_idejecutora" class="combobox form-control" onchange="cargar_red(this.value,<?php echo $row[1]["idred"]; ?>)">  
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
				</div>
				</div>
			</div>		
			<br />
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2"><label>Red Salud</label></div>
                    <div class="col-md-4">   <div id="div-red" > </div> </div>
				
				<div class="col-md-1">	<label>Micro Red</label></div>
				<div class="col-md-5">  
				<div id="div-microred" > </div> </div>
				</div>
			</div>		
			<br />
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">	<label>Establecimiento</label></div>
				<div class="col-md-10">  
				<div id="div-establecimiento" > </div> </div>
				</div>
			</div>
		    <br />
			<div class="row">
			<div class="col-md-12">
			<div class="col-md-2">	<label>Unidad</label></div>
			<div class="col-md-10">  
                <select id="idarea" name="0form_idarea" class="form-control" >
                    <option value="0"></option>
                    <?php
                    $queryT = "select idarea, descripcion from areas where estareg=1 order by descripcion asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        if($rowT["idarea"]==$row[1]["idarea"]){$selected="selected='selected'";}
                        echo "<option value='".$rowT["idarea"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
                </select>
            </div>
			</div>
			</div>
			 <br />
				 
			<div class="row">
			<div class="col-md-12">
				<div class="col-md-2"><label>Descripción</label></div>
                    <div class="col-md-7">   
					<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control"  />
					</div>
				
				<div class="col-md-1">	<label>Estado</label></div>
				<div class="col-md-2">  
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
								
				<input type="hidden" name="0form_estareg" id="estareg" value="<?=$estareg?>"  /></div>
				</div>
			</div>	
			
	
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
	
	
<script type="text/javascript">
	cargar_red("<?php $d=0;isset($row[1]["idejecutora"])?$d=$row[1]["idejecutora"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idred"])?$d=$row[1]["idred"]:$d=0; echo $d; ?>")
    cargar_microred("<?php $d=0;isset($row[1]["idred"])?$d=$row[1]["idred"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idmicrored"])?$d=$row[1]["idmicrored"]:$d=0; echo $d; ?>")
    cargar_estable("<?php $d=0;isset($row[1]["idmicrored"])?$d=$row[1]["idmicrored"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idestablecimiento"])?$d=$row[1]["idestablecimiento"]:$d=0; echo $d; ?>")
	
	//<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>
	
</script>