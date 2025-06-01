<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");
	
	include("../../objetos/class.funciones.php");
        
	include("../../objetos/qrcode/qrlib.php");
	
	include("../../objetos/pdf/barcode.inc.php");
	
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
           

			$this->Image("../../img/head_Vertical.jpg",10,3,195,15,'JPG',"http://hospitaltarapoto.gob.pe/");
			//$this->Image($_SERVER['DOCUMENT_ROOT']."/sgl/resources/imagenes/logo-resutados.jpg",$x,$y,$w,$h);
			
          //  $this->Ln($s);
			$this->SetXY($X2,$Y2);
          //  $this->MultiCell($ancho2,$altura," LABORATORIO REFERENCIAL DE SALUD PUBLICA - SAN MARTIN ",$borde, $alineacion2);
			
			$fecha = date("d/m/Y ");
			$hora = date("h:i:s a ");
            $this->SetXY(182,20);
            $this->SetFont('Arial','',8);
            $this->Cell(85, 3,"F.I: ".$fecha,0,1,'L');
			$this->SetXY(182,23);
            $this->Cell(85, 3,"H.I: ".$hora,0,1,'L');
			global $finicial,$ffinal;
			
		//	$this->Ln(5);
			$this->SetFont('Arial','B',12);
			$tit1 	= "INFORME DE RESULTADOS";
			$tit2 	= "";
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

			$query = $this->execute_select("select  idtorch,pacientes, edadactual,medico_solicita,idpaciente,idestablesolicita,
										tipmuestra,fechatoma,idingresomuestra,observaciones,codbarra,medico_solicita
										FROM vista_torch 
										where idtorch=".$nromovimiento);
										
			$pacient = $this->execute_select("select  idpaciente,fnacimiento, nrodocumento from paciente where idpaciente=".$query[1]["idpaciente"]);
			$estSoli = $this->execute_select("select  codrenaes||' - '|| descripcion as est_solic from establecimiento where idestablecimiento=".$query[1]["idestablesolicita"]);
			$tpexam = $this->execute_select("select  descripcion from tipo_Examen 
										where idtipo_examen=(select idtipo_examen from muestra_det where idingresomuestra=".$query[1]["idingresomuestra"].")");

			$this->Ln(5);            
			$this->Cell(30,5,"Nombre Paciente ",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(100,5,strtoupper(utf8_decode($query[1]["pacientes"])),0,0,'L');
		
			$this->Cell(27,5,utf8_decode("N°. D.N.I"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(10,5,$pacient[1]["nrodocumento"],0,1,'L');
						
			$this->Cell(30,5,utf8_decode("Examen Solicitado"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(100,5,strtoupper(utf8_decode($tpexam[1]["descripcion"])),0,0,'L');
			
			$this->Cell(27,5,utf8_decode("F. Nacimiento"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(30,5,$this->FechaDMY2($pacient[1]["fnacimiento"]),0,1,'L');
						
			$this->Cell(30,5,utf8_decode("Muestra Entregada"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(100,5,strtoupper(utf8_decode($query[1]["tipmuestra"])),0,0,'L');
			
			$this->Cell(27,5,utf8_decode("Edad Tomada "),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(10,5,$query[1]["edadactual"],0,1,'L');
			
			
			$this->Cell(30,5,utf8_decode("EE.SS. Solicitante"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(100,5,strtoupper(utf8_decode($estSoli[1]["est_solic"])),0,0,'L');
			
			
			$this->Cell(27,5,utf8_decode("F. Toma Muestra"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(10,5,$this->FechaDMY2($query[1]["fechatoma"]),0,1,'L');
			
			
			$this->Cell(30,5,utf8_decode("Medico Solicitante"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(120,5,strtoupper(utf8_decode($query[1]["medico_solicita"])),0,1,'L');
			
			$count = 0;
						
			$this->Ln(10);
			$this->SetFont('Arial','B',12);
            $this->Cell(10,5,"PRUEBAS REALIZADAS",0,0,'L');
            $this->Ln(5);
			$this->SetFont('Arial','B',10);
		    $this->SetWidths(array(10,30,50,50,50));
			$this->SetAligns(array('C','C','C','C','C'));
			$this->Row(array("#","Fecha Prueba","Prueba","VALORES","RESULTADO"));
			//echo $query;

  
			$prueb = $this->execute_select("select  t.fecharesultado,tp.descripcion as tiprueba ,t.valor, 
						tt.descripcion as titorch , tp.referencia
							from torch_prueba as t
							inner join tipo_prueba as tp on(tp.idtipoprueba=t.idtipoprueba)
							inner join tipo_torch as tt on(tt.idtipotorch=t.idtipotorch)
							where idtorch=".$query[1]["idtorch"],1);
			$this->SetFont('Arial','',10);
			foreach($prueb[1] as $prue){
				$count++;
				$this->SetWidths(array(10,30,50,50,50));
				$this->SetAligns(array('C','C','L','C','C'));
				$this->Row(array($count,$this->FechaDMY2($prue["fecharesultado"]),$prue["tiprueba"],$prue["valor"],utf8_decode($prue["titorch"])),0);
				}
			
			$this->Ln(10);
			
			$this->Cell(45,5,utf8_decode("Interpretación de Resultados"),0,0,'L');
			$this->Cell(5,5,":",0,1,'C');
			$this->Cell(55,5,utf8_decode("<"),0,0,'R');
			$this->Cell(5,5,utf8_decode(""),0,0,'L');
			$this->Cell(5,5,utf8_decode("9"),0,0,'L');
			$this->Cell(5,5,utf8_decode("Negativo"),0,1,'L');
			
			$this->Cell(55,5,utf8_decode("9"),0,0,'R');
			$this->Cell(5,5,utf8_decode("-"),0,0,'L');
			$this->Cell(5,5,utf8_decode("11"),0,0,'L');
			$this->Cell(5,5,utf8_decode("Indeterminado"),0,1,'L');
			
			$this->Cell(55,5,utf8_decode(">"),0,0,'R');
			$this->Cell(5,5,utf8_decode(""),0,0,'L');
			$this->Cell(5,5,utf8_decode("11"),0,0,'L');
			$this->Cell(5,5,utf8_decode("Positivo"),0,1,'L');
		
		//	$this->Cell(50,5,$prue["referencia"],0,0,'L');
			
			$this->Ln(10);
						
			$this->Cell(45,5,utf8_decode("Observaciones"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			//$this->Cell(80,5,utf8_decode($query[1]["observaciones"]),0,1,'L');
		//	$this->Ln(5);
			
			$X =60;
			$Y =140;
			$alto	=	5;
			$borde	=	0;
			$alineacion	=	'L';
			$ancho	=	140;
			$this->SetXY($X,$Y);
			$this->MultiCell($ancho,$alto,utf8_decode($query[1]["observaciones"]),$borde, $alineacion);
			
			$this->Ln(10);
			$this->Cell(45,5,utf8_decode("FECHA DE EMISIÓN"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,date("d/m/Y"),0,1,'L');

			new barCodeGenrator($query[1]["codbarra"],1,"../../img/codbarra.gif",190,130,VERDADERO);
			
			$texto_qr = trim($query[1]["codbarra"]);
			
			  //set it to writable location, a place for temp generated PNG files
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
			
			$this->Ln(5);
			$this->Image("img/codigoqr.png");   
						
		}
		function Footer(){
			
			$this->Image("../../img/codbarra.gif",7,260,80,20);   
			
			$this->Image("../../img/firmaHeriberto.jpg",120,250,80,35,'JPG',"http://hospitaltarapoto.gob.pe/");
         
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