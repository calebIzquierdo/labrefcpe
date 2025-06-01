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
				<input type="text" name="nombre_modelo" style="display:none" id="nombre_modelo" value="0" <?php echo $readonly;?>   class="form-control"/>
				<input type="text" name="modelo" style="display:none" id="modelo" value="0" <?php echo $readonly;?>   class="form-control"/>

    <select  class="form-control" onchange="cargar_modelo(this.value);" required>

        <option value=""></option>
        <?php
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
		//	if($rowT["idmodelo"]==$idmod){$selected="selected='selected'";}
			echo "<option value='".$rowT["idmodelo"]."-".$rowT["descripcion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>
    </select>