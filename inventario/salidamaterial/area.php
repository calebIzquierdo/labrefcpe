<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
  //  $idEst =  $_POST["idEst"];
    $idar   = $_POST["idar"];


    
	/*
    $queryT = "select  s.idareatrabajo, s.idarea, s.descripcion as subarea, a.descripcion as are 
				from area_trabajo as s
				inner join areas as a on (a.idarea=s.idarea)
				where s.idareatrabajo=(select idareatrabajo from tipo_examen where idtipo_examen=".$id.")
				where s.estareg=1	order by subarea asc";
				$queryT = "select idarea,descripcion from areas
      where idestablecimiento=".$idEst." and estareg=1";
	*/		
	  $queryT = "select idarea,descripcion from areas where estareg=1";
				
	$itemsT = $objconfig->execute_select($queryT,1);
    ?>

    <option value=""> --- Seleccionar Unidad de Trabajo ---</option>
        <?php
        foreach($itemsT[1] as $rowT)
        {   // echo $rowT["idarea"];
            
            $selected="";
            if($rowT["idarea"]==$idar && $idar!=0){$selected="selected='selected'";}
            echo "<option value='".$rowT["idarea"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
        }
        ?>