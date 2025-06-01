    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    if(!isset($_POST["id"])){
        $id = 0;
    }else{
        $id = $_POST["id"];;
    }
     
    $idsub =  $_POST["idsub"];
	
    $queryT = "select idsubalimento, descripcion ,idalimento from sub_alimento where idalimento=".$id." order by descripcion asc";
    $itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <select id="idsubalimento" name="0form_idsubalimento" class="form-control"  >
        <option value=0></option>
        <?php
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
			if($rowT["idsubalimento"]==$idsub){$selected="selected='selected'";}
			echo "<option value='".$rowT["idsubalimento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>
    </select>
