<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");

	include("../../objetos/class.funciones.php");
	
	
	class impresion extends clsreporte
	{
		function Header(){
			global $finicial,$ffinal;
			
         	$this->SetFont('Arial','',7);
           
			$this->Image("../../img/head_Vertical.jpg",10,1,195,15,'JPG',"http://hospitaltarapoto.gob.pe/");
					
			$fecha = date("d/m/Y ");
			$hora = date("h:i:s a ");
			
            $this->SetXY(182,16);
            $this->SetFont('Arial','',8);
            $this->Cell(85, 3,"F.I: ".$fecha,0,1,'L');
			$this->SetXY(182,19);
            $this->Cell(85, 3,"H.I: ".$hora,0,1,'L');
			
			
		
			$this->SetFont('Arial','B',12);
			$tit1 	= "REPORTE DE DOCUMENTOS EMITIDOS";
			$tit2 	= "DESDE: ".$this->FechaDMY($finicial)." -  HASTA: ".$this->FechaDMY($ffinal);
		//	$tit3	= "";
			
			$this->Cell(190,5,utf8_decode($tit1),0,1,'C');	
			$this->Cell(190,5,utf8_decode($tit2),0,1,'C');
			//$this->Cell(190,5,utf8_decode($tit3),0,1,'C');
			
	
        }

		function contenido($finicial,$ffinal,$tpref )
		{
            $finicial = $_GET["finicio"];
            $ffinal = $_GET["ffinal"];
            $tpref = $_GET["idcomp"];

            $and = "";
            if($tpref !=0){
                $and = " idcomprobante = ".$tpref." and ";
            }

            $this->Ln(7);
			$h = 7;
			
            $this->SetWidths(array(10, 20, 30, 20, 90,20 ));
            $this->SetFont('Arial','B',8);
            $this->SetAligns(array('C','C','C','C','C','C'));
            $this->Row(array(utf8_decode("N°"),utf8_decode("EMISIÓN"),"TIPO DOCUMENTO",utf8_decode("NÚMERO"),"CLIENTE","MONTO"));

            $consulta = "select itempago,itempago, fechaemision from pago 
						where ".$and." estareg!=0  and fechaemision between '".$finicial."' and '".$ffinal."'  
                        group by itempago,fechaemision order by fechaemision asc ";
			// echo $consulta;
            $rows = $this->execute_select($consulta,1);
			
			$count = 0;
			$total  = 0;
			
		
			
            $this->SetFont('Arial','',7);

            foreach($rows[1] as $rf)
            {
                $count++;
				$tpag  = 0;

                $fecharef = $this->FechaDMY($rf["fechaemision"]);
				
				$pago = $this->execute_select("select  idcliente,idcomprobante,nrodocumento, valor, idingresomuestra , monto,descuento
									from pago  WHERE itempago='".$rf["itempago"]."' AND estareg!=0" );
				
				
				$tipcomp = $this->execute_select("select  descripcion from tipo_comprobante where idcomprobante='".$pago[1]["idcomprobante"]."'" );
				$comp = $tipcomp[1]['descripcion'];
			
				$stot = $this->execute_select("select  sum(valor) as stotal from pago WHERE itempago='".$rf["itempago"]."' AND estareg!=0" );
				
				$tpag = $stot[1]['stotal']-$pago[1]['descuento'];
			
				$clie = $this->execute_select("select  ruc|| ' - ' || razonsocial as cliente from cliente where idcliente='".$pago[1]["idcliente"]."'" );
				$cliente = $clie[1]['cliente'];

                $this->SetWidths(array(10, 20, 30, 20, 90,20 ));
				$this->SetFont('Arial','B');
				$this->SetAligns(array('C','C','C','L','L','C'));
                $this->Row(array($count,$fecharef,$comp,strtoupper(utf8_decode($pago[1]["nrodocumento"])),strtoupper(utf8_decode($cliente)),number_format($tpag,2) ));
				$total += $tpag ;
            }
			 $this->SetFont('Arial','B',8);
			$this->SetWidths(array(170, 20 ));
			$this->SetAligns(array('R','C'));
			$this->Row(array("Total S/.",number_format($total,2) ));
		
            $this->SetFont('Arial','',8);
			$this->Ln(5);
			$this->Cell(35,5,"TOTAL REGISTROS ==>",'T',0,'L');
			$this->Cell(160,5,$count,'T',1,'L');
				
			
        }
		function Footer(){
		
            $this->SetY(-10);
            $this->SetFont('Arial','I',6);
            $this->SetTextColor(0);
            $this->SetLineWidth(.1);
            $this->Cell(0,.1,"",1,1,'C',true);
            $this->Ln(1);

            $this->SetFont('Arial','I',6);
            $this->Cell(0,4,utf8_decode("Jr. Túpac Amaru 5° cuadra, teléfonos: 042-526451 - 042-526589"),0,0,'L');
			$this->Cell(0,4,'',0,0,'L');
			$this->Cell(0,4,'Pag. '.$this->PageNo().' de {nb}',0,0,'R');
			

        } 

	
	}

    $finicial 	= $_GET["finicio"];
	$ffinal		= $_GET["ffinal"];
    $fecha      = date("d/m/Y h:i:s a ");
    $hora       = date("h:i:s a ");

    //$pdf = new impresion('L','mm','A4');
    $pdf = new impresion();
    $pdf->AddPage();
    $pdf->AliasNbPages();
	$pdf->contenido($finicial,$ffinal,$tpref);
	$pdf->Output('ReporteMuestras'.$hora.'.pdf', 'I');
	

?>