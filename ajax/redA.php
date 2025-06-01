<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
    $codemp     = $_POST["codi"];
	$idred 	= $_POST["red"];

    $onchange   = "onchange='cargar_microred(this.value)'";

    $queryT = "select * from red where estareg=1 ";
    $itemsT = $objconfig->execute_select($queryT,1);

 ?>

<select id="idred" name="0form_idred" class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione Microred--</option>
    <?php
       
		foreach($itemsT[1] as $rowT)
		{
            $selected="";
            if($rowT["idred"]==$idred){$selected="selected='selected'";}
            echo "<option value='".$rowT["idred"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
		}


    ?>
</select>

