<?php 
	if(!session_start()){session_start();}
	
	include("../../../objetos/class.reporte.php");
	
	include("../../../objetos/class.funciones.php");
        
	include("../../../objetos/num2letra.php");
	
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
           

			$this->Image("../../../img/head_Vertical.jpg",10,1,195,15,'JPG',"http://hospitaltarapoto.gob.pe/");
			//$this->Image($_SERVER['DOCUMENT_ROOT']."/sgl/resources/imagenes/logo-resutados.jpg",$x,$y,$w,$h);
			
          //  $this->Ln($s);
			$this->SetXY($X2,$Y2);
            $this->MultiCell($ancho2,$altura," LABORATORIO REFERENCIAL DE SALUD PUBLICA - SAN MARTIN ",$borde, $alineacion2);
			
			$fecha = date("d/m/Y ");
			$hora = date("h:i:s a ");
            $this->SetXY(182,5);
            $this->SetFont('Arial','',8);
            $this->Cell(85, 3,"F.I: ".$fecha,0,1,'L');
			$this->SetXY(182,8);
            $this->Cell(85, 3,"H.I: ".$hora,0,1,'L');
			global $finicial,$ffinal;
			
			$this->Ln(10);
			$this->SetFont('Arial','B',12);
			$tit1 	= "UNIDAD: MICROBIOLOGÍA MÉDICA";
			$tit2 	= "DIAGNOSTICO MICOLÓGICO";
		//	$tit3	= "";
			
			$this->Cell(190,5,utf8_decode($tit1),0,1,'C');	
			$this->Cell(190,5,utf8_decode($tit2),0,1,'C');
			//$this->Cell(190,5,utf8_decode($tit3),0,1,'C');
			
			//$this->Ln(3);
			$this->SetFont('Arial','',10);
        }
		/*
		function cabecera()
		{
			global $finicial,$ffinal;
			$this->Ln(50);
			$this->SetFont('Arial','B',14);
			$tit1 	= "DETALLES DEL EQUIPO";
			$tit2 	= "";
			$tit3	= "";
			
			$this->Cell(190,5,utf8_decode($tit1),0,1,'C');	
			$this->Cell(190,5,utf8_decode($tit2),0,1,'C');
			$this->Cell(190,5,utf8_decode($tit3),0,1,'C');
			
			//$this->Ln(3);
			$this->SetFont('Arial','',10);
			
		}
		*/
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

			
			$query = $this->execute_select("select  iddxhongo,idtipourocultivo, fecharecepcion, codbarra, codlabref,  edadactual, fechatoma, idtipomuestra,
										fecharesultado, observaciones,  fechadigitacion, pacientes, nrodocumento, idresultado,
										medico_solicita, tipmuestra, tipseguro,estado_examen,idatendido,etiologia, exdirecto
										FROM vista_dxhongo 
										where iddxhongo=".$nromovimiento);
			
	//		$query = $this->execute_select($sqlF);
			
			$this->Ln(10);            
			$this->Cell(50,5,"Solicitante ",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(190,5,strtoupper(utf8_decode($query[1]["medico_solicita"])),0,1,'L');
		
			$this->Cell(50,5,utf8_decode("Muestra"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(190,5,strtoupper(utf8_decode($query[1]["tipmuestra"])),0,1,'L');
			
			$this->Cell(50,5,utf8_decode("Examen Solicitado"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,strtoupper(utf8_decode("MICOLÓGICO")),0,1,'L');
			
			$this->Cell(50,5,utf8_decode("Fecha de Obtención de Muestra"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,$this->FechaDMY2($query[1]["fecharecepcion"]),0,0,'L');

			$count = 0;
						
			$this->Ln(10);
            $this->Cell(10,5,"DATOS DEL PACIENTE",0,0,'L');
            $this->Ln(5);
		    $this->SetWidths(array(40,30,80,40));
			$this->SetAligns(array('C','C','C','C'));
			$this->Row(array("COD. LAB. REF","D.N.I","APELLIDOS Y NOMBRES","EDAD"));
			//echo $query;

			$this->SetWidths(array(40,30,80,40));
			$this->SetAligns(array('C','C','L','C'));
			$this->Row(array($query[1]["codlabref"],$query[1]["nrodocumento"],utf8_decode($query[1]["pacientes"]),utf8_decode($query[1]["edadactual"])),0);
			
			$this->Ln(10);
			$this->Cell(50,5,utf8_decode("Fecha del Resultado"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,$this->FechaDMY2($query[1]["fecharesultado"]),0,1,'L');
			$this->Ln(2);
			$this->SetWidths(array(50,5,135));
			$this->SetAligns(array('L','C','L'));
			if ($query[1]["idresultado"]==29){
				$this->Row(array("RESULTADO",":","NEGATIVO"));
			} else{
				$this->Row(array("RESULTADO",":","POSITIVO"));
			}
			$this->Ln(10);
			$this->Cell(50,5,utf8_decode("ETIOLOGÍA"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,utf8_decode($query[1]["etiologia"]),0,1,'L');
			$this->Ln(2);
			$this->Cell(50,5,utf8_decode("EXAMÉN DIRECTO"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,utf8_decode($query[1]["exdirecto"]),0,1,'L');
			$this->Ln(8);
			$this->Cell(10,5,utf8_decode("INTERPRETACIÓN"),0,1,'L');
			$this->Ln(2);
			$this->Cell(50,5,utf8_decode("NEGATIVO"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,utf8_decode("CULTIVO NEGATIVO A HONGOS"),0,1,'L');
			$this->Ln(2);
			$this->Cell(50,5,utf8_decode("POSITIVO"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,utf8_decode("CULTIVO POSITIVO A HONGOS"),0,1,'L');
			$this->Ln(5);
			$diag = $this->execute_select("select  descripcion from tipo_resultado where idresultado=".$query[1]["coddiagnostico"]);
	
			if ($query[1]["idtipourocultivo"]==2)
			{
			
				$this->Cell(50,5,utf8_decode("Germenes"),0,0,'L');
				$this->Cell(5,5,":",0,0,'C');
				$this->Cell(70,5,$diag[1]["descripcion"],0,1,'L');
				$this->Cell(50,5,utf8_decode("Recuento Celular"),0,0,'L');
				$this->Cell(5,5,":",0,0,'C');
				$this->Cell(120,5,$query[1]["observaciones"],0,1,'L');
				
				$this->Ln(5);
				$this->SetFont('Arial','B',10);
				$this->Cell(50,5,utf8_decode("Antibiograma"),0,1,'L');
				
			
				$h	=	2;
				$X	=	10; // POSICIÓN DE HORIZONTAL
				$Y	=	168;	// POSICIÓN VERTICAL
				$alto	=	5;
				$ancho	=	65;
				$borde	=	1;
				$alineacion2	=	'C';
				
				$this->Ln(2);
				$this->SetWidths(array(65,65,60));
				$this->SetAligns(array('C','C','C'));
				$this->Row(array("SENSIBLE","INTERMEDIO","RESISTENTE"));
				$this->SetFont('Arial','',8);
				$count1=0;
				$queryD = "select u.idantibiograma, a.descripcion from urocultivo_antibiograma as u
						  inner join antibiograma as a on(u.idantibiograma=a.idantibiograma)
						  where u.iddxhongo=".$nromovimiento." and u.idtipoantibiograma=1";
				$rowsD = $this->execute_select($queryD,1);
				
				foreach($rowsD[1] as $rd){
					$this->SetXY($X,$Y);
					$this->Cell($ancho,$alto,utf8_decode($rd["descripcion"]),$borde, $alineacion2);
					$Y+=5;
					$count1++;
				}
				
				$count2=0;
				$query2 = "select u.idantibiograma, a.descripcion from urocultivo_antibiograma as u
						  inner join antibiograma as a on(u.idantibiograma=a.idantibiograma)
						  where u.iddxhongo=".$nromovimiento." and u.idtipoantibiograma=2";
				$rows2 = $this->execute_select($query2,1);
				
				$X+=$ancho;
				$Y	=	168;
				foreach($rows2[1] as $rd2){
					$this->SetXY($X,$Y);
					$this->Cell($ancho,$alto,utf8_decode($rd2["descripcion"]),$borde, $alineacion2);
					$Y+=5;
					$count2++;
				}
				
				$count3=0;
				$query3 = "select u.idantibiograma, a.descripcion from urocultivo_antibiograma as u
						  inner join antibiograma as a on(u.idantibiograma=a.idantibiograma)
						  where u.iddxhongo=".$nromovimiento." and u.idtipoantibiograma=3";
				$rows3 = $this->execute_select($query3,1);
				
				$X+=$ancho;
				$Y	=	168;
				$ancho +=-5;
				foreach($rows3[1] as $rd3){
					$this->SetXY($X,$Y);
					$this->Cell($ancho,$alto,utf8_decode($rd3["descripcion"]),$borde, $alineacion2);
					$Y+=5;
					$count3++;
				}
            	
				$X	=	10; // POSICIÓN DE HORIZONTAL
				$Y	=	168;	// POSICIÓN VERTICAL
				$alto	=	5;
				$ancho	=	65;
				$borde	=	1;
				$alineacion2	=	'C';		
			
				$maximo = max($count1, $count2, $count3);
				
				$i = 1;
				while ($i <= $maximo) {
					$this->SetXY($X,$Y);
					$this->Cell($ancho,$alto,"",$borde, $alineacion2);
					$Y+=5;
					$i++; 
				}
				
				$X+=$ancho;
				$Y	=	168;
				$i = 1;
				while ($i <= $maximo) {
					$this->SetXY($X,$Y);
					$this->Cell($ancho,$alto,"",$borde, $alineacion2);
					$Y+=5;
					$i++; 
				}
				
				$X+=$ancho;
				$Y	=	168;
				$ancho +=-5;
				
				$i = 1;
				while ($i <= $maximo) {
					$this->SetXY($X,$Y);
					$this->Cell($ancho,$alto,"",$borde, $alineacion2);
					$Y+=5;
					$i++; 
				}
					
			}
			
			$this->Ln(10);
			$this->SetFont('Arial','B',10);
		//	$this->Cell(10,5,"",0,1,'C');
			$realiza = $this->execute_select("select  apellidos|| ' - ' || nombres AS pers_realiza
										FROM personal 
										where idpersonal=".$query[1]["idatendido"]);
			
			$this->Cell(50,5,utf8_decode("REALIZADO POR"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,utf8_decode($realiza[1]["pers_realiza"]),0,1,'L');
			$this->Ln(2);
			$this->Cell(50,5,utf8_decode("FECHA DE EMISIÓN"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,date("d/m/Y"),0,1,'L');
			$this->Ln(2);

			$this->Ln(8);
			$this->SetFont('Arial','B',10);
			$this->Cell(10,5,utf8_decode("OBSERVACION:"),0,1,'L');
			$this->SetFont('Arial','',10);
			$this->Ln(2);
			$this->MultiCell(50,5,utf8_decode($query[1]["observacion"]),0,'L',0);
		}
		function Footer(){
			$this->Image("../../../img/firmaraul.jpg",120,240,80,50,'JPG',"http://hospitaltarapoto.gob.pe/");
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