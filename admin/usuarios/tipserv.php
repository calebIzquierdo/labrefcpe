<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();

	$cod = $_POST["cod"];
    $idtipse =  $_POST["idtipse"];
      
	$query = "select * from usuarios where idusuario=".$cod;
	$row = $objconfig->execute_select($query);
   
?>
<select id="idtiposervicio" name="0form_idtiposervicio"  class="form-control" >
	<option value="0">--Seleccione--</option>
	<?php
			   
		$queryT = "SELECT idtiposervicio, serv ||' - '||descripcion as tipsev FROM vista_tiposervicio WHERE idservicio=".$idtipse ;
		$itemsT = $objconfig->execute_select($queryT,1);
						
		foreach($itemsT[1] as $rowT)
		{
			$selected="";
			if($rowT["idtiposervicio"]==$row[1]["idtiposervicio"]){$selected="selected='selected'";}
			echo "<option value='".$rowT["idtiposervicio"]."' ".$selected." >".strtoupper($rowT["tipsev"])."</option>";
		}
	?>
</select>
				
