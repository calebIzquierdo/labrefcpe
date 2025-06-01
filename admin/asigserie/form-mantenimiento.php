<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	/* if($cod!=0)
	{
		$query = "select * from personal P inner join seriedoc_personal SDP on P.idpersonal=SDP.idpersonal where idpersonal=".explode("-",$cod)[0];
		$row = $objconfig->execute_select($query);
	} */

		
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Asignación de serie</h4>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
			</div>
			<div class="modal-body">
							<label class="control-label">Usuario:</label>
				            <select id="idusuario" name="0form_idusuario"  class="form-control">
                  	        <option value="0">--Seleccionar--</option>
                            <?php
                                $queryT = "select idusuario, nombres from usuarios where  estareg=1 order by nombres asc";
                                $itemsT = $objconfig->execute_select($queryT,1);

                                foreach($itemsT[1] as $rowT)
                                {
                                    $selected="";
									if($op==2){
										if($rowT["idusuario"]==explode("-",$cod)[0]){$selected="selected='selected'";}
									}
                                    echo "<option value='".$rowT["idusuario"]."' ".$selected." >".strtoupper($rowT["nombres"])."</option>";
                                }
                            ?>
                      	 	</select>
							   <br/>
                            <label class="control-label">Comprobante:</label>
				            <select id="idcomprobante" name="0form_idcomprobante" onchange="changeComprobante()" class="form-control">
								<option value="0">--Seleccionar--</option>
								<?php
									$queryT = "select idcomprobante, descripcion from tipo_comprobante where estareg=1;";
									$itemsT = $objconfig->execute_select($queryT,1);

									foreach($itemsT[1] as $rowT)
									{
										$selected="";
										if($op==2){
											if($rowT["idcomprobante"]==explode("-",$cod)[1]){$selected="selected='selected'";}
										}
										echo "<option value='".$rowT["idcomprobante"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
									}
								?>
                      	 	</select>
			<br/>
                            <label class="control-label">Serie:</label>
				            <select id="idserie" name="0form_idserie"  class="form-control">
                  	        <option value="0">--Seleccionar--</option>
                            <?php
                                $queryT = "select idseriedoc, seriedoc from seriedoc where idtipocomprobante='".explode("-",$cod)[1]."' and estado;";
                                $itemsT = $objconfig->execute_select($queryT,1);

                                foreach($itemsT[1] as $rowT)
                                {
									if($op==2){
                                    $selected="";
										if($rowT["idseriedoc"]==explode("-",$cod)[2]){$selected="selected='selected'";}
										echo "<option value='".$rowT["idseriedoc"]."' ".$selected." >".strtoupper($rowT["seriedoc"])."</option>";
									}
								}
                            ?>
                      	 	</select>
				<input type="hidden" name="op" id="op" value="<?php echo $op;?>"  />
				<input type="hidden" name="ult_idserie" id="ult_idserie" value="<?php echo explode("-",$cod)[2];?>"  />
				<input type="hidden" name="ult_idusuario" id="ult_idusuario" value="<?php echo explode("-",$cod)[0];?>"  />
				<br />
				<!--
				<label>Adjuntar</label>
				<input type="file" name="user_image" id="user_image" />
				<span id="user_uploaded_image"></span> 
				-->
                <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
			</div>
			<div class="modal-footer">
		<!--	<input type="hidden" name="user_id" id="user_id" />
				<input type="hidden" name="operation" id="operation" /> -->
                <button type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"> Guardar </button>
                <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>


            </div>
		</div>
	</form>

<script>
      
  //  cargar_datos_sectoresA("<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>","<?php $d=0;isset($row[1]["idsector"])?$d=$row[1]["idsector"]:$d=0; echo $d; ?>",2)

</script>