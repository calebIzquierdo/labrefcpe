<?php
if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	$objconfig->table 	= "modulos";
	$objconfig->campoId	= "idmodulo";
	$query = $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	
	$objconfig->execute($query);
	
	
?>