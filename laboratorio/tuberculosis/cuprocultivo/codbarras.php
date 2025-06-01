<?php
    include("../../../objetos/class.conexion.php");

    $objconfig  = new conexion();

    $idingreso	=  $_POST["iding"];
    $deta_ing	=  $_POST["deta"];
    $op			=  $_POST["op"];
	
	if ($op==1){
		$queryT = "select idmuestradetalle, idingresomuestra, codbarra, idtipo_examen , idarea, idsubalimento 
		FROM muestra_det where  estareg=1 and idingresomuestra=".$idingreso." order by codbarra asc";
	}else {
		$queryT = "select idmuestradetalle, idingresomuestra, codbarra, idtipo_examen , idarea, idsubalimento 
					FROM muestra_det where  idingresomuestra=".$idingreso." and idmuestradetalle =".$deta_ing." ";	
	//	echo $queryT;
  	}
	$itemsT = $objconfig->execute_select($queryT,1);


?>
<select id="barras" name="barras" class="form-control" onchange="detCodBarra(this.value)"  placeholder="Seleccionar Codigo de Barra" data-toggle="tooltip" data-placement="top" title="Seleccionar Codigo de Barra">
	<option value="0"></option>
	<?php
			
	foreach($itemsT[1] as $rowT)
	{
		$selected="";
		if($rowT["idmuestradetalle"]==$deta_ing){$selected="selected='selected'";}
		echo "<option value='".$rowT["idmuestradetalle"]."|".$rowT["idingresomuestra"]."|".$rowT["idtipo_examen"]."' ".$selected." >".strtoupper($rowT["codbarra"] )."</option>";
	}
	?>
</select>
										
