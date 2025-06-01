<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
    $codemp         = $_POST["codi"];
	$idmicrored 	= $_POST["microred"];

    $onchange   = "onchange='cargar_estable(this.value,0)'";

    $queryT = "select * from microred where estareg=1 and idred= ".$codemp ;
    $itemsT = $objconfig->execute_select($queryT,1);

 ?>

<select id="idmicrored" name="0form_idmicrored" class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione Microred--</option>
    <?php
       
		foreach($itemsT[1] as $rowT)
		{
            $selected="";
            if($rowT["idmicrored"]==$idmicrored){$selected="selected='selected'";}
            echo "<option value='".$rowT["idmicrored"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
		}


    ?>
</select>

