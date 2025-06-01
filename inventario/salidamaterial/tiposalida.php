 <?php
    include("../../objetos/class.conexion.php");
	$objconfig = new conexion();
	
    $id =  $_POST["tip"];
   
	$que = " select idtiposalida, serie,correlativo from tipo_salida 
				where idtiposalida='".$id."' and estareg='1' ";
	
	$itemsT = $objconfig->execute_select($que);
	$nro = $itemsT[1]["correlativo"];
	$correlativo = substr(str_repeat(0, 7).$itemsT[1]["correlativo"], - 7);
	
	echo $nro."|".$itemsT[1]["serie"]." - ".$correlativo;
  ?>