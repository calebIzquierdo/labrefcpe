<?php
    include("../../../objetos/class.conexion.php");

    $objconfig  = new conexion();

    $op	=  $_POST["op"];
    $tipate	=  $_POST["idtpate"];
    $idtor	=  $_POST["idtor"];
   
	if($op==1){
  	$idmuestra = $objconfig->execute_select("select idtipoatencion FROM muestra where idingresomuestra=".$tipate);
	$muestra = $idmuestra[1]["idtipoatencion"];
	}
	else{
	$idmuestra = $objconfig->execute_select("select idtipoatencion FROM torch where idtorch=".$idtor);
	$muestra =	$idmuestra[1]["idtipoatencion"];
  			
	}
	
	$queryT = "select idtipoatencion, descripcion FROM tipo_atencion where estareg=1  order by descripcion asc";
	$itemsT = $objconfig->execute_select($queryT,1);

?>
<select id="idtipoatencion" name="0form_idtipoatencion" class="form-control"  placeholder="Seleccionar Convenio" data-toggle="tooltip" data-placement="top" title="Seleccionar Convenio">
	<option value="0"></option>
	<?php
	
	foreach($itemsT[1] as $rowT)
	{
		$selected="";
		if($rowT["idtipoatencion"]==$muestra){$selected="selected='selected'";}
		echo "<option value='".$rowT["idtipoatencion"]."' ".$selected." >".strtoupper($rowT["descripcion"] )."</option>";
	}
	?>
</select>
