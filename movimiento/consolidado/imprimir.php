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
			$tit1 	= "REPORTE CONSOLIDDO DE DOCUMENTOS EMITIDOS";
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
                $and = " p.idcomprobante = ".$tpref." and ";
            }

            $this->Ln(7);
			$h = 7;
			//CONSOLIDADO POR TIPO DE COMPROBANTE
				$this->SetFont('Arial','B',8);			
				$this->Cell(35,5,"POR TIPO COMPROBANTE",0,0,'L');
				$this->Ln(5);
				
				$this->SetWidths(array(10, 60, 30, 30, 30,30 ));
				$this->SetFont('Arial','B',8);
				$this->SetAligns(array('C','C','C','C','C','C'));
				$this->Row(array(utf8_decode("N°"),utf8_decode("COMPROBANTE"),"EMITIDO S/",utf8_decode("ANULADO S/"),"CANT EMI.","CANT ANU."));
				
				$consulta = "select p.idcomprobante,tc.descripcion as comprobante,
				sum(case when p.estareg <> 0 then p.total else 0 end) as emitido,
				sum(case when p.estareg = 0 then p.total else 0 end) as anulado,
				sum(case when p.estareg <> 0 then 1 else 0 end) as cantemitido,
				sum(case when p.estareg = 0 then 1 else 0 end) as cantanulado
				from vista_pagos_agrupado p
				inner join tipo_comprobante tc on tc.idcomprobante = p.idcomprobante
				where ".$and." p.fechaemision between '".$finicial."' and '".$ffinal."'
				group by p.idcomprobante,tc.descripcion";
			
				$rows = $this->execute_select($consulta,1);
				
				$count = 0;
				$totale  = 0;
				$totala  = 0;
				$totalce  = 0;
				$totalca  = 0;				
				
				$this->SetFont('Arial','',7);
				
				foreach($rows[1] as $rf)
				{
					$count++;
					$tpag  = 0;             
				
					
					$totale += $rf["emitido"];
					$totala += $rf["anulado"];
					$totalce += $rf["cantemitido"];
					$totalca += $rf["cantanulado"];

					$this->SetWidths(array(10, 60, 30, 30, 30,30 ));
					$this->SetFont('Arial','B');
					$this->SetAligns(array('C','C','C','C','C','C'));
					$this->Row(array($count,$rf["comprobante"],number_format($rf["emitido"],2),number_format($rf["anulado"],2),number_format($rf["cantemitido"]),number_format($rf["cantanulado"]) ));
					$total += $tpag ;
				}
				$this->SetFont('Arial','B',8);
				$this->SetWidths(array(70,30, 30, 30,30 ));
				$this->SetAligns(array('R','C','C','C','C'));
				$this->Row(array("Totales:",number_format($totale,2),number_format($totala,2),number_format($totalce),number_format($totalca)));
				$this->Ln(10);


			//CONSOLIDADO POR TIPO DE PAGO
				$this->SetFont('Arial','B',8);			
				$this->Cell(35,5,"POR TIPO PAGO",0,0,'L');
				$this->Ln(5);
				
				$this->SetWidths(array(10, 60, 30, 30, 30,30 ));
				$this->SetFont('Arial','B',8);
				$this->SetAligns(array('C','C','C','C','C','C'));
				$this->Row(array(utf8_decode("N°"),utf8_decode("TIPO PAGO"),"EMITIDO S/",utf8_decode("ANULADO S/"),"CANT EMI.","CANT ANU."));
				
				$consulta2 = "select p.idtipopago,tp.descripcion as tipopago, 
				sum(case when p.estareg <> 0 then p.total else 0 end) as emitido,
				sum(case when p.estareg = 0 then p.total else 0 end) as anulado,
				sum(case when p.estareg <> 0 then 1 else 0 end) as cantemitido,
				sum(case when p.estareg = 0 then 1 else 0 end) as cantanulado
				from vista_pagos_agrupado p
				inner join tipo_pago tp on tp.idtipopago=p.idtipopago
				where ".$and." p.fechaemision between '".$finicial."' and '".$ffinal."'
				group by p.idtipopago,tp.descripcion";
			
				$rows = $this->execute_select($consulta2,1);
				
				$countp = 0;
				$totalep = 0;
				$totalap  = 0;
				$totalcep  = 0;
				$totalcap  = 0;				
				
				$this->SetFont('Arial','',7);
				
				foreach($rows[1] as $rf)
				{
					$countp++;
					$tpag  = 0;             
				
					
					$totalep += $rf["emitido"];
					$totalap += $rf["anulado"];
					$totalcep += $rf["cantemitido"];
					$totalcap += $rf["cantanulado"];

					$this->SetWidths(array(10, 60, 30, 30, 30,30 ));
					$this->SetFont('Arial','B');
					$this->SetAligns(array('C','C','C','C','C','C'));
					$this->Row(array($countp,$rf["tipopago"],number_format($rf["emitido"],2),number_format($rf["anulado"],2),number_format($rf["cantemitido"]),number_format($rf["cantanulado"]) ));
					$total += $tpag ;
				}
				$this->SetFont('Arial','B',8);
				$this->SetWidths(array(70,30, 30, 30,30 ));
				$this->SetAligns(array('R','C','C','C','C'));
				$this->Row(array("Totales:",number_format($totalep,2),number_format($totalap,2),number_format($totalcep),number_format($totalcap)));
				$this->Ln(10);
				//CONSOLIDADO POR TIPO DE ATENCION        	
				$this->SetFont('Arial','B',8);			
				$this->Cell(35,5,"POR TIPO DE ATENCION",0,0,'L');
				$this->Ln(5);
				
				$this->SetWidths(array(10, 60, 30, 30, 30,30 ));
				$this->SetFont('Arial','B',8);
				$this->SetAligns(array('C','C','C','C','C','C'));
				$this->Row(array(utf8_decode("N°"),utf8_decode("TIPO ATENCION"),"EMITIDO S/",utf8_decode("ANULADO S/"),"CANT EMI.","CANT ANU."));
				
				$consulta2 = "select p.idtipoatencion,ta.descripcion as tipoatencion, 
				sum(case when p.estareg <> 0 then p.total else 0 end) as emitido,
				sum(case when p.estareg = 0 then p.total else 0 end) as anulado,
				sum(case when p.estareg <> 0 then 1 else 0 end) as cantemitido,
				sum(case when p.estareg = 0 then 1 else 0 end) as cantanulado
				from vista_pagos_agrupado p	
				inner join tipo_atencion ta on ta.idtipoatencion=p.idtipoatencion
				where ".$and." p.fechaemision between '".$finicial."' and '".$ffinal."'
				group by p.idtipoatencion,tipoatencion";
			
				$rows = $this->execute_select($consulta2,1);
				
				$countp = 0;
				$totalep = 0;
				$totalap  = 0;
				$totalcep  = 0;
				$totalcap  = 0;				
				
				$this->SetFont('Arial','',7);
				
				foreach($rows[1] as $rf)
				{
					$countp++;
					$tpag  = 0;             
				
					
					$totalep += $rf["emitido"];
					$totalap += $rf["anulado"];
					$totalcep += $rf["cantemitido"];
					$totalcap += $rf["cantanulado"];

					$this->SetWidths(array(10, 60, 30, 30, 30,30 ));
					$this->SetFont('Arial','B');
					$this->SetAligns(array('C','C','C','C','C','C'));
					$this->Row(array($countp,$rf["tipoatencion"],number_format($rf["emitido"],2),number_format($rf["anulado"],2),number_format($rf["cantemitido"]),number_format($rf["cantanulado"]) ));
					$total += $tpag ;
				}
				$this->SetFont('Arial','B',8);
				$this->SetWidths(array(70,30, 30, 30,30 ));
				$this->SetAligns(array('R','C','C','C','C'));
				$this->Row(array("Totales:",number_format($totalep,2),number_format($totalap,2),number_format($totalcep),number_format($totalcap)));
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
