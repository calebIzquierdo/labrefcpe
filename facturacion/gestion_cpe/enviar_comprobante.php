<?php
     if(!session_start()){session_start();}
        
     include("../../objetos/class.conexion.php");
     $objconfig = new conexion();
     $invoice_sunat= $objconfig->execute_select("select invoice_sunat_id,tramaxmlfirmado, tramazipcdr from invoice_sunat where idventa='".$_POST['idpago']."'",1);
    /* echo "select tramaxmlsinfirma from invoice_sunat where idventa='".$_POST['idpago']."'";*/
    //echo ($invoice_sunat[2]); 
	if($invoice_sunat[2]==0){
        echo '{"status":false,"msg":"Pago no cuenta con factura generada"}';
        return;
    }else{
        if($invoice_sunat[1][0]['tramazipcdr']!="-"){
            echo '{"status":false,"msg":"Comprobante ya fue enviado!"}';
            return;
        }
    }
    if(!($invoice_sunat[1][0]['tramaxmlfirmado'])){
        echo '{"status":false,"msg":"Comprobante aun no fue firmado!"}';
        return;
    }
    $pago=$objconfig->execute_select("Select idcomprobante, nrodocumento from pago where itempago='".$_POST['idpago']."'");
    //var_dump($pago[1]["idcomprobante"]); 
    $data['TramaXmlFirmado']=$invoice_sunat[1][0]['tramaxmlfirmado'];
     $data['Ruc']="20494013453";
     $data['UsuarioSol']=USUARIOSOL;
     $data['ClaveSol']=CLAVESOL;
     $data['IdDocumento']=$pago[1]['nrodocumento'];
     $data['TipoDocumento']="";
     if($pago[1]['idcomprobante']==2){
        $data['TipoDocumento']="03";
     }
     if($pago[1]['idcomprobante']==3){
        $data['TipoDocumento']="01";
     }
     $data['EndPointUrl']="https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService";
     //echo json_encode($data);
    /* echo json_encode($data); */

     $res=$objconfig->generar_enviar($data);
     
     if($res->Exito){
        $sql1="update invoice_sunat set mensajeerror='".$res->MensajeError."', mensajerespuesta='".$res->MensajeRespuesta."', nombrearchivo='".$res->NombreArchivo."', nroticketcdr='".$res->NroTicketCdr."', tramazipcdr='".$res->TramaZipCdr."', crespuesta_envio='0' where idventa='".$_POST['idpago']."' and invoice_sunat_id='".$invoice_sunat[1][0]['invoice_sunat_id']."'";
        /* echo $sql1; */
        $objconfig->execute($sql1);
        $sql1="update pago set esta_envio='1' where itempago='".$_POST['idpago']."'";
        
        $objconfig->execute($sql1);
        echo '{"status":true,"msg":"'.$res->MensajeRespuesta.'"}';
    }else{
        $sql1="update invoice_sunat set mensajeerror='".explode('-',str_replace("'",'"',$res->MensajeError))[0]."' where idventa='".$_POST['idpago']."' and invoice_sunat_id='".$invoice_sunat[1][0]['invoice_sunat_id']."'";
	//echo $sql1;
    $objconfig->execute($sql1);
    echo '{"status":false,"msg":"'.str_replace('"',"'",$res->MensajeError).'"}';
    }
     //echo json_encode($objconfig->generar_enviar($data));
     
?>
