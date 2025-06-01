<?php

include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	$queryT = "select idseriedoc, seriedoc, valor from seriedoc where idtipocomprobante='".$_POST["idcomprobante"]."' and estado;";
	$itemsT = $objconfig->execute_select($queryT,1);
	echo '<option value="0" selected disabled>---</option>';
 foreach($itemsT[1] as $rowT)
 {
     /* $selected="";
         if($rowT["idseriedoc"]==$_GET["idcomprobante"]){$selected="selected='selected'";} */
         echo "<option value='".$rowT["idseriedoc"]."' valor='".str_pad((((int)$rowT["valor"])+1)."",7,"0", STR_PAD_LEFT)."' seriedoc='".$rowT["seriedoc"]."'>".strtoupper($rowT["seriedoc"])."</option>";

 }
?>