<?php
    include("../../objetos/class.conexion.php");
	
    $objconfig = new conexion();
	
    $op     = $_POST["op"];
    $cod    = $_POST["cod"];
	
    if($cod!=0)
    {
	$query = "select * from usuarios where idusuario=".$cod;
	$row = $objconfig->execute_select($query);
    }
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" onclick="regresar_index(carpeta);" class="close" data-dismiss="modal">&times; </button>
                <h4 class="modal-title">Mantimiento de Usuario</h4>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
            </div>
            <div class="modal-body">
			
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">	<label>Codigo</label></div>
                    <div class="col-md-1">  <input type="text"  name="1form_idusuario" id="codigo" value="<?=$row[1]["idusuario"]?>" class="form-control" readonly   />
					</div>
				
				<div class="col-md-1">	<label>Unidad Ejecutora</label></div>
				<div class="col-md-8">  
				<select id="idejecutora" name="0form_idejecutora" class="col-md-2 form-control" onchange="cargar_red(this.value,<?php echo $row[1]["idred"]; ?>)">  
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
				<div class="col-md-2">	<label>Nombres</label></div>
				<div class="col-md-6">  <input type="text"  name="0form_nombres" id="nombres" value="<?=$row[1]["nombres"]?>" class="form-control"    /> </div> 
				<div class="col-md-1">	<label>Usuario</label></div>
				<div class="col-md-3">  <input type="text"  name="0form_login" id="login" value="<?=$row[1]["login"]?>" class="form-control" style="text-transform: uppercase;"    /> </div> 
				
				</div>
			</div>
            <br />
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">	<label>Perfil Usuario</label></div>
				<div class="col-md-4">  <select id="idperfil" name="0form_idperfil"  class="form-control">
                    <option value="0">--Seleccione Nivel --</option>
                    <?php
                        $queryT = "select * from perfiles";
                        $itemsT = $objconfig->execute_select($queryT,1);
                        
                        foreach($itemsT[1] as $rowT)
                        {
                            $selected="";
                            if($rowT["idperfil"]==$row[1]["idperfil"]){$selected="selected='selected'";}
                            echo "<option value='".$rowT["idperfil"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                        }
                    ?>
                </select>
				</div> 
				<div class="col-md-2">	<label>Tipo Reporte</label></div>
				<div class="col-md-4">  <select id="idnivelreporte" name="0form_idnivelreporte"  class="form-control">
                    <option value="0"></option>
                    <?php
                        $queryT = "select idnivelreporte, descripcion from nivel_reporte where estareg=1";
                        $itemsT = $objconfig->execute_select($queryT,1);
                        
                        foreach($itemsT[1] as $rowT)
                        {
                            $selected="";
                            if($rowT["idnivelreporte"]==$row[1]["idnivelreporte"]){$selected="selected='selected'";}
                            echo "<option value='".$rowT["idnivelreporte"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                        }
                    ?>
                    
                </select>
				</div> 
				
				</div>
			</div>
            <br />
			<!--
            <div class="row">
				<div class="col-md-12">
							
				<div class="col-md-2">	<label>Servicio</label></div>
				<div class="col-md-4">  
				<select id="idservicio" name="0form_idservicio"  class="form-control" onchange="tipserv(this.value)">
                  	<option value="0"></option>
                   	<?php
							   
						/* $queryT = "select idservicio,descripcion from servicio ";
						$itemsT = $objconfig->execute_select($queryT,1);
										
						foreach($itemsT[1] as $rowT)
						{
		                    $selected="";
		                    if($rowT["idservicio"]==$row[1]["idservicio"]){$selected="selected='selected'";}
		                    echo "<option value='".$rowT["idservicio"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						} */
                    ?>
				</select>
				</div> 
				<div class="col-md-2">	<label>Especialiad</label></div>
				<div class="col-md-4">  <div id="div-estable" name="div-estable"> </div> </div> 

				</div>
			</div>   
            <br />
			-->
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">	<label>Mostrar Vencimiento</label></div>
				<div class="col-md-2">  
				<select id="idvencimiento" name="0form_idvencimiento"  class="form-control" >
					<?php
	                   $queryT = "select idcondicion,descripcion from tipo_condicion where estareg=1 and idcondicion in (1,2)  ";
						$itemsT = $objconfig->execute_select($queryT,1);
										
						foreach($itemsT[1] as $rowT)
						{
		                    $selected="";
		                    if($rowT["idcondicion"]==$row[1]["idvencimiento"]){$selected="selected='selected'";}
		                    echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						}
					?>
						
				</select>
				</div> 
				<div class="col-md-2">	<label>Modificar</label></div>
				<div class="col-md-2">  
				<select id="editar" name="0form_editar"  class="form-control" >
					<?php
	                   $queryT = "select idcondicion,descripcion from tipo_condicion where estareg=1 and idcondicion in (1,2)  ";
						$itemsT = $objconfig->execute_select($queryT,1);
										
						foreach($itemsT[1] as $rowT)
						{
		                    $selected="";
		                    if($rowT["idcondicion"]==$row[1]["editar"]){$selected="selected='selected'";}
		                    echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						}
					?>
						
				</select>
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
                                
                <input type="hidden" name="0form_estareg" id="estareg" value="<?=$estareg?>"  />
                <input type="hidden" name="op" id="op" value="<?php echo $op;?>"  />
				</div> 
				</div>
			</div>
                           
            <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->

			<div class="modal-footer">
        <!--        <input type="hidden" name="user_id" id="user_id" />
                <input type="hidden" name="operation" id="operation" /> -->
                <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" value="Agregar" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </form>

<script>
	 //<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>

    cargar_red("<?php $d=0;isset($row[1]["idejecutora"])?$d=$row[1]["idejecutora"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idred"])?$d=$row[1]["idred"]:$d=0; echo $d; ?>")
    cargar_microred("<?php $d=0;isset($row[1]["idred"])?$d=$row[1]["idred"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idmicrored"])?$d=$row[1]["idmicrored"]:$d=0; echo $d; ?>")
    cargar_estable("<?php $d=0;isset($row[1]["idmicrored"])?$d=$row[1]["idmicrored"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idestablecimiento"])?$d=$row[1]["idestablecimiento"]:$d=0; echo $d; ?>")
	tipserv(<?php echo $row[1]["idservicio"]; ?>)
</script>