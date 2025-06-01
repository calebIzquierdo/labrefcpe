    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $micro =  $_POST["idpa"];
    $estable =  $_POST["esta"];

    $queryT = "select idestablecimiento, descripcion 
											from establecimiento
											where idmicrored=".$micro."
											order by descripcion asc";
    $itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <select id="idestablecimiento" name="0form_idestablecimiento" class="form-control"  >
        <option value=""> Establecimiento</option>
        <?php
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
            if($rowT["idestablecimiento"]==$estable){$selected="selected='selected'";}
            echo "<option value='".$rowT["idestablecimiento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>
    </select>