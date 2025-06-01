    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $id =  $_POST["idarea"];
	
	  $queryT = "select  s.idareatrabajo, s.idarea, s.descripcion as subarea, a.descripcion as are 
				from area_trabajo as s
				inner join areas as a on (a.idarea=s.idarea)
				where s.estareg=1 and s.idarea=".$id." order by subarea asc";
				
	$itemsT = $objconfig->execute_select($queryT,1);
    ?>
    <input type="hidden" id="nombreareatrabajo" name="nombreareatrabajo" value="" />
    <select id="idareatrabajo" name="idareatrabajo" class="form-control">
        <option value=0></option>
        <?php
		
		
        foreach($itemsT[1] as $rowT)
        {
			echo "<option value='".$rowT["idareatrabajo"]."' ".$selected." >".strtoupper($rowT["subarea"]." / ".$rowT["are"])."</option>";
        }
        ?>
    </select>