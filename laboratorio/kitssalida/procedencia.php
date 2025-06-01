    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $codbar =  strtoupper($_POST["idipres"]);
    
    $queryT = "select idestablecimiento, eje,red, micro, esta,codrenaes, codrenaes||' - '|| esta||' / '|| micro||' / '||red as nombreestable,
				idred, idmicrored,idejecutora	
				from vista_establecimiento WHERE upper(codrenaes) LIKE UPPER ('%".$codbar."') ";
	//echo $queryT;
	$itemsT = $objconfig->execute_select($queryT);
    echo $itemsT[1]["idestablecimiento"]."|".$itemsT[1]["nombreestable"]."|".$itemsT[1]["idejecutora"]."|".$itemsT[1]["idred"]."|".$itemsT[1]["idmicrored"];
	
    ?>
   