<?php
	include("../objetos/class.conexion.php");
	
	
    $objconfig = new conexion();
    $name      = isset($_POST["name"])?$_POST["name"]:0;
        
        $onchange   = "";
        $name2      = "";
        if($_POST["opcion"]==1){
            $onchange   = "onchange='cargar_datos_provincia(this.value,0,1);'";
            $codigo     = $_POST["idpais"];
        }
        if($_POST["opcion"]==2)
        {
            $onchange   = "onchange='cargar_datos_provinciaA(this.value,0,2);'";
            $name2      = "B";
            $codigo     = $_POST["idpais"];
        }
        if($_POST["opcion"]==3){
            $onchange   = "onchange='cargar_datos_provincia(this.value,0,3);'";
            $r          = explode("|",$_POST["idpais"]);
            $codigo     = $r[0];
        }
        
        $nombre="0form_iddepartamento";
        if($name==2){$nombre="departamento";}
?>
<select id="departamento<?php echo $name2; ?>" name="<?php echo $nombre; ?>"  class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione el Departamento--</option>
    <?php
        $queryT = "select * from departamento where estareg=1 and idpais=".$codigo;
        $itemsT = $objconfig->execute_select($queryT,1);

        foreach($itemsT[1] as $rowT)
        {
                $selected="";
                if($rowT["iddepartamento"]==$_POST["seleccion"]){$selected="selected='selected'";}
                if($_POST["opcion"]==1 || $_POST["opcion"]==2){
                	echo "<option value='".$rowT["iddepartamento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                }
                if($_POST["opcion"]==3){
                	echo "<option value='".($rowT["iddepartamento"]."|".$rowT["codubigeo"])."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                }
        }
    ?>
</select>