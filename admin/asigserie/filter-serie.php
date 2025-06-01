<?php

include("../../objetos/class.conexion.php");
	
$objconfig = new conexion();
 $queryT = "select idseriedoc, seriedoc from seriedoc where idtipocomprobante='".$_POST["idcomprobante"]."' and estado;";
 $itemsT = $objconfig->execute_select($queryT,1);
echo '<option value="0" selected>--Seleccionar--</option>';
 foreach($itemsT[1] as $rowT)
 {
     /* $selected="";
         if($rowT["idseriedoc"]==$_GET["idcomprobante"]){$selected="selected='selected'";} */
         echo "<option value='".$rowT["idseriedoc"]."'>".strtoupper($rowT["seriedoc"])."</option>";

 }
?>