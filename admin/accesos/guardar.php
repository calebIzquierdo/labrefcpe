<?php
	if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
        $objconfig->execute("delete from accesos where idperfil=".$_POST["1form_idperfil"]);
        
        for($i=1;$i<=$_POST["contador_mod"];$i++)
        {
            if(isset($_POST["idmodulo".$i]))
            {
                $query = "insert into accesos(idperfil,idmodulo) values(".$_POST["1form_idperfil"].",".$_POST["idmodulo".$i].")";
				
                $objconfig->execute($query);
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

//        if($_POST["op"]==1)
//        {
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE INCORPORÓ MODULOS AL PERFIL ".strtoupper($_POST["0form_descripcion"])."','".date("h:i:s A")."')");
//        }else{
//           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
//                                values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA MODIFICACION DEL TIPO DE ASOCIACION ".strtoupper($_POST["0form_descripcion"])."','".date("h:i:s")."')");
//        }
        
?>