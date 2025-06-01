<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $idRed =  $_POST["idRed"];
    $idMicroRed =  $_POST["idMicroRed"];
    $idUnidadEjec =  $_POST["idUnidadEjec"];
    if($idRed==""){
        echo "<option value=''>---</option>";
        return;
    }
    $queryT = "select idmicrored, descripcion 
											from microred
											where idejecutora='".$idUnidadEjec."'
                                            AND idRed='".$idRed."'
											order by descripcion asc";
    $itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <!-- <select id="idmicrored" name="0form_idmicrored" class="form-control"  > -->
        <option value="">---</option>
        <?php
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
            if($rowT["idmicrored"]==$idMicroRed && $idMicroRed!=0){$selected="selected='selected'";}
            echo "<option value='".$rowT["idmicrored"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>
    <!-- </select> -->