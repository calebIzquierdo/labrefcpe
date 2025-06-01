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
										where itempago=".$nromovimiento);

	//		$query = $this->execute_select($sqlF); 
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
		    $this->SetWidths(array(20,20,100,20,20));
			$this->SetAligns(array('C','C','C','C'));
			$this->Row(array("Item","Cantidad",utf8_decode("DESCRIPCIÓN"),"P.U", "SUB_TOTAL"));
			//echo $query;

			$this->SetWidths(array(20,20,100,20,20));
			$this->SetAligns(array('C','C','L','C','C'));
			
			$datos = "select fecharecepcion, tipoatencion, procedencia,estado_examen,idtipoatencion,codbarra,tipexamen,fechaemision
					  FROM vista_pagos where itempago=".$nromovimiento;	
			$rowF = $this->execute_select($datos,1)		;		
			
			foreach($rowF[1] as $rM)
			{
				$count++;
				$prue = "select m.idmuestradetalle,m.idingresomuestra, m.idingresomuestra, m.idtipo_examen, m.idarea,m.idareatrabajo,  e.descripcion as tipexamen, 
					a.descripcion as area_destino,sat.descripcion as subarea, ep.valor as precio, ep.idtipoatencion
					from muestra_det as m
					inner join tipo_examen as e on(e.idtipo_examen=m.idtipo_examen)
					inner join areas as a on(a.idarea=m.idarea)
					inner join area_trabajo as sat on(sat.idareatrabajo=m.idareatrabajo)
					inner join tipo_examen_precio as ep on(ep.idtipo_examen=e.idtipo_examen)
					where m.idingresomuestra=".$query[1]["idingresomuestra"]." and ep.idtipoatencion=".$query[1]["idtipoatencion"]."  ";
				echo $prue;
				$cost	=	$this->execute_select($prue)		;	
								
				$this->Row(array($count,1,$rM["fecharecepcion"]." - ".$rM["codbarra"]." - ".strtoupper(utf8_decode($rM["tipexamen"])),number_format($cost[1]["precio"],2),number_format($cost[1]["precio"],2)),0);
			
			}
			$this->Ln(2);
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