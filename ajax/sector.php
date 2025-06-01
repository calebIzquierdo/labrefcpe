<?php
	include("../objetos/class.conexion.php");
	
		$objconfig = new conexion();
        $name      = isset($_POST["name"])?$_POST["name"]:0;
        
        $nombre="0form_idsector";
        $nom="";
        if($name==2){$nombre="sector";}
        if($name==3){$nombre="sectorB";$nom="B";$nombre="0form_idsector";}

        if($_POST["opcion"]==3)
        {
        	$r			= explode("|",$_POST["idsector"]);
        	$codigo 	= $r[0];
        }else{
        	$codigo 	= $_POST["idsector"];
        }
?>
<select id="sector<?php echo $nom; ?>" name="<?php echo $nombre; ?>" class="form-control" >
    <option value="0">--Seleccione el Sector--</option>
    <?php
        $queryT = "select * from sector where estareg=1 and iddistrito=".$codigo;
        $itemsT = $objconfig->execute_select($queryT,1);

        foreach($itemsT[1] as $rowT)
        {
                $selected="";
                if($rowT["idsector"]==$_POST["seleccion"]){$selected="selected='selected'";}
                if($_POST["opcion"]==3){
                	echo "<option value='".($rowT["idsector"]."|".$rowT["codubigeo"])."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                }else{
                	echo "<option value='".$rowT["idsector"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                }
        }
    ?>
</select>