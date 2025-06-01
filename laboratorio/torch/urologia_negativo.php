<?php
	include("../../objetos/class.conexion.php");

	$objconfig = new conexion();

	$nrodoc = $_POST["nroref"];

	$nref = trim($_POST["nroref"]);

	$query = "select count(nrocontra) as cant FROM contrareferencia WHERE nrocontra='".$nref."'" ;
	$row = $objconfig->execute_select($query);

	
?>
	
	<div class="col-md-3">
		<label for="atencion" class="control-label">Observación:</label>
	</div>
	<div class="col-md-9">
		<textarea name="0form_observaciones" id="observaciones" rows="2" cols="70"><?php echo $row[1]["codbarra"]; ?></textarea>
	</div>
	</br>
	<!--
	<div class="row">
		<div class="col-md-12" >
			<div class="col-md-2">
				<label>Fecha Rec Lab.</label>
			</div>
			<div class="col-md-3">
				<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
					<input class="form-control" type="text" name="0form_fecharecepcion" id="fecharecepcion" value="<?php echo ($row[1]["fecharecepcion"])?$objconfig->FechaDMY2($row[1]["fecharecepcion"]):date("d/m/Y");?>"  <?php echo $readonly; ?> >
				 <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			   
				</div>
			</div>
		</div>
	</div>
-->
