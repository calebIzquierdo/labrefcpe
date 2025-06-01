<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$objconfig->table 	= "entomologia_foco";
	$objconfig->campoId	= "idfoco";
	
	$idfoco			= $_POST["idfoco"];
	$idmuest		= $_POST["idingresomuestra"];
	
	if ($idfoco==0){
		$next	= $objconfig->setCorrelativos("idfoco");
	}else {
		$next	= $_POST["idfoco"];;
	}
	 echo "INSERTAR: ".$_POST["contar_recip"] ;
	$objconfig->execute("delete from  entomologia_foco where idfoco=".$idfoco." ");
	
	$totrecip=0;
	$totposit=0;
							
	for($i=1;$i<=$_POST["contar_recip"];$i++)
	{
		if(isset($_POST["idtipofoco".$i]))
		{
			//if ($_POST["idtipofoco".$i] !="undefined" ){
			$totrecip +=$_POST["rinspeccionado".$i];
			$totposit +=$_POST["rpositiva".$i];	
				
			$query = "insert into entomologia_foco(idfoco,idingresomuestra,idtipofoco,rinspeccionado,rpositiva,idtipo )
			 values(".$next.",'".$idmuest."','".$_POST["idtipofoco".$i]."','".$_POST["rinspeccionado".$i]."',
			 '".$_POST["rpositiva".$i]."','".$_POST["idtipo".$i]."')";
			// echo $query ;
			$objconfig->execute_select($query);
			//}
		}
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
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO RECIPIENTES DE CRIADEROS DE AEDES aegypti COD.BARRA: ".strtoupper($idmuest)." ','".date("h:i:s A")."','ENTOMOLOGIA','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZÓ MODIFICACIÓN DE LAS MUESRAS ENTOMOLOGICA N°: ".$idmuest." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','UROCULTIVO','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>

<script>
	window.opener.recuperar_recipiente(<?php echo $next; ?>,<?php echo $totrecip; ?>,<?php echo $totposit; ?> )
	window.close();
</script>


