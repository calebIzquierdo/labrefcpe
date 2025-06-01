<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "consolidado";
	$objconfig->campoId	= "idconsolidado";

    if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
    }else{
        $next	= $_POST["1form_idconsolidado"];
    }

    $query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
    echo $query ;
    $objconfig->execute($query);
	
	$del1 = "delete from consolidado_muestra where idconsolidado=".$next;
		$objconfig->execute($del1);

		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$sql1 = "insert into consolidado_muestra(idconsolidado,idingresomuestra,codbarra,fecharecepcion,fechainicio, fechatermino, 
					idzona,localidad,vprogram,vinspec,c1, c1positivo,c2,c2positivo,c3, c3positivo,c4, c4positivo, c5,c5positivo,c6,
					c6positivo,c7 , c7positivo,c8,c8positivo,rinspeccionado,rpositiva,vpositiva,mrecibida,idtipointervencion,idusuario,nombre_usuario )
					values(".$next.",'".$_POST["0form_idingresomuestra"]."','".$_POST["0form_codbarra"]."','".$_POST["0form_fecharecepcion"]."','".$_POST["0form_fechainicio"]."','".$_POST["0form_fechatermino"]."',
					'".$_POST["idzona".$i]."','".$_POST["0form_localidad"]."','".$_POST["vprogram".$i]."','".$_POST["vinspec".$i]."','".$_POST["c1".$i]."',
					'".$_POST["c1positivo".$i]."','".$_POST["c2".$i]."','".$_POST["c2positivo".$i]."','".$_POST["c3".$i]."','".$_POST["c3positivo".$i]."',
					'".$_POST["c4".$i]."','".$_POST["c4positivo".$i]."','".$_POST["c5".$i]."','".$_POST["c5positivo".$i]."','".$_POST["c6".$i]."',
					'".$_POST["c6positivo".$i]."','".$_POST["c7".$i]."','".$_POST["c7positivo".$i]."','".$_POST["c8".$i]."','".$_POST["c8positivo".$i]."',
					'".$_POST["rinspeccionado".$i]."','".$_POST["rpositiva".$i]."','".$_POST["vpositiva".$i]."','".$_POST["mrecibida".$i]."',
					'".$_POST["idtipointervencion".$i]."','".$_POST["0form_idusuario"]."','".$_POST["0form_nombre_usuario"]."')";
			echo $sql1."\n ";
			$objconfig->execute($sql1);
		}
		
		$objconfig->execute("update muestra set estareg=2 where idingresomuestra=".$_POST["0form_idingresomuestra"]);
		
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NUEVO CONSOLIDADO DE VIGILANCIA ENTOMOLÓGICA DE AEDES aegypti COD.BARRA: ".strtoupper($_POST["0form_codbarra"])." ','".date("h:i:s A")."','ENTOMOLOGIA','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION CONSOLIDADO CON REGISTRO N°: ".$_POST["0form_codbarra"]." ','".date("h:i:s A")."','ENTOMOLOGIA','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>
