<?php
    if(!session_start()){session_start();}
            
    include("../../objetos/class.conexion.php");
    $objconfig = new conexion();
    $invoice_sunat= $objconfig->execute_select("select nroticketcdr from invoice_sunat where idventa='".$_POST['idpago']."'",1);
    $pago=$objconfig->execute_select("Select nrodocumento, idcomprobante from pago where itempago='".$_POST['idpago']."'");
   if($invoice_sunat[2]==0){
      echo '{"status":false,"msg":"Pago no cuenta con factura generada"}';
      return;
   }elseif($invoice_sunat[1][0]['nroticketcdr']=='-'){
      echo '{"status":false,"msg":"Factura aun no su enviada"}';
      return;
   }
    //var_dump($invoice_sunat[1][0]);
    $data["Serie"]=explode('-',$pago[1]['nrodocumento'])[0];
    $data["Numero"]=explode('-',$pago[1]['nrodocumento'])[1];
    $data["Ruc"]="20494013453";
    $data["UsuarioSol"]=USUARIOSOL;
    $data["ClaveSol"]=CLAVESOL;
    $data['TipoDocumento']="";
    if($pago[1]['idcomprobante']==2){
       $data['TipoDocumento']="03";
    }
    if($pago[1]['idcomprobante']==3){
       $data['TipoDocumento']="01";
    }
    $data["EndPointUrl"]='https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService';
    $res=$objconfig->consulta_comprobante($data);
    //echo json_encode($res);
    if(!$res->Exito){
      if($res->MensajeError){
         echo '{"status":false,"msg":"'.str_replace('"',"'",$res->MensajeError).'"}';
      }else{
         echo '{"status":false,"msg":"'.str_replace('"',"'",$res->MensajeRespuesta).'"}';

      }
    }else{
       echo '{"status":true,"msg":"'.str_replace('"',"'",$res->MensajeRespuesta).'"}';

    }
?>