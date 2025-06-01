<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();


    $sql1 = "DELETE FROM otros_resultados_det WHERE idotrosresultadosdet = ".$_POST["idotrosresultadosdet"].";";
    $objconfig->execute($sql1);


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
    
    $objconfig->execute("insert into log(usuario, ip, descripcion, hora, tipo_examen, nombre_usuario, idusuario) 
                            values('".$_SESSION['nombre']."','".$ip."','SE ELIMINÓ EL RESULTADO DE : ".$_POST['idotrosresultadosdet']." - ELIMINADO POR: ".strtoupper($_SESSION['nombre'])."','".date("h:i:s A")."','".$_POST['descripcion']."','".$idusuario[1]."','".$idusuario[0]."')");
?>