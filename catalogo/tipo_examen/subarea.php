<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();

    $idingreso =  $_POST["idarea"];
    $subarea =  $_POST["sub"];
	
  	$queryT = "select idareatrabajo, idarea, descripcion 
	FROM area_trabajo where idarea=".$idingreso."
	order by descripcion asc";

	$itemsT = $objconfig->execute_select($queryT,1);


?>
<select id="idareatrabajo" name="0form_idareatrabajo" class="form-control"  placeholder="Seleccionar SubArea" data-toggle="tooltip" data-placement="top" title="Seleccionar SubArea">
	<option value="0"></option>
	<?php
	
	foreach($itemsT[1] as $rowT)
	{
		$selected="";
		if($rowT["idareatrabajo"]==$subarea){$selected="selected='selected'";}
		echo "<option value='".$rowT["idareatrabajo"]."' ".$selected." >".strtoupper($rowT["descripcion"] )."</option>";
	}
	?>
</select>
										
