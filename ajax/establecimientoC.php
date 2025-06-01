<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
    $idmicrored     = $_POST["microred"];
	
   
   // $onchange   = "onchange='cargar_areaB(this.value)'";
    $onchange   = "";
    $selected="";
    
    $queryT = "select * from establecimiento where estareg=1 and idmicrored= ".$idmicrored ;
        $itemsT = $objconfig->execute_select($queryT,1);

 ?>
<select id="idestablecimiento3" name="0form_idestablecimiento" class="form-control" <?php echo $onchange; ?> >
    <option value="0">-- P.S. --</option>
    <?php
       
		foreach($itemsT[1] as $rowT)
		{
            $selected="";
            if($rowT["idestablecimiento"]==$estable){$selected="selected='selected'";}
            echo "<option value='".$rowT["idestablecimiento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
		}

    ?>
</select>

