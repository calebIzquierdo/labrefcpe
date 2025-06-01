<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
        
        $r = $objconfig->execute_select("select * from productores where idproductor=".$_POST["idproductor"]);
                
        echo $r[1]["idpais"]."|".$r[1]["iddepartamento"]."|".$r[1]["idprovincia"]."|".$r[1]["iddistrito"]."|".$r[1]["idsector"];
?>