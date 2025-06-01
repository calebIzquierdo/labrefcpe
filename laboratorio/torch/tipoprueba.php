<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();

    $op	=  $_POST["op"];
    $tipate	=  $_POST["idtpate"];
    $idtor	=  $_POST["idtor"];
   
	if($op==1){
		$queryTa = "select p.idtipoprueba, p.idtipo_examen, p.descripcion as prue, te.descripcion as tpex 
		from tipo_prueba as p
		inner join tipo_examen as te on(te.idtipo_examen= p.idtipo_examen)
		where p.estareg=1 and p.idtipo_examen in (select idtipo_examen from muestra_det where idingresomuestra=".$tipate." ) order by tpex asc ";
	
		$itemsT = $objconfig->execute_select($queryTa,1);
	
	}
	else{
		$queryTa = "select p.idtipoprueba, p.idtipo_examen, p.descripcion as prue, te.descripcion as tpex 
		from tipo_prueba as p
		inner join tipo_examen as te on(te.idtipo_examen= p.idtipo_examen)
		where p.estareg=1 and p.idtipo_examen in (select idtipo_examen from muestra_det where idingresomuestra=".$idtor." ) order by tpex asc ";
  		$itemsT = $objconfig->execute_select($queryTa,1);	
	}
	

?>


 <select id="tipoprueba" name="tipoprueba" class="combobox form-control" placeholder="Tipo de Prueba" data-toggle="tooltip" data-placement="top" title="Tipo de Prueba" >
		<option value="0"></option>
		<?php
		
		$itemsTA = $objconfig->execute_select($queryTa,1);

		foreach($itemsTA[1] as $rowTA)
		{
			$selected="";
			echo "<option value='".$rowTA["idtipoprueba"]."' ".$selected." >".strtoupper($rowTA["prue"]." / ".$rowTA["tpex"])."</option>";
		}
		?>
	</select>