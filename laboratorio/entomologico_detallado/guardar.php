<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "entomologia";
	$objconfig->campoId	= "identomologia";
	
	if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
	} else {
		 $next	= $_POST["1form_identomologia"];
	}	
        $query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
		echo $query."\n" ;
	    $objconfig->execute($query);
		
		$del1 = "delete from entomologia_muestra where identomologia=".$next;
		$objconfig->execute($del1);

		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$sql1 = "insert into entomologia_muestra(identomologia,idingresomuestra,fecharecepcion,fechainicio, fechatermino, 
					idzona,inspector,manzana,direccion,idtipofoco, larva,pupa,adulto,aedes, otro,familia,vinspec, idtipointervencion,vprogam,rinspeccionado,rpositiva )
					values(".$next.",'".$_POST["0form_idingresomuestra"]."','".$_POST["0form_fecharecepcion"]."','".$_POST["0form_fechainicio"]."','".$_POST["0form_fechatermino"]."',
					'".$_POST["idzona".$i]."','".$_POST["idinspector".$i]."','".$_POST["manzana".$i]."','".$_POST["direccion".$i]."','".$_POST["idtipofoco".$i]."',
					'".$_POST["larva".$i]."','".$_POST["pupa".$i]."','".$_POST["adulto".$i]."','".$_POST["aedes".$i]."','".$_POST["otro".$i]."',
					'".$_POST["familia".$i]."','".$_POST["vinspec".$i]."','".$_POST["idtipointervencion".$i]."','".$_POST["vprogam".$i]."',
					'".$_POST["rinspeccionado".$i]."','".$_POST["rpositiva".$i]."')";
			echo $sql1."\n ";
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

       if($_POST["op"]==1)
        {   
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NUEVAS MUESTRAS ENTOMOLÓGICA DE AEDES aegypti COD.BARRA: ".strtoupper($_POST["0form_codbarra"])." ','".date("h:i:s A")."','ENTOMOLOGIA','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZÓ MODIFICACIÓN DE LAS MUESRAS ENTOMOLOGICA N°: ".$_POST["0form_codbarra"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>