<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //include("../../objetos/phpmailer/PHPMailer.php");
    require '../../objetos/phpmailer/Exception.php';
    require '../../objetos/phpmailer/PHPMailer.php';
    require '../../objetos/phpmailer/SMTP.php';
	include("../../objetos/class.conexion.php");

    $pdf_filename="docs/temp.pdf";
    $xml_filename="docs/temp.xml";
	$objconfig = new conexion();
    $pago= $objconfig->execute_select("select itempago from pago where idpago='".$_POST['idpago']."'",1);
    //echo "select itempago from pago where idpago='".$_POST['idpago']."'";
    /* $_POST['idpago']=$pago["1"][0]['itempago']; */
    //echo json_encode($_POST['idpago']);
    $invoice_sunat= $objconfig->execute_select("select tramaxmlfirmado from invoice_sunat where idventa='".$pago["1"][0]['itempago']."' and( tramaxmlfirmado IS NOT NULL)",1);
    /* echo "select tramaxmlsinfirma from invoice_sunat where idventa='".$_POST['idpago']."'";*/
    //echo ($invoice_sunat[2]); 
	if($invoice_sunat[2]==0){
        echo '{"status":false,"msg":"Comprobante aun no fue firmado!"}';
        return;
    }
    $consul = "select TC.descripcion, P.nrodocumento, P.fecharecepcion, P.horareg, P.monto, C.razonsocial, SI.tramaxmlfirmado 
    from pago P right join tipo_comprobante TC on (P.idcomprobante= TC.idcomprobante) left join cliente 
    C on (P.idcliente=C.idcliente) left join invoice_sunat SI on (P.itempago=SI.idventa) where P.idpago='".$_POST['idpago']."'";
	//echo $consul;
    $query1 = $objconfig->execute_select($consul, 1) ;
    $data= base64_decode($query1[1][1]['tramaxmlfirmado']);
    /* $data = simplexml_load_string($query1[1][0]['tramaxmlfirmado']);*/
    
    if(!file_exists($xml_filename) || is_writable($xml_filename)){
        fwrite(fopen($xml_filename,'w'),$data);
    } else { 
        unlink($xml_filename);
        fwrite(fopen($xml_filename,'w'),$data);
    } 
try{
    $mail = new PHPMailer();
    /**Configuracion de servidor smtp */
    $mail->SMTPDebug=0;
    $mail->isSMTP();
    /*$mail->Mailer = "smtp";
    $mail->Host='mail.accordtechsoft.com';
    $mail->SMTPAuth= true;
    $mail->Username='facturacion@accordtechsoft.com';
    $mail->Password='Huayane83';
    $mail->SMTPSecure='tls';
    $mail->Port=587; */
    $mail->Mailer = "smtp";
    $mail->Host = "mail.smtp2go.com";
    $mail->Port = "2525";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = "smtp_username";
    $mail->Password = "smtp_password";


    /* $mail->Mailer = "smtp";
    $mail->Host = "mail.accordtechsoft.com";
    $mail->Port = "587"; 
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = "facturacion@accordtechsoft.com";
    $mail->Password = "Huayane83"; */

    /* $mail->Host='p3plzcpnl489515.prod.phx3.secureserver.net';
    $mail->SMTPAuth= true;
    $mail->Username='facturacion@accordtechsoft.com';
    $mail->Password='Huayane83';
    $mail->SMTPSecure='tls';
    $mail->Port=465; */
    
    /**Asignacion de mails*/

    $mail->setFrom ("facturacion@accordtechsoft.com","Lab. Regional Hopital II");
    $mail->AddAddress($_POST['email']);
    /**Configure content */
    $mail->isHTML(true);
    $mail->Subject = 'NOTA DE CREDITO '.$query1[1][1]['nrodocumento'];
    $body="";
    $body.='<hr style="color:gray; padding:0; margin: 0"/>';
    $body.='<h1 style="width: 100%; text-align: center; color:blue; padding: .2rem 0 0rem 0; margin-bottom: 0">
    NOTA DE CREDITO
    </h1>';
    $body.='<h1 style="width: 100%; text-align: center; color:blue; padding: 0rem 0 .2rem 0; margin-top: 0">
    '.$query1[1]['descripcion'].' '.$query1[1][1]['nrodocumento'].'
    </h1>';
    $body.='<hr style="color:gray; padding:0"/>';
    $body.='<p style="font-size:1.2rem; color:dimgray; font-weight:bold">Hola '.$query1[1][1]['razonsocial'].'</p>';
    $body.='<p style="font-size:1.2rem; color:dimgray; font-weight:bold; margin: 0 0 .3rem 0">
    Adjuntamos NOTA DE CREDITO
    </p>';
    $body.='<p style="font-size:1.2rem; color:dimgray; font-weight:bold; padding: 0;margin:0">
    Detalle del comprobante electronico:
    </p>';

    $body.='<ul style="color:gray;margin:0.3rem 0;">
        <li>NOTA DE CREDITO '.$query1[1][1]['nrodocumento'].'</li>
        <li>Fecha de Emision: '.$query1[1][1]['fecharecepcion'].' '.$query1[1][1]['horareg'].'</li>
        <li>Total: S/.'.$query1[1][1]['monto'].'</li>
    </ul>';
    $body.='<hr style="color:gray; padding:0"/>';  

    $body.='<p style="font-size:.9rem; color:blue; padding: 0;margin:0">
    Tambien se adjunta en PDF el mismo documento, que puede ser 
    impresa y usada como una NOTA DE CREDITO emitida de manera tradicional.</p>';
    '<p style="font-size:1.2rem; color:dimgray; font-weight:bold; padding: 0;margin:0">Saludos.</p>';
    $mail->Body=$body;

    $mail->AddAttachment($pdf_filename,$query1[1][1]['descripcion'].' '.$query1[1][1]['nrodocumento'].'.pdf');
    $mail->AddAttachment($xml_filename,$query1[1][1]['descripcion'].' '.$query1[1][1]['nrodocumento'].'.xml');
    //$mail->addStringAttachment($query1[1][0]['tramaxmlfirmado'],$query1[1][0]['descripcion'].' '.$query1[1][0]['nrodocumento'].'.xml');
   
    
    if(!$mail->send()){
        echo '{"status":false,"msg":"'.$mail->ErrorInfo.'!"}';
    }else{
        echo '{"status":true,"msg":"Se envió el correo al '.$_POST['email'].'!"}';
    }
    unlink($pdf_filename);
    unlink($xml_filename);
}catch (Exception $e) {
    echo '{"status":false,"msg":"Error al generar correo!"}';
}
?>