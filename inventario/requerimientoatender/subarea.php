<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $idArea =  $_POST["idArea"];
    $idsarea = $_POST["idsarea"];
	
	  $queryT = "select idareatrabajo,descripcion 
      from area_trabajo where idarea=".$idArea." and estareg=1";
				
	$itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <option value=""> --- Seleccionar Area de Trabajo ---</option>
        <?php
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
            if($rowT["idareatrabajo"]==$idsarea && $idsarea!=0){$selected="selected='selected'";}
           echo "<option value='".$rowT["idareatrabajo"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>