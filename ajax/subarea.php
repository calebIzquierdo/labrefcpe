<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
    $codemp         = $_POST["idarea"];
	
    $onchange   = "";

    $queryT = "select * from area_trabajo where idarea= ".$codemp ;
    $itemsT = $objconfig->execute_select($queryT,1);

 ?>

<select id="idareatrabajo" name="0form_idareatrabajo" class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione Sub Area--</option>
    <?php
       
		foreach($itemsT[1] as $rowT)
		{
            $selected="";
            if($rowT["idareatrabajo"]==$idmicrored){$selected="selected='selected'";}
            echo "<option value='".$rowT["idareatrabajo"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
		}


    ?>
</select>

