<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
    $objconfig->table 	= "otros_resultados_det";
    $objconfig->campoId	= "idotrosresultadosdet";

    $siguiente 	= $objconfig->setCorrelativos();

    $type = $_POST["id"];
    if($type != ""){
        
        $sql1 = "UPDATE otros_resultados_det
            SET fecharegistro='".$_POST['fecharegistro']."', valores='".$_POST['valores']."', resultado='".$_POST['resultados']."'
            WHERE idotrosresultadosdet=".$_POST['id'].";";
        $objconfig->execute($sql1);

    } else {
        
        $sql1 = "INSERT INTO otros_resultados_det(idotrosresultadosdet, idotrosresultados, fecharegistro, idtipo_examen, valores, resultado, estadoreg)
            VALUES (".$siguiente.", ".$_POST['idotrosresultados'].", '".$_POST['fecharegistro']."', ".$_POST['idexamen'].", '".$_POST['valores']."', '".$_POST['resultados']."', 1);";
        $objconfig->execute($sql1);

    }


    $idusuario = explode("|",$_SESSION['nombre']);

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
    
    if($type != ""){
        $objconfig->execute("insert into log(usuario, ip, descripcion, hora, tipo_examen, nombre_usuario, idusuario) 
                            values('".$_SESSION['nombre']."','".$ip."','SE MODIFICÓ EL RESULTADO: ".$_POST['id']." - MODIFICADO POR: ".strtoupper($_SESSION['nombre'])."','".date("h:i:s A")."','".$_POST['examen']."','".$idusuario[1]."','".$idusuario[0]."')");
    } else {
        $objconfig->execute("insert into log(usuario, ip, descripcion, hora, tipo_examen, nombre_usuario, idusuario) 
                            values('".$_SESSION['nombre']."','".$ip."','SE AGREGO EL RESULTADO: ".$siguiente." - AGREGADO POR: ".strtoupper($_SESSION['nombre'])."','".date("h:i:s A")."','".$_POST['examen']."','".$idusuario[1]."','".$idusuario[0]."')");
    }
    
?>