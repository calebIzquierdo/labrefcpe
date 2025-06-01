<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $idMicroRed =  $_POST["idMicroRed"];
    $idEst =  $_POST["idEst"];
    //echo  $idMicroRed."=".$idEst."\n";
    if($idMicroRed==""){
        echo "<option value=''>---</option>";
        return;
    }
    $queryT = "select idestablecimiento, descripcion 
											from establecimiento
											where idmicrored='".$idMicroRed."'
											order by descripcion asc";
    $itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <!-- <select id="idestablecimiento" name="0form_idestablecimiento" class="form-control"  > -->
        <option value=""> --- </option>
        <?php
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
            if($rowT["idestablecimiento"]==$idEst && $idEst!=0){$selected="selected='selected'";}
            echo "<option value='".$rowT["idestablecimiento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>
    <!-- </select> -->