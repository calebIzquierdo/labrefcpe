<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
    $name      = isset($_POST["name"])?$_POST["name"]:0;
        
    $onchange	= "";
    $name2		= "";
    if($_POST["opcion"]==1)
    {
        $onchange	= "onchange='cargar_datos_distrito(this.value,0,1)'";
        $codigo 	= $_POST["iddepartamento"];
    }
    if($_POST["opcion"]==2)
    {
        $onchange	= "onchange='cargar_datos_distritoA(this.value,0,2)'";
        $name2		= "B";
        $codigo 	= $_POST["iddepartamento"];
    }
    if($_POST["opcion"]==3)
    {
    	$onchange	= "onchange='cargar_datos_distrito(this.value,0,3);'";
    	$r			= explode("|",$_POST["iddepartamento"]);
    	$codigo 	= $r[0];
    }
    
    $nombre="0form_idprovincia";
    if($name==2){$nombre="provincia";}
?>
<select id="provincia<?php echo $name2; ?>" name="<?php echo $nombre; ?>" class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione la Provincia--</option>
    <?php
        $queryT = "select * from provincia where estareg=1 and iddepartamento=".$codigo;
        $itemsT = $objconfig->execute_select($queryT,1);

        foreach($itemsT[1] as $rowT)
        {
                $selected="";
                if($rowT["idprovincia"]==$_POST["seleccion"]){$selected="selected='selected'";}
                if($_POST["opcion"]==1 || $_POST["opcion"]==2){
                	echo "<option value='".$rowT["idprovincia"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                }
                if($_POST["opcion"]==3){
                	echo "<option value='".($rowT["idprovincia"]."|".$rowT["codubigeo"])."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                }
        }
    ?>
</select>