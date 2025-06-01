<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
        
        $idpadre    = isset($_POST["idpadre"])?$_POST["idpadre"]:0;
		 $seleccion  = $_POST["seleccion"];
		
?>
<select id="idpadre" name="0form_idpadre" style="width:260px" class="form-control" >
    <option value="0">--Seleccione SubMenu--</option>
    <?php
	if ($seleccion !=0){
        $queryT = "select descripcion from modulos where idpadre_primario=".$idpadre."and idmodulo=".$seleccion." order by descripcion asc" ;
        $itemsT = $objconfig->execute_select($queryT,1);

        foreach($itemsT[1] as $rowT)
        {
               $selected="";
				if($rowT["idmodulo"]==$row[1]["idmodulo"]){$selected="selected='selected'";}
				echo "<option value='".$rowT["idmodulo"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
	}
	else {
		$queryT = "select idmodulo,descripcion, idpadre from modulos where idpadre_primario=".$idpadre." order by descripcion asc";
        $itemsT = $objconfig->execute_select($queryT,1);

        foreach($itemsT[1] as $rowT)
        {
               $selected=0;
				if($rowT["idmodulo"]==$row[1]["idmodulo"]){$selected="selected='selected'";}
				echo "<option value='".$rowT["idmodulo"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
	}
    ?>
</select>