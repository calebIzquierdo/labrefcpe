<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
	$idcomprobante 	= $_POST["idcomprobante"];
	
	$consult = "select * from comprobantes where idcomprobante=".$idcomprobante ;
	$itemsT = $objconfig->execute_select($consult);
	$correlativo = ($itemsT[1]["serie"]."-".substr("000000".$itemsT[1]["correlativo"],strlen("000000".$itemsT[1]["correlativo"]) - 6));

 ?>
</br>
<label for="atencion" class="col-md-2 control-label">SERIE:  </label>
	<input type="hidden" name="0form_correlativo" id="correlativo" readonly="readonly" value='<?php echo $correlativo; ?>'  />
	<div class="input-group date form_date col-md-8" >	
		<input type="text" name="series" id="series" readonly="readonly" value='<?php echo $itemsT[1]["serie"]; ?>' class="col-md-2 control2"  />
		<label for="atencion" class="col-md-3 control-label">Número:  </label> 
		<input type="text" name="numero" id="numero" readonly="readonly" value='<?php echo substr("000000".$itemsT[1]["correlativo"],strlen("000000".$itemsT[1]["correlativo"]) - 6); ?>' class="col-md-4 control2" />
	</div>