<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "psa";
	$objconfig->campoId	= "idpsa";

    if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
    }else{
        $next	= $_POST["1form_idpsa"];
    }

    $query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
    echo $query ;
    $objconfig->execute($query);
	/*
	$del1 = "delete from psa_prueba where idtorch=".$next;
    $objconfig->execute($del1);

    for($i=1;$i<=$_POST["contar_prueba"];$i++)
    {
        $sql1 = "insert into psa_prueba(idtorch,fecharesultado, idtipoprueba,valor,idtipotorch,idingresomuestra )
                              values(".$next.",'".$_POST["fecharesultado".$i]."','".$_POST["idtipoprueba".$i]."', '".$_POST["valor".$i]."',
							  '".$_POST["idtipotorch".$i]."','".$_POST["0form_idingresomuestra"]."'  )";
	//	echo $sql1."\n ";
		$objconfig->execute($sql1);
    }
	*/
	$objconfig->execute("update muestra set estareg=2 where idingresomuestra=".$_POST["0form_idingresomuestra"]);

	$exam = "delete from examen_realizado where idexamen=".$next." and idtipo_examen=149";
    $objconfig->execute($exam);

    $exam_sql = "insert into examen_realizado (idexamen , idejecutora ,  idred ,  idmicrored ,  idestablecimiento ,  codbarra ,  
				fecharecepcion ,  idpaciente ,  edadactual ,  idseguro ,  idtipoatencion ,  idtipo_examen ,  nrorecibo ,  fechatoma ,  idtipomuestra ,  idmedicosolicitante , idarea ,  
				idtipourocultivo ,  nroingreso ,  idestablesolicita , fechadigitacion ,  idingresomuestra ,  idatendido ,  idusuario ,  nombre_usuario ,  fechadigitaresultados ,  estareg  )
                 values(".$next.",'".$_POST["0form_idejecutora"]."','".$_POST["0form_idred"]."', '".$_POST["0form_idmicrored"]."','".$_POST["0form_idestablecimiento"]."','".$_POST["0form_codbarra"]."',
				 '".$_POST["0form_fecharecepcion"]."','".$_POST["0form_idpaciente"]."','".$_POST["0form_edadactual"]."','".$_POST["0form_idseguro"]."','".$_POST["0form_idtipoatencion"]."',
				 '149','".$_POST["0form_nrorecibo"]."','".$_POST["0form_fechatoma"]."','".$_POST["0form_idtipomuestra"]."','".$_POST["0form_idmedicosolicitante"]."','".$_POST["0form_idarea"]."',
				 '0','".$_POST["0form_nroingreso"]."','".$_POST["0form_idestablesolicita"]."','".$_POST["0form_fechadigitacion"]."','".$_POST["0form_idingresomuestra"]."','".$_POST["0form_idatendido"]."',
				 '".$_POST["0form_idusuario"]."','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_fechadigitaresultados"]."','".$_POST["0form_estareg"]."'	 )";
	echo "Examenes Psa: ".$exam_sql."\n ";
	$objconfig->execute($exam_sql);

 
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NUEVO SOLICITUD DE EXMAMEN PSA CON NUMERO DE REGISTRO: ".$next." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','PSA','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION EL EXAMEN PSA CON REGISTRO N°: ".$_POST["1form_idpsa"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','PSA','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>