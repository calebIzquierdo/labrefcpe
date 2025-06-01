<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	   	$objconfig->execute("update salida set estareg=3 where idsalida=".$_POST["1form_idsalida"]);
    	$objconfig->execute("update stock_x_marcas set estareg=0 where idingreso=".$_POST["1form_idsalida"]." and idtipomovimiento=2 ");
	
  
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
			$cant1 = $objconfig->execute_select("select cantidad as stock from stock_material where idmaterial='".$_POST["idmaterial".$i]."' and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."' ");
				
			echo "select cantidad as stock from stock_material where idmaterial=".$_POST["idmaterial".$i]." and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."'  ";
				
			$new_cant = $_POST["cantidad".$i] + $cant1[1]["stock"];
				
			$actu = "update stock_material set cantidad='".$new_cant."'
					where idmaterial='".$_POST["idmaterial".$i]."' and idmarca='".$_POST["idmarca".$i]."' and idmodelo='".$_POST["idmodelo".$i]."'  ";
			echo "Actualiza".$actu;
			$objconfig->execute($actu);

		}

		if($_POST["0form_idrequerimiento"] != null) {
			$sql = "UPDATE requerimiento SET estareg = 4 WHERE idrequerimiento = ".$_POST["0form_idrequerimiento"];
			$objconfig->execute($sql);
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
                         values('".$_SESSION['nombre']."','".$ip."','SE REALIZO LA ANULACION DE LA SALIDAD n° ".$_POST["1form_idsalida"]."','".date("h:i:s A")."')");

    
?>

