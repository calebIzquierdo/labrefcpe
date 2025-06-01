    <?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $codbar =  strtoupper($_POST["idipres"]);
    
    $queryT = "select idingresomuestra,idestablecimiento,fecharecepcion,tipoatencion,idestablesolicita,rdes, mred, codred,codmred,codejecu,
				procedencia,codrenaes, codrenaes||' - '|| procedencia||' / '|| mred||' / '||rdes as nombreestable
				from vista_muestra WHERE codbarra='".$codbar."' and estareg=1";
	$itemsT = $objconfig->execute_select($queryT);
	if ($itemsT[1]["idestablesolicita"]==""){
		$cer0=0;
		$cer1="Codigo N°: ".$codbar." Procesado o Anulado";
		$cer2=date("d/m/yy");
		$cer3=0;
		echo $cer0."|".$cer1."|".$cer2."|".$cer3;
	}else {
    echo $itemsT[1]["idestablesolicita"]."|".$itemsT[1]["nombreestable"]."|".$itemsT[1]["fecharecepcion"]."|".$itemsT[1]["idingresomuestra"]."|".$itemsT[1]["codejecu"]."|".$itemsT[1]["codred"]."|".$itemsT[1]["codmred"];
	}
    ?>
   