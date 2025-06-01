    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $codba = trim($_POST["nrocodb"]);
    $ipress =  $_POST["idipres"];
	$valor = strlen($ipress);
	
	$query = "select count(codbarra) as cant FROM muestra WHERE UPPER(codbarra) LIKE UPPER('".$codba."') and estareg=1 ";
	$row = $objconfig->execute_select($query);

	if($row[1]["cant"]!=0)
	{
		echo "El codigo ya se encuetra registrado|1";
	}else{
		$queryT = "select idestablecimiento, eje,red, micro, esta,codrenaes, codrenaes||' - '|| esta||' / '|| micro||' / '||red as nombreestable
				from vista_establecimiento WHERE upper(codrenaes) LIKE UPPER ('%".$ipress."') ";
		$itemsT = $objconfig->execute_select($queryT);
  
		echo $itemsT[1]["idestablecimiento"]."|".$itemsT[1]["nombreestable"];
	}
	
	
//	if ( $valor < 11)
//	{
	/*	$queryT = "select idestablecimiento, eje,red, micro, esta,codrenaes, codrenaes||' - '|| esta||' / '|| micro||' / '||red as nombreestable
				from vista_establecimiento WHERE upper(codrenaes) LIKE UPPER ('%".$ipress."') ";
				*/
/*	} else {
		 $queryT = "select idestablecimiento, eje,red, micro, esta,codrenaes, ruc ||' - '|| esta||' / '|| micro||' / '||red as nombreestable
				from vista_establecimiento WHERE ruc='".$ipress."' ";
		//echo $queryT;
	}
*/
	/*$itemsT = $objconfig->execute_select($queryT);
  
    echo $itemsT[1]["idestablecimiento"]."|".$itemsT[1]["nombreestable"];
	 */
    ?>
   