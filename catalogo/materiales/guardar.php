<?php
    if(!session_start()){session_start();}
	$pc =   php_uname();
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
    $objconfig->table 	= "materiales";
    $objconfig->campoId	= "idmaterial";
	
	 if($_POST["op"]==1)
    {
        $next 	= $objconfig->setCorrelativos();
    }else{
        $next	= $_POST["1form_idmaterial"];
    }

    $query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
   // echo $query ;
    $objconfig->execute($query);

	$del1 = "delete from material_metodo where idmaterial=".$next;
    $objconfig->execute($del1);

		for($i=1;$i<=$_POST["contar_metodo"];$i++)
		{
			if(isset($_POST["descripcion".$i]))
			{
				$sql1 = "insert into material_metodo (idmaterial,descripcion ";
				$sql1 .=" ) values(".$next.",'".$_POST["descripcion".$i]."' )";
				echo $sql1.";\n ";
				$objconfig->execute($sql1);
			}
		}
	$del3 = "delete from material_caracteristicas where idmaterial=".$next;
    $objconfig->execute($del3);

		for($k=1;$k<=$_POST["contar_caracteres"];$k++)
		{
			if(isset($_POST["descripcion".$k]))
			{
				$sql3 = "insert into material_caracteristicas (idmaterial,descripcion  )";
				$sql3 .=" values(".$next.",'".$_POST["descripcion".$k]."' )";
				$objconfig->execute($sql3);
			}
		}
		
	$del2 = "delete from material_mbiolo where idmaterial=".$next;
    $objconfig->execute($del2);

		for($j=1;$j<=$_POST["contar_muestra"];$j++)
		{
			if(isset($_POST["descripcion".$j]))
			{
				$sql2 = "insert into material_mbiolo (idmaterial,descripcion ";
				$sql2 .=" ) values(".$next.",'".$_POST["descripcion".$j]."' )";
			//	echo $sql2.";\n ";
				$objconfig->execute($sql2);
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
    
	$id = explode("|", $_SESSION['nombre']); 
	
    if($_POST["op"]==1)
    {
        $objconfig->execute("insert into log(usuario,ip,descripcion,hora,idusuario,nombrepc) 
                            values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA INSERCION DEL NUEVO MATERIAL: ".strtoupper($_POST["0form_descripcion"])."','".date("h:i:s A")."',".$id[0].",'".$pc."')");
    }else{
		$id = explode("|", $_SESSION['nombre']); 
		$objconfig->execute("insert into log(usuario,ip,descripcion,hora,idusuario,nombrepc)  
                            values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA MODIFICACION DEL MATERIAL: ".strtoupper($_POST["0form_descripcion"])."','".date("h:i:s A")."',".$id[0].",'".$pc."')");
    }
?>