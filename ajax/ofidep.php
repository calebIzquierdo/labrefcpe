<?php
	include("../objetos/class.conexion.php");
	
	$objconfig  = new conexion();

        
    $idofic =  $_POST["idofic"];
    $iddepe = $_POST["iddepe"];
        
        $sqlCont= "select count(idequipamiento) as totales from equipamiento where idoficina=".$idofic." and iddependencia=".$iddepe ;
        $cantidad = $objconfig->execute_select($sqlCont);
        if  ($cantidad[1]["totales"]==0){
           echo "NO|0";
        }else{
        echo "SI|1";
        }
        
     
?>
