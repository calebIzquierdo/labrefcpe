<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$objconfig->table 	= "ingreso";
	$objconfig->campoId	= "idingreso";
 
    $objconfig->execute("update ingreso set estareg=3 where idingreso=".$_POST["1form_idingreso"]);
    $objconfig->execute("update stock_x_marcas set estareg=0 where idingreso=".$_POST["1form_idingreso"]." and idtipomovimiento=1 ");
	
  
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$cant1 = $objconfig->execute_select("select cantidad as stock from stock_material where idmaterial=".$_POST["idmaterial".$i]." and idmarca='".$_POST["idmarca".$i]."' 
				and idmodelo='".$_POST["idmodelo".$i]."'  and idtipomovimiento=1 ");
				$new_cant = $cant1[1]["stock"]-$_POST["cantidad".$i];
				$actu = "update stock_material set cantidad='".$new_cant."'
						where idmaterial='".$_POST["idmaterial".$i]."' and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."' and idtipomovimiento=1 ";
				 echo "Actualiza".$actu;
				 $objconfig->execute($actu);

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

    $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                         values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA ANULACION DEl INGRESO  ".$_POST["numero"]."','".date("h:i:s A")."')");

    
?>

