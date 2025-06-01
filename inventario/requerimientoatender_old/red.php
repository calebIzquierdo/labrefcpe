<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $idue =  $_POST["idue"];
    $idred =  $_POST["idred"];
    //echo $idue." - ".$idred;
    //exit();

    $queryT = "select idred, descripcion 
											from red
											where idejecutora='".$idue."'
											order by descripcion asc";
    $itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <!-- <select id="idred" name="0form_idred" class="form-control"  onchange="MicrooRed(this.value,<?php //echo $_POST["idue"];?>, <?php //echo idorg_micro; ?>)"> -->
        <option value="">---</option>
        <?php
        foreach($itemsT[1] as $rowT)
        {
            //echo "\n".$rowT["idred"]."===".$idred."\n";
            $selected="";
            if($rowT["idred"]==$idred && $idred!=0){$selected="selected='selected'";}
            echo "<option value='".$rowT["idred"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>
   <!--  </select> -->