    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $id =  $_POST["idarea"];
    $sub =  $_POST["idsub"];

	$queryT = " select s.idareatrabajo, s.idarea, s.descripcion as subarea, a.descripcion as areass 
				from area_trabajo as s
				inner join areas as a on (a.idarea=s.idarea)
				where s.idarea=".$id." order by subarea asc";
				
	$itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <select id="idareatrabajo" name="0form_idareatrabajo" class="form-control"  >
        <option value=0></option>
        <?php
				
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
			if($rowT["idareatrabajo"]==$sub){$selected="selected='selected'";}
			echo "<option value='".$rowT["idareatrabajo"]."' ".$selected." >".strtoupper($rowT["subarea"])."</option>";
        }
        ?>
    </select>