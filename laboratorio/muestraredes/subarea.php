    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $id =  $_POST["tpexam"];
	/*
    $queryT = "select  s.idareatrabajo, s.idarea, s.descripcion as subarea, a.descripcion as are 
				from area_trabajo as s
				inner join areas as a on (a.idarea=s.idarea)
				where s.idareatrabajo=(select idareatrabajo from tipo_examen where idtipo_examen=".$id.")
				where s.estareg=1	order by subarea asc";
	*/		
	  $queryT = "select  s.idareatrabajo, s.idarea, s.descripcion as subarea, a.descripcion as are 
				from area_trabajo as s
				inner join areas as a on (a.idarea=s.idarea)
				where s.estareg=1	order by subarea asc";
				
	$itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <select id="areadestino" name="areadestino" class="form-control"  >
        <option value=0></option>
        <?php
		$tpex = $objconfig->execute_select("select idareatrabajo from tipo_examen where idtipo_examen=".$id);
		
        foreach($itemsT[1] as $rowT)
        {
            $selected="";
			if($rowT["idareatrabajo"]==$tpex [1]["idareatrabajo"]){$selected="selected='selected'";}
			echo "<option value='".$rowT["idareatrabajo"]."|".$rowT["idarea"]."' ".$selected." >".strtoupper($rowT["subarea"]." / ".$rowT["are"])."</option>";
        }
        ?>
    </select>