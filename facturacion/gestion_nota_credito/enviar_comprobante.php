<?php
     if(!session_start()){session_start();}
        
     include("../../objetos/class.conexion.php");
     $objconfig = new conexion();
     $invoice_sunat= $objconfig->execute_select("select invoice_sunat_id,tramaxmlfirmado, tramazipcdr from invoice_sunat where idventa='".$_POST['idpago']."' and  tramazipcdr='-'",1);
     $notacredito= $objconfig->execute_select("select iddocumento from nota_credito_debito where idventa='".$_POST['idpago']."' limit 1",1);

     /* echo "select tramaxmlsinfirma from invoice_sunat where idventa='".$_POST['idpago']."'";*/
    //echo ($invoice_sunat[2]); 
	
        if($invoice_sunat[1][0]['tramazipcdr']!="-"){
            echo '{"status":false,"msg":"Comprobante ya fue enviado!"}';
            return;
        }
    /* if($invoice_sunat[1][0]['tramaxmlfirmado']){

    } */
    $pago=$objconfig->execute_select("Select idcomprobante, nrodocumento from pago where itempago='".$_POST['idpago']."'");
    //var_dump($pago[1]["idcomprobante"]); 
    $data['TramaXmlFirmado']=$invoice_sunat[1][0]['tramaxmlfirmado'];
     $data['Ruc']="20494013453";
     $data['UsuarioSol']=USUARIOSOL;
     $data['ClaveSol']=CLAVESOL;
     $data['IdDocumento']=$notacredito[1][0]['iddocumento'];
     $data['TipoDocumento']="07";
     
     $data['EndPointUrl']="https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService";
     echo json_encode($data);
     $res=$objconfig->generar_enviar($data);
    // echo json_encode($res); 
     if($res->Exito){
        $sql1="update invoice_sunat set mensajeerror='".$res->MensajeError."', mensajerespuesta='".$res->MensajeRespuesta."', nombrearchivo='".$res->NombreArchivo."', nroticketcdr='".$res->NroTicketCdr."', tramazipcdr='".$res->TramaZipCdr."', crespuesta_envio='0' where idventa='".$_POST['idpago']."' and tramazipcdr='-' and invoice_sunat_id='".$invoice_sunat[1][0]['invoice_sunat_id']."'";

        $objconfig->execute($sql1);
        $sql1="update pago set esta_envio='1' where itempago='".$_POST['idpago']."'";
        
        $objconfig->execute($sql1);
        echo '{"status":true,"msg":"'.$res->MensajeRespuesta.'"}';
    }else{
        $sql1="update invoice_sunat set mensajeerror='".explode('-',str_replace("'",'"',$res->MensajeError))[0]."' where idventa='".$_POST['idpago']."' and tramazipcdr='-' and invoice_sunat_id='".$invoice_sunat[1][0]['invoice_sunat_id']."'";
         $objconfig->execute($sql1);
        echo '{"status":false,"msg":"'.str_replace('"',"'",$res->MensajeError).'"}';
    }
     //echo json_encode($objconfig->generar_enviar($data));
     
?>
