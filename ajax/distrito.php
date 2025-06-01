<?php
	include("../objetos/class.conexion.php");
	
	$objconfig  = new conexion();
        $name       = isset($_POST["name"])?$_POST["name"]:0;
        
        $onchange="";
        $name2="";
        if($_POST["opcion"]==1)
        {
            $onchange 	= "onchange='cargar_datos_sectores(this.value,0,1)';";
            $codigo 	= $_POST["idprovincia"];
        }
        
        if($_POST["opcion"]==2)
        {
        	$onchange	= "onchange='cargar_datos_sectoresA(this.value,0,2)'";
             $name2		= "B";
             $codigo 	= $_POST["idprovincia"];
        }
        if($_POST["opcion"]==3)
        {
        	$onchange	= "onchange='cargar_datos_sectores(this.value,0,3);'";
        	$r			= explode("|",$_POST["idprovincia"]);
        	$codigo 	= $r[0];
        }
        
        $nombre="0form_iddistrito";
        if($name==2){$nombre="distrito";}
?>

<select id="distrito<?php echo $name2; ?>" name="<?php echo $nombre; ?>" class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione el Distrito--</option>
    <?php
        $queryT = "select * from distrito where estareg=1 and idprovincia=".$codigo." order by descripcion asc ";
        $itemsT = $objconfig->execute_select($queryT,1);

        foreach($itemsT[1] as $rowT)
        {
            $selected="";
            if($rowT["iddistrito"]==$_POST["seleccion"]){$selected="selected='selected'";}
            if($_POST["opcion"]==1 || $_POST["opcion"]==2){
            	echo "<option value='".$rowT["iddistrito"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
            }
            if($_POST["opcion"]==3){
            	echo "<option value='".($rowT["iddistrito"]."|".$rowT["codubigeo"])."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
            }
        }
    ?>
</select>