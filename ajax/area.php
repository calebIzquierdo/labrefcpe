<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
    $idstableciimiento         = $_POST["idestable"];


    $onchange   = "onchange='cargar_subarea(this.value)'";

    $queryT = "select * from areas where idestablecimiento= ".$idstableciimiento ;
    $itemsT = $objconfig->execute_select($queryT,1);

 ?>

<select id="idarea" name="0form_idarea" class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione Area--</option>
    <?php
       
		foreach($itemsT[1] as $rowT)
		{
            $selected="";
            if($rowT["idarea"]==$idmicrored){$selected="selected='selected'";}
            echo "<option value='".$rowT["idarea"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
		}


    ?>
</select>

