<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	$op=$_POST["op"];
	$idusuario = $_POST["1form_idusuario"];
	$nomb = $_POST["0form_nombres"];
	$nombres = strtoupper($nomb);
	$login1 = $_POST["0form_login"];
	$login = strtoupper($login1);
	$contra1 = strtoupper($_POST["0form_contra"]);
	$contra = md5($contra1);
	$idperfil = ($_POST["0form_idperfil"]);
	$codemp = ($_POST["0form_idejecutora"]);
	$idred = ($_POST["0form_idred"]);
	$idmicrored = ($_POST["0form_idmicrored"]);
	$idestablecimiento = ($_POST["0form_idestablecimiento"]);
	$estado = ($_POST["0form_estareg"]);
    $vence = ($_POST["0form_idvencimiento"]);
  //  $idservicio = ($_POST["0form_idservicio"]);
  //  $idtiposervicio = ($_POST["0form_idtiposervicio"]);
    $idnivelreporte = $_POST["0form_idnivelreporte"];


	if ($op==1)
	{
		 $sqlC = "select case when max(idusuario) is null then 1 else max(idusuario) + 1 end as correlativo from usuarios";
         $row = $objconfig->execute_select($sqlC);
		 $correlativo = $row[1]["correlativo"];
		 
		 
		 $sql = "insert into usuarios (idusuario, nombres, login, estareg, idperfil,idejecutora,idmicrored,idestablecimiento,idred,idnivelreporte,idvencimiento ) 
            		VALUES ('".$correlativo."','".$nombres."','".$login."','".$estado."','".$idperfil."','".$codemp."','".$idmicrored."','".$idestablecimiento."',
					'".$idred."','".$idnivelreporte."',".$vence.")";
		 $objconfig->execute($sql);
	}
	if ($op==2) {
		  $sql = "update usuarios set  nombres='".$nombres."', login='".$login."', estareg='".$estado."',idperfil='".$idperfil."', idejecutora='".$codemp."', 
		  idmicrored='".$idmicrored."', idestablecimiento='".$idestablecimiento."',  idred='".$idred."' , idnivelreporte='".$idnivelreporte."', 
		  idvencimiento='".$vence."'	
		  where idusuario='".$idusuario."'";
		  echo $sql;
		 $objconfig->execute($sql);
	}
	if ($op==3) {
			$sql = "update usuarios set   contra='".$contra."' where idusuario='".$idusuario."'";
		    $objconfig->execute($sql);
		}
	
	$objconfig->execute($query);
	
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
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE AGREGO NUEVO USUARIO: ".strtoupper($_POST["0form_nombres"])."','".date("h:i:s A")."')");
        }
		if($_POST["op"]==2){
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE ACTUALIZO DATOS DEL USUARIO: ".strtoupper($_POST["0form_nombres"])."','".date("h:i:s A")."')");
        }
		if($_POST["op"]==3){
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE ACTUALIZO CONTRASEÑA DEL USUARIO: ".strtoupper($_POST["0form_nombres"])."','".date("h:i:s A")."')");
        }
        
?>