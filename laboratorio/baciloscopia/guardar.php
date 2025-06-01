<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "aedes";
	$objconfig->campoId	= "idaedes";

    if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
    }else{
        $next	= $_POST["1form_idaedes"];
    }

    $query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
   // echo $query ;
    $objconfig->execute($query);

   $del1 = "delete from aedes_muestra where idaedes=".$next;
   $objconfig->execute($del1);

		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$sql1 = "insert into aedes_muestra(idaedes,idingresomuestra,codbarra,poblacion,fecharecepcion,fechainicio, fechatermino, 
					idzona,fechrecojo,idmanzana,familia,idinspector, idfoco,idlarva,idpupa,idadulto, idaedes_a,idotros, 
					idtipointervencion,idusuario,nombre_usuario,localidad,totalviviendas, viviprogramadas,viviinspeccion,
					idejecutora,idred,idmicrored,idestablecimiento,codred,codmred,idestablesolicita,
					iddistrito,idprovincia,iddepartamento,direccion,latitud,longitud 	)
					values(".$next.",'".$_POST["0form_idingresomuestra"]."','".$_POST["0form_codbarra"]."','".$_POST["0form_poblacion"]."','".$_POST["0form_fecharecepcion"]."','".$_POST["0form_fechainicio"]."','".$_POST["0form_fechatermino"]."',
					'".$_POST["idzona".$i]."','".$_POST["fechrecojo".$i]."','".$_POST["idmanzana".$i]."','".$_POST["familia".$i]."','".$_POST["idinspector".$i]."',
					'".$_POST["idfoco".$i]."','".$_POST["idlarva".$i]."','".$_POST["idpupa".$i]."','".$_POST["idadulto".$i]."','".$_POST["idaedes_a".$i]."',
					'".$_POST["idotros".$i]."','".$_POST["0form_idtipointervencion"]."','".$_POST["0form_idusuario"]."','".$_POST["0form_nombre_usuario"]."',
					'".$_POST["localidad".$i]."','".$_POST["totalviviendas".$i]."','".$_POST["viviprogramadas".$i]."','".$_POST["viviinspeccion".$i]."',
					'".$_POST["0form_idejecutora"]."','".$_POST["0form_idred"]."',
					'".$_POST["0form_idmicrored"]."','".$_POST["0form_idestablecimiento"]."','".$_POST["0form_codred"]."','".$_POST["0form_codmred"]."',
					'".$_POST["0form_idestablesolicita"]."','".$_POST["0form_iddistrito"]."','".$_POST["0form_idprovincia"]."','".$_POST["0form_iddepartamento"]."',
					'".$_POST["direccion".$i]."','".$_POST["latitud".$i]."','".$_POST["longitud".$i]."')";
			echo $sql1.";\n ";
			$objconfig->execute($sql1);
		}
		$del2 = "delete from aedes_resipiente where idaedes=".$next;
		$objconfig->execute($del2);

		for($i=1;$i<=$_POST["contar_recipiente"];$i++)
		{
			$sql2 = "insert into aedes_resipiente(idaedes,idingresomuestra,codbarra,fecharecepcion,fechainicio, fechatermino, 
					idzonainsp,fechrecojo,c1insp,c2insp, c3insp,c4insp,c5insp,c6insp, c7insp,c8insp,idtipointervencion,idusuario,nombre_usuario,
					idejecutora,idred,idmicrored,idestablecimiento,codred,codmred,idestablesolicita,iddistrito,idprovincia,iddepartamento	)
					values(".$next.",'".$_POST["0form_idingresomuestra"]."','".$_POST["0form_codbarra"]."','".$_POST["0form_fecharecepcion"]."','".$_POST["0form_fechainicio"]."',
					'".$_POST["0form_fechatermino"]."','".$_POST["idzonainsp".$i]."','".$_POST["fechrecojo".$i]."','".$_POST["c1insp".$i]."','".$_POST["c2insp".$i]."',
					'".$_POST["c3insp".$i]."','".$_POST["c4insp".$i]."','".$_POST["c5insp".$i]."','".$_POST["c6insp".$i]."','".$_POST["c7insp".$i]."','".$_POST["c8insp".$i]."',
					'".$_POST["0form_idtipointervencion"]."','".$_POST["0form_idusuario"]."','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idejecutora"]."','".$_POST["0form_idred"]."','".$_POST["0form_idmicrored"]."',
					'".$_POST["0form_idestablecimiento"]."','".$_POST["0form_codred"]."','".$_POST["0form_codmred"]."','".$_POST["0form_idestablesolicita"]."',
					'".$_POST["0form_iddistrito"]."','".$_POST["0form_idprovincia"]."','".$_POST["0form_iddepartamento"]."')";
		//	echo $sql2.";\n ";
			$objconfig->execute($sql2);
		}
		// ,localidad,totalviviendas, viviprogramadas,viviinspeccion,
		
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$sql3 = "update aedes_resipiente set poblacion='".$_POST["0form_poblacion"]."',
						localidad='".$_POST["localidad".$i]."',totalviviendas='".$_POST["totalviviendas".$i]."',
						viviprogramadas='".$_POST["viviprogramadas".$i]."',viviinspeccion='".$_POST["viviinspeccion".$i]."' 
						where idaedes=".$next." and  idzonainsp= '".$_POST["idzona".$i]."' and idingresomuestra=".$_POST["0form_idingresomuestra"]." 					" ;
		//	echo $sql3.";\n ";
			$objconfig->execute($sql3);
		}	
		
		for($i=1;$i<=$_POST["contar_recipiente"];$i++)
		{
			$sql4 = "update aedes_muestra set c1='".$_POST["c1insp".$i]."',c2='".$_POST["c2insp".$i]."',	c3='".$_POST["c3insp".$i]."',c4='".$_POST["c4insp".$i]."',
					c5='".$_POST["c5insp".$i]."',c6='".$_POST["c6insp".$i]."',c7='".$_POST["c7insp".$i]."',c8='".$_POST["c8insp".$i]."',
						where idaedes=".$next." and  idzona= '".$_POST["idzonainsp".$i]."' and idingresomuestra=".$_POST["0form_idingresomuestra"]." 					" ;
			echo $sql4."\n ";
			$objconfig->execute($sql4);
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NUEVA MUESTRAS DE ANÓFELES DE AEDES aegypti COD.BARRA: ".strtoupper($_POST["0form_codbarra"])." ','".date("h:i:s A")."','ANÓFELES','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION LA MUESTRA DE ANOFELES REGISTRO N°: ".$_POST["0form_codbarra"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','ANÓFELES','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>