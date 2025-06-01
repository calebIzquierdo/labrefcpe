<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	$idusuario = explode("|",$_SESSION['nombre']);
	$iduser = $idusuario[0];
	
	
	if($cod!=0)
	{
		$query = "select * from vista_labmalaria where idlaboratorio=".$cod;
		$row = $objconfig->execute_select($query);
		
		$establecimiento =$row[1]["codrenae"]." - ".$row[1]["labmalaria"];
	}
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantimiento de Laboratorio - Malaria </h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
				<input type="hidden" name="1form_idlaboratorio" id="codigo" value="<?=$row[1]["idlaboratorio"]?>" readonly class="form-control"  />
			</div>
			<div class="modal-body">
			<div class="row">
			<div class="col-md-12">
			<div class="col-md-2">
				<label>Ejecutora</label>
			</div>
			<div class="col-md-10">
                <select id="idejecutora" name="0form_idejecutora" class="combobox form-control" onchange="cargar_red(this.value,<?php echo $row[1]["idred"]; ?>)"> >
                    <option value="0"> -- </option>
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
			<br/>
			<div class="row">
			<div class="col-md-12">
				<div class="col-md-2">
					<label>Red</label>
				</div>
                <div id="div-red" class="col-md-5" > </div>
				<div class="col-md-1" >
                <label>Micro</label>
				</div>
                <div id="div-microred" class="col-md-4" > </div>
				</div>
			</div>
			<br />
			<div class="row">
			<div class="col-md-12">
				<div class="col-md-2">
					<label>Laboratorio</label>
				</div>
				<div class="col-md-10">
					<input type="hidden" id="laboratorio" name="laboratorio" value=""  />
					<input type="hidden" id="codrenae" name="0form_codrenae" value="<?php echo $row[1]["codrenae"];?>"  />
					<input type="hidden" id="idlabmalaria" name="0form_idlabmalaria" value="<?=$row[1]["idlabmalaria"]?>"  />
					<input for="atencion" type="text" name="nombre_laboratorio" id="nombre_laboratorio"  readonly="readonly" onclick="buscar_establecimiento();" value="<?php echo $establecimiento;?>" placeholder="Click para seleccionar Establecimiento" class=" form-control" />
				</div>
				</div>
			</div>
			<br />
		   <div class="row">
			<div class="col-md-12">
			<div class="col-md-2">
				<label>Lab Interm</label>
			</div>
			<div class="col-md-6">
                <select id="idintermedio" name="0form_idintermedio" class=" form-control"  >
                    <option value="0"></option>
                    <?php
                    $queryT = "select idintermedio, descripcion from lab_intermedio where estareg=1 order by descripcion";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        if($rowT["idintermedio"]==$row[1]["idintermedio"]){$selected="selected='selected'";}
                        echo "<option value='".$rowT["idintermedio"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
                </select>
				</div>
				<div class="col-md-1">
					<label>COD LAB:</label>
				</div>
				<div class="col-md-3">
					<input type="text" id="codlab" name="0form_codlab" value="<?php echo $row[1]["codlab"];?>" class="form-control"  />
				</div>
				
			</div>
			</div>
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
    cargar_red("<?php $d=0;isset($row[1]["idejecutora"])?$d=$row[1]["idejecutora"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idred"])?$d=$row[1]["idred"]:$d=0; echo $d; ?>")
	cargar_microred("<?php $d=0;isset($row[1]["idred"])?$d=$row[1]["idred"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idmicrored"])?$d=$row[1]["idmicrored"]:$d=0; echo $d; ?>")

    //<![CDATA[
  $(document).ready(function(){
      $('.combobox').combobox()
  });
  //]]>
</script>