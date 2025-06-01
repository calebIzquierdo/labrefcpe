<?php
    if(!session_start()){session_start();}
    include("../../objetos/class.pdfelectronico.php");
    include("../../objetos/qrcode/qrlib.php");
	include("../../objetos/pdf/barcode.inc.php");
	include("../../objetos/class.numToLet.php");
    //var_dump($_SESSION);
	class GenerarPDFComprobante extends PdfElectronico
	{
        function Header($item_pago){
            $query = $this->execute_select("SELECT E.descripcion, E.ruc, E.direccion FROM usuarios U inner join establecimiento E on (U.idestablecimiento=E.idestablecimiento) WHERE U.idusuario='".$_SESSION["id_user"]."';");
            $this->SetFont('Courier', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
                $textypos = 5;
            /* if(strlen($query[1]['descripcion'])>33){
                $descriptionArray=str_split($query[1]['descripcion'], 33);
                for($i=0;$i<count($descriptionArray);$i++){
                    $this->setXY(5, $textypos);
                    if($i==0){
                        $this->Cell(0, 0, ($descriptionArray[$i]), 0, 1, "C");
                    }else{
                        $this->Cell(0, 0, ($descriptionArray[$i]), 0, 1, "C");
                    }
                    
                    $textypos += 4;
                }
                

            }else{ */
                $this->setXY(5, $textypos);
                $this->Cell(0, 0,utf8_decode('OFICINA DE GESTIÓN DE SERVICIOS DE SALUD'), 0, 1, "C");
                $textypos += 4;
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, utf8_decode('ESPECIALIZADA DE ALCANCE REGIONAL'), 0, 1, "C");
                $textypos += 4;
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, 'OGESS ESPECIALIZADA', 0, 1, "C");
                $textypos += 4;
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, 'RUC: 20494013453', 0, 1, "C");
                $textypos += 4;
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, utf8_decode('DIRECCIÓN FISCAL: JR. ANGEL DELGADO '), 0, 1, "C");
                $textypos += 4;
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, 'MOREY N503 TARAPOTO', 0, 1, "C");
                $textypos += 7;
                $this->SetFont('Courier', 'B', 11);    //Letra Arial, negrita (Bold), tam. 20
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, utf8_decode('LABORATORIO REFERENCIAL'), 0, 1, "C");
                $textypos += 4;
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, utf8_decode('SAN MARTÍN'), 0, 1, "C");
                $this->SetFont('Courier', 'B', 8); 
                $textypos += 7;
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, utf8_decode('DIRECCIÓN: TÚPAC AMARU CDRA 5 - MORALES'), 0, 1, "C");
                $textypos += 4;
            //}direccion: tupac amaru crd5 - Morales
            /* if($query[1]['ruc']){
                $this->setXY(5, $textypos);
                $this->Cell(0, 0, ($query[1]['ruc']), 0, 1, "C");
                $textypos += 4 ;
            } */
           

            /* $this->Image("../../img/head_Vertical.jpg",10,$textypos,60,25,'JPG',"http://hospitaltarapoto.gob.pe/");
			$textypos = 41; */
            /* if($query[1]['direccion']){
                if(strlen($query[1]['direccion'])>28){
                    $descriptionArray=str_split($query[1]['direccion'], 28);
                    for($i=0;$i<count($descriptionArray);$i++){
                        $this->setXY(5, $textypos);
                        if($i==0){
                            $this->Cell(0, 0, ($descriptionArray[$i]), 0, 1, "C");
                        }else{
                            $this->Cell(0, 0, ($descriptionArray[$i]), 0, 1, "C");
                        }
                        
                        $textypos += 4;
                    }
                    
    
                }else{
                    $this->setXY(5, $textypos);
                    $this->Cell(0, 0, ($query[1]['direccion']), 0, 1, "C");
                    $textypos += 4;
    
                }
            } */
            $this->Line(1, $textypos, 79, $textypos);
            
            $textypos += 4;
            $query = $this->execute_select("select P.idcomprobante, TC.descripcion, P.nrodocumento from pago P inner join tipo_comprobante TC on (P.idcomprobante= TC.idcomprobante) where P.itempago='".$item_pago."';");
            $this->setXY(5, $textypos);
            $this->SetFont('Courier', 'B', 10);    //Letra Arial, negrita (Bold), tam. 20
            $this->Cell(0, 0, utf8_decode($query[1]['descripcion']), 0, 1, "C");
            $textypos += 4;
            $this->setXY(5, $textypos);
            $this->SetFont('Courier', 'B', 11);
            $this->Cell(0, 0, $query[1]['nrodocumento'], 0, 1, "C");
            $textypos += 5;
            $this->Line(1, $textypos, 79, $textypos);
			
        }
        function contenido($item_pago){
            $textypos=$this->GetY()+8;
            $query = $this->execute_select("select P.fecharecepcion, P.itempago, P.horareg, P.idingresomuestra, P.descuento, P.monto1, P.codbarra, P.monto, C.razonsocial, C.ruc, C.direccion from pago P inner join cliente C on (P.idcliente= C.idcliente) where P.itempago='".$item_pago."';");
            
            $this->SetXY(2, $textypos);
            $this->SetFont('Courier', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
            $this->Cell(0, 0, utf8_decode("FECHA EMISIóN: ") . date('d/m/Y', strtotime($query[1]['fecharecepcion'])) . str_pad("HORA: " . date("H:i:s", strtotime($query[1]['horareg'])), 17, ' ', STR_PAD_LEFT));
            $textypos += 4; 
            $this->SetXY(2, $textypos);
            $this->Cell(0, 0, utf8_decode("NOMBRE O RAZÓN SOCIAL: ") . str_pad("RUC/DNI:" . utf8_decode($query[1]['ruc']), 19, ' ', STR_PAD_LEFT));
            $textypos += 2;
            $this->SetXY(2, $textypos);
            $this->MultiCell(0, 3, utf8_decode($query[1]['razonsocial']));
            $textypos += 4;
            $this->SetXY(2, $textypos);
            $this->MultiCell(0, 3, utf8_decode("DIRECCIóN: ") . str_split(utf8_decode($query[1]['direccion']), 27)[0]);

            $textypos += 4;
            $this->Line(1, $textypos, 79, $textypos);
            $textypos += 2;
            $this->SetXY(2, $textypos);
            $this->Cell(0, 0, utf8_decode("CANT. DESCRIPCIÓN        P. UNIT   SUB TOTAL"));
            $textypos += 2;
            $this->Line(1, $textypos, 79, $textypos);
            $textypos += 2;
            $datos = "select fecharecepcion, tipoatencion, procedencia,estado_examen,idtipoatencion,codbarra,tipexamen,fechaemision,valor,monto,descuento,cantidad
					  FROM vista_pagos where itempago=".$query[1]["itempago"]." order by codbarra asc";	
			$rowF = $this->execute_select($datos,1);	
            $count=0;
			$total=0;
			$descontar=0;
			$totalPagar=0;
            foreach ($rowF[1] as $rM) {
                $count++;
				$total+=floatval($rM["valor"])*floatval($rM["cantidad"]);
				$descontar=$rM["descuento"];
                $this->SetXY(2, $textypos);
                $this->MultiCell(0, 3, '*' . utf8_decode($rM["tipexamen"]));
                $y3 = $this->GetY();
                $textypos = $y3 + 2;
                $this->SetXY(2, $textypos);
                $this->Cell(0, 0, str_pad(number_format(floatval($rM["cantidad"]), 2, '.', ','), (8 - strlen(floatval($rM["cantidad"]))) + strlen(floatval($rM["cantidad"])), ' ', STR_PAD_LEFT) . " ".str_pad(utf8_decode("ZZ"), 10, ' ', STR_PAD_LEFT)." " . str_pad(number_format($rM["valor"], 2, '.', ','), 12, ' ', STR_PAD_LEFT) . " " . str_pad(number_format(($rM["cantidad"] * $rM["valor"]), 2, '.', ','), (9 - strlen(number_format(($rM["cantidad"] * $rM["valor"]), 2, '.', ','))) + strlen(number_format(($rM["cantidad"] * $rM["valor"]), 2, '.', ',')), ' ', STR_PAD_LEFT));
                $textypos += 3;
            }
            $this->Line(1, $textypos, 79, $textypos);
            $textypos += 2;
            $this->SetXY(2, $textypos);
            $literal = new EnLetras();
            $this->MultiCell(0, 3, "SON: " . strtoupper($literal->ValorEnLetras($query[1]['monto1'], "con")));
            $y4 = $this->GetY();
            $textypos = $y4 + 2;
            $this->Line(1, $textypos, 79, $textypos);
            $textypos += 3;
            $this->SetXY(23, $textypos);
            $this->Cell(0, 0, "OP. EXONERADAS  : S/" . str_pad(number_format($query[1]['monto1'], 2, '.', ','), (10 - strlen($query[1]['monto1'])) + strlen($query[1]['monto1']), ' ', STR_PAD_LEFT));
            $textypos += 3;
            $this->SetXY(23, $textypos);
            $this->Cell(0, 0, "DESCUENTO       : S/" . str_pad(number_format($query[1]['descuento'], 2, '.', ','), (10 - strlen($query[1]['descuento'])) + strlen($query[1]['descuento']), ' ', STR_PAD_LEFT));
            $textypos += 3;
            $this->SetXY(23, $textypos);
            $this->Cell(0, 0, "IGV             : S/" . str_pad(number_format(0, 2, '.', ','), (10 - strlen(0)) + strlen(0), ' ', STR_PAD_LEFT));
            $textypos += 3;
            $this->SetXY(23, $textypos);
            $this->Cell(0, 0, "TOTAL A PAGAR   : S/" . str_pad(number_format($query[1]['monto'], 2, '.', ','), (10 - strlen($query[1]['monto'])) + strlen($query[1]['monto']), ' ', STR_PAD_LEFT));
            $textypos += 2;
            $this->Line(1, $textypos, 79, $textypos);
            
            $textypos += 5;
            new barCodeGenrator($query[1]["codbarra"],1,"../../img/codbarra.gif",190,130,VERDADERO);
			
			$texto_qr = utf8_decode("Laboratorio Referencial Regional de Salud Pública de San Martín. \nCodigo: ").$query[1]['codbarra']." - ".$query[1]["idingresomuestra"].".\n".trim($query[1]["monto"]).".";
			$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;
    
			//html PNG location prefix
			$PNG_WEB_DIR = 'img/';
			
			//ofcourse we need rights to create temp dir
			if (!file_exists($PNG_TEMP_DIR))
				mkdir($PNG_TEMP_DIR);
            $filename = $PNG_TEMP_DIR.'codigoqr.png';
            $errorCorrectionLevel = 'L';
			if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
			$errorCorrectionLevel = $_REQUEST['level'];    

			$matrixPointSize = 4;
			if (isset($_REQUEST['size']))
				$matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

			if (isset($_REQUEST['data'])) { 
				//it's very important!
				if (trim($texto_qr) == '')

				die('data cannot be empty! <a href="?">back</a>');

				$filename = $PNG_TEMP_DIR.'codigoqr'.md5($texto_qr.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
				QRcode::png($texto_qr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
			} else {    
				QRcode::png($texto_qr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
			}   
            $this->SetXY(23, $textypos);
            $this->MultiCell(0, 3, utf8_decode("Representación impresa del comprobante electrónico, esta puede ser consultada en ...."));
            $qr = "img/codigoqr.png";
            $this->Image($qr, 5, $textypos, 18, 18);
            $y5 = $this->GetY();
            $textypos = $y5 + 8;
            $this->Line(1, $textypos, 79, $textypos);
            $textypos += 3;
            $this->SetXY(8, $textypos);
            $this->Cell(0, 0, utf8_decode("BIENES TRANSFERIDOS EN LA AMAZONÍA"), 0, 1, "C");
            $textypos += 3;
            $this->SetXY(9, $textypos);
            $this->Cell(0, 0, "PARA SER CONSUMIDOS EN LA MISMA", 0, 1, "C");
            $textypos += 6;
            $this->SetXY(0, $textypos);
            $this->Cell(0, 0, "GRACIAS POR SU PREFERENCIA...!!", 0, 1, "C");
        }
        function Footer(){

        }
    }
    $pdf_filename = "docs/temp.pdf";
    
    $item_pago 	= $_GET["item_pago"];
//try{
    $pdf=new GenerarPDFComprobante();
	$pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Header($item_pago);
	$pdf->contenido($item_pago);
    if($_GET["pdf_show"]=='1'){
        $pdf->Output();	
    }else{
        if(!file_exists($pdf_filename) || is_writable($pdf_filename)){
            $pdf->Output($pdf_filename, "F");
        } else { 
            unlink($pdf_filename);
            $pdf->Output($pdf_filename, "F");
        }
        echo '{"status":true,"msg":"Comprobante generado"}';
    }
/*}catch (Exception $e){
    echo '{"status":false,"msg":"Error al generar comprobante"}';
}*/
	
?>
