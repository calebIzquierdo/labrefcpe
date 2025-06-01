    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $codbar =  strtoupper($_POST["idipres"]);
    
	/*
    $queryT = "select idingresomuestra,idestablecimiento,fecharecepcion,tipoatencion,idestablesolicita,codred, codmred,
				rdes, mred, procedencia,codrenaes, codrenaes||' - '|| procedencia||' / '|| mred||' / '||rdes as nombreestable
				from vista_muestra WHERE codbarra='".$codbar."' and estareg=2"; */
				
	 $queryT = "select idingresomuestra,idestablecimiento,fecharecepcion,tipoatencion,idestablesolicita,codred, codmred,
				rdes, mred, procedencia,codrenaes, codrenaes||' - '|| procedencia||' / '|| mred||' / '||rdes as nombreestable
				from vista_muestra WHERE codbarra='".$codbar."' ";
				
	$itemsT = $objconfig->execute_select($queryT);
	if ($itemsT[1]["idestablesolicita"]==""){
		$cer0=0;
		$cer1="Codigo N°: ".$codbar." Procesado o Anulado";
		$cer2=0;
		$cer3=0;
		$cer4=0;
		echo $cer0."|".$cer1."|".$cer2."|".$cer3."|".$cer4;
	}else {
    echo $itemsT[1]["idestablesolicita"]."|".$itemsT[1]["nombreestable"]."|".$itemsT[1]["codred"]."|".$itemsT[1]["idingresomuestra"]."|".$itemsT[1]["codmred"];
	}
    ?>
   