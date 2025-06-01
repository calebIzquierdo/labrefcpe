<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
    $objconfig = new conexion();
    $objconfig->table 	= "invoice_sunat";
	$objconfig->campoId	= "invoice_sunat_id";
	$certificado = file_get_contents(
        '../../admin/assets/certificado/C22071466245.pfx');
    $certificado= base64_encode($certificado);
	$invoice_sunat= $objconfig->execute_select("select invoice_sunat_id,tramaxmlsinfirma, tramaxmlfirmado from invoice_sunat where idventa='".$_POST['idpago']."'",1);
    if($invoice_sunat[2]==0){
        
        echo '{"status":false,"msg":"Pago no cuenta con factura generada"}';
        return;
    }
    if($invoice_sunat[1][0]['tramaxmlfirmado']){
        echo '{"status":false,"msg":"Comprobante ya fue firmado!"}';
        return;
    }
    $data["CertificadoDigital"]= $certificado;
    $data["PasswordCertificado"]= PASSCER;
    $data["TramaXmlSinFirma"]= $invoice_sunat[1][0]['tramaxmlsinfirma'];
    $data["ValoresQr"]="";
    //echo json_encode($data);
    $res=$objconfig->generar_firma($data);
    if($res->Exito){
        $sql1="update invoice_sunat set mensajeerror='".$res->MensajeError."', mensajerespuesta='Firma generada', crespuesta_firmado='0',resumenfirma='".$res->ResumenFirma."', tramaxmlfirmado='".$res->TramaXmlFirmado."' where idventa='".$_POST['idpago']."' and invoice_sunat_id='".$invoice_sunat[1][0]['invoice_sunat_id']."'";
        //echo $sql1;
        $objconfig->execute($sql1);
    	echo '{"status":true,"msg":"Firma generada"}';
	}else{
        $sql1="update invoice_sunat set mensajeerror='".explode('-',str_replace("'",'"',$res->MensajeError))[0]."' where idventa='".$_POST['idpago']."' and invoice_sunat_id='".$invoice_sunat[1][0]['invoice_sunat_id']."'";
	//echo $sql1;
    $objconfig->execute($sql1);
	echo '{"status":false,"msg":"Error al generar firma"}';
    }
    
    /* $data["status"]=true;*/
    //echo json_encode($data); 
    
?>
      
