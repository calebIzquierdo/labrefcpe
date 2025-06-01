<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
	$idproductor 	= $_POST["idproductor"];
	$idterreno 	= $_POST["idterreno"];

	/* $queryT 		= "select canthectarea from tmp_tipsembrio_terreno where iddetalle=(select iddetalle from tmp_ficha_terreno 
						where iddetalle =(select nroficha from ficha_inspeccion 
						where iddetalle=(select itemficha from productores_terreno 
						where idproductor=".$idproductor." and idterreno=".$idterreno." )) )"; */
	$queryT 		= "select hprod as canthectarea from productores_terreno
						where idproductor=".$idproductor." and idterreno=".$idterreno;
						
	$itemsT = $objconfig->execute_select($queryT);		
	$totalhectarea=	$itemsT[1]["canthectarea"]
					   
 ?>
<td> 
 <input type="text" name="areaterreno" id="areaterreno" readonly="readonly" value='<?php echo $totalhectarea; ?>'  size="5" /> &nbsp;&nbsp;Hectarea(S)
 </td>