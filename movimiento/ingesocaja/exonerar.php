<?php
    include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	
?>

<div class="row">
						<div class="col-sm-12">
						<div class="col-md-1">
						<label for="atencion" class="control-label text-right">Motivo :  </label>
						</div>
						<div class="col-md-3">
						<select id="idtipo_exonera" name="0form_idtipo_exonera" class="form-control"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idtipo_exonera, descripcion from tipo_exoneracion where estareg=1 order by descripcion asc";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["idtipo_exonera"]==$row[1]["idtipo_exonera"]){$selected="selected='selected'";}
							echo "<option value='".$rowT["idtipo_exonera"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

						}
						?>
						</select>
						</div>
						<div class="col-md-1">
						<label for="atencion" class="control-label text-right">Autorizada:  </label>
						</div>
						<div class="col-md-7">
						<select id="idpersonal" name="0form_idpersonal" class="form-control"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idpersonal, nrodocumento, apellidos||'; '|| nombres as autoriza  from personal where estareg=1 order by nrodocumento desc";
							$itemsT = $objconfig->execute_select($queryT,1);

							foreach($itemsT[1] as $rowT)
							{
								$selected="";
							//	if($rowT["idpersonal"]==$row[1]["idpersonal"]){$selected="selected='selected'";}
								echo "<option value='".$rowT["idpersonal"]."' ".$selected." >".strtoupper($rowT["nrodocumento"]." / ".$rowT["autoriza"])."</option>";

							}
						?>
						</select>
						</div>
					
						
						</div>
						</div>
						
						</br>
			
