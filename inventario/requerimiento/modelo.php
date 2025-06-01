<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $id =  $_POST["idmarca"];
  //  $idmod =  $_POST["idmodelo"];
	
    $queryT = "select idmodelo, descripcion ,idmarca
											from modelo
											where idmarca=".$id."
											order by descripcion asc";
    $itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <select id="modelo" name="modelo" class="form-control"  >
        <option value=0></option>
        <?php
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
		//	if($rowT["idmodelo"]==$idmod){$selected="selected='selected'";}
			echo "<option value='".$rowT["idmodelo"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>
    </select>