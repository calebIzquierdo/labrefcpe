<?php
 if(!session_start()){session_start();}
    include("../../objetos/class.correlativos.php");
	
    $objconfig = new correlativo();
    
    $itemficha		= $_POST["idkitfecha"];
    $idunidad		= $_POST["idunidad"];
    $idmaterial		= $_POST["idmaterial"];
    $idmarca		= $_POST["idmarca"];
    $idkit		= $_POST["idkit"];
    $fila		= $_POST["fila"];
    $saldo		= $_POST["saldo"];


	if($itemficha==0)
    {
		$sqlC = "select case when max(idkitfecha) is null then 1 else max(idkitfecha) + 1 end as correlativo from kitsalida_fecha";
        $row = $objconfig->execute_select($sqlC);
        
        $correlativo = $row[1]["correlativo"];
		
		
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
		
			$sql =  "insert into kitsalida_fecha (idkitfecha, idkit, idunidad,idmaterial,idmarca,
					fechauso,iduso, cantidad,idresultado )
					values('".$correlativo."','".$idkit."','".$idunidad."','".$idmaterial."', '".$idmarca."',
					'".$_POST["fechauso".$i]."', '".$_POST["iduso".$i]."', '".$_POST["cantidad".$i]."',
					'".$_POST["idresultado".$i]."' )";
			echo "Valor 0: \n".	$sql;	 
			$objconfig->execute($sql);
        }
    } else{
		$correlativo = $itemficha;
		$objconfig->execute("delete from kitsalida_fecha where idkitfecha=".$correlativo);
		for($i=1;$i<=$_POST["contar_diagnostico"];$i++)
		{
            $sql	= "insert into kitsalida_fecha (idkitfecha, idkit, idunidad,idmaterial,idmarca,
						fechauso,iduso, cantidad,idresultado )
					values('".$correlativo."','".$idkit."','".$idunidad."','".$idmaterial."', '".$idmarca."',
					'".$_POST["fechauso".$i]."', '".$_POST["iduso".$i]."', '".$_POST["cantidad".$i]."',
					'".$_POST["idresultado".$i]."'	)";
		//	echo "Valor 1: \n".	$sql;	 
			$objconfig->execute($sql);
			
		}
	 }
/*
		$sql_ficha = "UPDATE  pregistro_parcela set idkitfecha=".$correlativo." 
                            where idparcela = ".$_POST["idparcela"];
        $objconfig->execute($sql_ficha);
*/
	 
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

        if($_POST["itemficha"]==0)
        {
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NUEVO CONSUMO DE DETERMINANTES ".strtoupper($_POST["nombproducto"])."','".date("h:i:s A")."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO NUEVO CONSUMO DE DETERMINANTES ".strtoupper($_POST["nombproducto"])."','".date("h:i:s A")."')");
        }

	
?>
<script>
	window.opener.recuperar_detalles('<?php echo $fila; ?>','<?php echo $correlativo; ?>','<?php echo $saldo; ?>' )
	window.close();
</script>

