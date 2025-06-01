    <?php
    include("../../../objetos/class.conexion.php");

    $objconfig  = new conexion();


    $idpaciente =  $_POST["idpa"];
    $fnac = $_POST["fnac"];
    $idref = $_POST["idref"];
	
	if ($idref >0){
		$refPac = $objconfig->execute_select("SELECT  idseguro from coprocultivo where idcoprocultivo=".$idref) ;
		$seguro = $refPac[1]["idseguro"];
	
	}else
		{
		$idseguro = $objconfig->execute_select("SELECT idpaciente, idseguro from paciente where idpaciente=".$idpaciente) ;
		$seguro = $idseguro[1]["idseguro"];
	}
	
   echo $seguro;

    ?>
   