<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();


    $idpaciente =  $_POST["idpa"];
    $fref = $_POST["fref"];
    $cod = $_POST["cod"];

    $fechatrans = explode("/", $fref);
    $dia = $fechatrans[0];
    $mes = $fechatrans[1];
    $anio = $fechatrans[2];

    //$fechatranslado = $anio."-".$mes."-".$dia;
	$fechatranslado = $dia."-".$mes."-".$anio;

    $fecha_nace = $objconfig->execute_select("SELECT fnacimiento FROM paciente WHERE idpaciente=".$idpaciente );

    if ($cod =="") {
		$fecha_nacimiento = $fecha_nace[1]["fnacimiento"];
		$edadActual = $objconfig->EdadActual($fecha_nacimiento,$fechatranslado);
		
       } else {
        $calculaedad = $objconfig->execute_select("select edadactual from psa where idpsa= ".$cod) ;
        $edadActual = $calculaedad[1]["edadactual"];
    }

    if ($idpaciente !=0) {

        $edad = $edadActual;
    }


?>
<input type="text" name="0form_edadactual" id="edadactual" readonly value="<?=$edad ;?>" class="form-control" />