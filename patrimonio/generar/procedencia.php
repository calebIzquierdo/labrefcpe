    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $ipress =  $_POST["idipres"];
    
    $queryT = "select idestablecimiento, eje,red, micro, esta,codrenaes, codrenaes||' - '|| esta||' / '|| micro||' / '||red as nombreestable
				from vista_establecimiento WHERE upper(codrenaes) LIKE UPPER ('%".$ipress."') ";
	$itemsT = $objconfig->execute_select($queryT);
  
    echo $itemsT[1]["idestablecimiento"]."|".$itemsT[1]["nombreestable"];
	 
    ?>
   