<?php
    if(!session_start()){session_start();}
        
	include("../../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "dxhongo";
	$objconfig->campoId	= "iddxhongo";

    if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
    }else{
        $next	= $_POST["1form_iddxhongo"];
    }

    $query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
    echo $query ;
    $objconfig->execute($query);
	
	/*
	$del1 = "delete from urocultivo_antibiograma where idurocultivo=".$next;
    $objconfig->execute($del1);

    for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
    {
        $sql1 = "insert into urocultivo_antibiograma(idurocultivo,idantibiograma, idtipoantibiograma,idtipourocultivo )
                              values(".$next.",".$_POST["idantibiograma".$i].",".$_POST["idtipoantibiograma".$i].", ".$_POST["0form_idtipourocultivo"].")";
		echo $sql1."\n ";
		$objconfig->execute($sql1);
    }

	
    $del2 = "delete from referencia_suspendido where idreferencia=".$next;
    $objconfig->execute($del2);

    for($i=1;$i<=$_POST["contar_suspende"];$i++)
    {
        $sql2 = "insert into referencia_suspendido(idreferencia,idsuspendido, idpaciente )
                              values(".$next.",".$_POST["idsuspendido".$i].",".$_POST["0form_idtipourocultivo"].")";

		$objconfig->execute($sql2);
    }
	
	$del3 = "delete from referencia_noacepta where idreferencia=".$next;
    $objconfig->execute($del3);

    for($i=1;$i<=$_POST["count_noacept"];$i++)
    {
        $sql3 = "insert into referencia_noacepta(idreferencia,idnoacepta, idpaciente )
                              values(".$next.",".$_POST["idnoacepta".$i].",".$_POST["0form_idpaciente"].")";
		echo $query ;
		$objconfig->execute($sql3);
    }
	*/
	
	
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

       if($_POST["op"]==1)
        {   
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NUEVO SOLICITUD DE DX DE HONGO CON NUMERO DE REGISTRO: ".$next." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION EL DX DE HONGO CON REGISTRO N°: ".$_POST["1form_idurocultivo"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>