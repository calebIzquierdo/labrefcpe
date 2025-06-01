<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "otros_resultados";
	$objconfig->campoId	= "idotrosresultados";

    if($_POST["op"] == "0")
    {
        $resultados = array();
        $next 	= $objconfig->setCorrelativos();

        $sql1 = "INSERT INTO otros_resultados(idotrosresultados, idingresomuestra, idcliente, sexo, edad, idestablecimiento, idpersonal, fecharecepcion, fechareg, codbarra, enfermedad, observaciones, idusuario, nombre_usuario, estadoreg)
            VALUES (".$next.", ".$_POST['0form_idingresomuestra'].", ".$_POST['0form_idcliente'].", '".$_POST['0form_sexo']."','".$_POST['0form_edad']."',  ".$_POST['0form_idestablecimiento'].", ".$_POST['0form_idpersonal'].", '".$_POST['0form_fecharecepcion']."', '".$_POST['0form_fechareg']."', '".$_POST['0form_codbarra']."', '".$_POST['0form_enfermdad']."', '".$_POST['0form_observaciones']."', ".$_POST['0form_idusuario'].", '".$_POST['0form_nombre_usuario']."', 1);";
        $objconfig->execute($sql1);

        // busca el resultado agregaro
        $queryT = "SELECT idotrosresultados FROM otros_resultados WHERE codbarra LIKE '%".$_POST['0form_codbarra']."%'";
        $itemsT = $objconfig->execute_select_object($queryT);
        $idotrosresultados = $itemsT["idotrosresultados"];

        $resultados = $_POST['resultados'];
        $tamanio = count($resultados);

        for($i = 0; $i < $tamanio; $i++){
            $resultado = $resultados[$i];

            $objconfig->table 	= "otros_resultados_det";
	        $objconfig->campoId	= "idotrosresultadosdet";
            $siguiente 	= $objconfig->setCorrelativos();

            echo json_encode($resultado["'fecharegistro'"]);
            
            $sqlr = "INSERT INTO otros_resultados_det(idotrosresultadosdet, idotrosresultados, fecharegistro, idtipo_examen, valores, resultado, estadoreg)
                VALUES (".$siguiente.", ".$idotrosresultados.", '".$resultado["fecharegistro"]."', ".$resultado["idexamen"].", '".$resultado["valores"]."', '".$resultado["resultados"]."', 1);";
            $objconfig->execute($sqlr);
        }


    } else {
        $sql1 = "UPDATE otros_resultados SET sexo = '".$_POST['0form_sexo']."', edad = '".$_POST['0form_edad']."', idpersonal = ".$_POST['0form_idpersonal'].", fecharecepcion = '".$_POST['0form_fecharecepcion']."', fechareg = '".$_POST['0form_fechareg']."', enfermedad = '".$_POST['0form_enfermdad']."', observaciones = '".$_POST['0form_observaciones']."', idusuario = ".$_POST['0form_idusuario'].", nombre_usuario = '".$_POST['0form_nombre_usuario']."'
                    WHERE idotrosresultados = ".$_POST['0form_idingresomuestra'].";";
        $objconfig->execute($sql1);
    }
    
	
	
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "IP desconocida";

    if($_POST["op"] == "0")
    {   
        $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                            values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO OTRO RESULTADO: ".$next." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','".$_POST['0form_enfermdad']."','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
    }else{
        $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario)
                            values('".$_SESSION['nombre']."','".$ip."','SE MODIFICÓ EL RESULTADO: ".$_POST['0form_idingresomuestra']." MODIFICADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','".$_POST['0form_enfermdad']."','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
    }

?>