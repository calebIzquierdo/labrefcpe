<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");
	
	include("../../objetos/class.funciones.php");
        
	include("../../objetos/num2letra.php");
	
	class impresion extends clsreporte
	{
		 function Header(){

            global $codbarra,$tPapel;

			// Para la firma del responsable del Equipo;

            $this->SetFont('Arial','',7);
            $h	=	2;
            $X	=	20; // POSICIÓN DE HORIZONTAL
            $Y	=	260;	// POSICIÓN VERTICAL
            $alto	=	5;
            $borde	=	0;
            $alineacion	=	'L';

            $altura	=	3;
            $ancho	=	40;
            $X2		=	10;
            $Y2		=	5;
            $ancho2	=	40;
			$alineacion2	=	'C';
           

			$this->Image("../../img/head_Vertical.jpg",10,1,195,15,'JPG',"http://hospitaltarapoto.gob.pe/");
		
			
			$fecha = date("d/m/Y ");
			$hora = date("h:i:s a ");
            $this->SetXY(182,18);
            $this->SetFont('Arial','',8);
            $this->Cell(85, 3,"F.I: ".$fecha,0,1,'L');
			$this->SetXY(182,21);
            $this->Cell(85, 3,"H.I: ".$hora,0,1,'L');
			global $finicial,$ffinal;
			
	
        }

		function contenido($nromovimiento)
		{
			$nromovimiento 	= $_GET["nromovimiento"];

			$h = 5;
			$X		=	30; // POSICIÓN DE HORIZONTAL
				// POSICIÓN VERTICAL
			$alto	=	40;
			$borde	=	0;
			$alineacion	=	'L';
			$ancho	=	110;

			
			$query = $this->execute_select("select idpago, fecharecepcion, tipoatencion, procedencia,nombre_usuario,estareg,estado_examen,mred,rdes,
											codbarra,tipexamen,nrodocumento,tip_comprob,fechaemision,itempago, idingresomuestra,idcliente,idtipoatencion
										FROM vista_pagos
										where idpago=".$nromovimiento);

			$ckiente = $this->execute_select("select razonsocial, direccion, ruc from cliente where idcliente=".$query[1]["idcliente"]);
			
			$this->Ln(10);            
			$this->Cell(10,5,"Cliente ",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(100,5,strtoupper(utf8_decode($ckiente[1]["razonsocial"])),0,0,'L');
		
			$this->Cell(10,5,utf8_decode("Fecha"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(20,5,$this->FechaDMY2($query[1]["fechaemision"]),0,1,'L');
			
			$this->Cell(10,5,utf8_decode("Ruc"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(50,5,$ckiente[1]["ruc"],0,0,'L');
			
			$this->Cell(15,5,utf8_decode("Dirección:"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,strtoupper(utf8_decode($ckiente[1]["direccion"])),0,0,'L');

			$count = 0;

            $this->Ln(10);
		    $this->SetWidths(array(15,15,120,20,20));
			$this->SetAligns(array('C','C','C','C'));
			$this->Row(array("Item","Cantidad",utf8_decode("DESCRIPCIÓN"),"P.U", "SUB_TOTAL"));
			//echo $query;

			$this->SetWidths(array(15,15,120,20,20));
			$this->SetAligns(array('C','C','L','C','C'));
			
			$datos = "select fecharecepcion, tipoatencion, procedencia,estado_examen,idtipoatencion,codbarra,tipexamen,fechaemision,valor,monto,descuento,cantidad
					  FROM vista_pagos where itempago=".$query[1]["itempago"]." order by codbarra asc";	
			$rowF = $this->execute_select($datos,1);		
			
			$count=0;
			$total=0;
			$descontar=0;
			$totalPagar=0;
			
			foreach($rowF[1] as $rM)
			{
				$count++;
				$total+=floatval($rM["valor"])*floatval($rM["cantidad"]);
				$descontar=$rM["descuento"];
				
				//$cost	=	$this->execute_select($prue)		;	
							
				$this->Row(array($count,floatval($rM["cantidad"]),$rM["fecharecepcion"]." - ".$rM["codbarra"]." - ".strtoupper(utf8_decode($rM["tipexamen"])),number_format($rM["valor"],2),number_format(floatval($rM["valor"])*floatval($rM["cantidad"]),2)),0);
			}
			 $this->SetFont('Arial','B',8);
			$this->Row(array($count+1,1,"DESCUENTO",number_format($rM["descuento"],2),number_format($descontar,2)),0);
			
			$this->Ln(2);
			$this->Ln(10);
			$totalPagar = $total-$descontar;
			if ($totalPagar==0){
			$this->Cell(140,5,"SON: CERO CON 00/100  SOLES  - S.E.U.O",0,0,'L');}
			else {
				$this->Cell(140,5,CantidadEnLetra($totalPagar)." SOLES  - S.E.U.O ",0,0,'L');
			}
            $this->Cell(25,5,"Total S.",0,0,'R');
			$this->Cell(20,5,number_format($totalPagar,2),0,1,'R');
		}
		function Footer(){
		//	$this->Image("../../img/firmaraul.jpg",120,240,80,50,'JPG',"http://hospitaltarapoto.gob.pe/");
         //   $this->Image($_SERVER['DOCUMENT_ROOT']."/sgl/resources/imagenes/firmaraul.jpg",120,170,80,50);



            $this->SetY(-10);

            $this->SetFont('Arial','I',6);

            $this->SetTextColor(0);

            $this->SetLineWidth(.1);

            $this->Cell(0,.1,"",1,1,'C',true);

            $this->Ln(1);



            $this->SetFont('Arial','I',6);

            $this->Cell(0,4,utf8_decode("Jr. Túpac Amaru 5° cuadra, teléfonos: 042-526451 - 042-526589"),0,0,'L');

			

        }        
	}
	
	$nromovimiento 	= $_GET["nromovimiento"];
	
	$pdf=new impresion();
	$pdf->AliasNbPages();
    $pdf->AddPage();
	$pdf->contenido($pc_nro);
	$pdf->Output();	
	
?>