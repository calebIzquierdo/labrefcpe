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
			$tit1 	= "CARACTERISTICAS TÉCNICAS ";
			$tit2 	= "";
		//	$tit3	= "";
			
			$this->Cell(190,5,utf8_decode($tit1),0,1,'C');	
			$this->Cell(190,5,utf8_decode($tit2),0,1,'C');
			//$this->Cell(190,5,utf8_decode($tit3),0,1,'C');
			
			//$this->Ln(3);
			$this->SetFont('Arial','',10);
        }
		
		function contenido($nromovimiento)
		{
			$nromovimiento 	= $_GET["idpc"];

			$h = 5;
			$X		=	30; // POSICIÓN DE HORIZONTAL
				// POSICIÓN VERTICAL
			$alto	=	40;
			$borde	=	0;
			$alineacion	=	'L';
			$ancho	=	110;

			$query = $this->execute_select("select  idmaterial, mate, tipmaterial, umedida,estado_material,idtipomaterial,
											idunidad,idvence,venci,	especificaiones,documentos,denominacion
											FROM vista_materiales 
											where idmaterial=".$nromovimiento);
										
			$pacient = $this->execute_select("select  idpaciente,fnacimiento, nrodocumento from paciente where idpaciente=".$query[1]["idpaciente"]);
			
			$this->Ln(5);            
			$this->Cell(30,5,"Item ",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(180,5,strtoupper(utf8_decode($query[1]["mate"])),0,1,'L');
			$this->Ln(5);
			
			$this->Cell(30,5,"1.- CARASTERISTICAS GENERALES ",0,1,'L');
			$this->SetLineWidth(.1);
            $this->Cell(0,.1,"",1,1,'C',true);
            $this->Cell(30,5,utf8_decode("Denominación Téc."),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(10,5,$query[1]["denominacion"],0,1,'L');
			$this->Cell(30,5,utf8_decode("Und. Medida"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(100,5,strtoupper(utf8_decode($query[1]["umedida"])),0,1,'L');
			$this->Ln(5);

			$this->Cell(30,5,strtoupper(utf8_decode("2.- METODOLOGÍA ")),0,1,'L');
			$this->SetLineWidth(.1);
            $this->Cell(0,.1,"",1,1,'C',true);			
			$this->Ln(3);
			
			$this->SetFont('Arial','B',10);
			$this->SetWidths(array(10,150,));
			$this->SetAligns(array('C','C'));
	
			$prueb = $this->execute_select("select idmaterial,descripcion from material_metodo 
							where idmaterial=".$query[1]["idmaterial"],1);
			$this->SetFont('Arial','',10);
			foreach($prueb[1] as $prue){
				$count++;
				$this->Cell(10,5,utf8_decode("*"),0,0,'C');
				$this->Cell(180,5,strtoupper(utf8_decode($prue["descripcion"])),0,1,'L');
			}
			$this->Ln(5);
			
			$this->Cell(30,5,strtoupper(utf8_decode("3.- MUESTRA BIOLÓGICA ")),0,1,'L');
			$this->SetLineWidth(.1);
            $this->Cell(0,.1,"",1,1,'C',true);			
			$this->Ln(3);
			
			$this->SetFont('Arial','B',10);
			$this->SetWidths(array(10,150,));
			$this->SetAligns(array('C','C'));
	
			$prueb2 = $this->execute_select("select idmaterial,descripcion from material_mbiolo 
							where idmaterial=".$query[1]["idmaterial"],1);
			$this->SetFont('Arial','',10);
			foreach($prueb2[1] as $prue2){
				$count++;
				$this->Cell(10,5,utf8_decode("*"),0,0,'C');
				$this->Cell(180,5,strtoupper(utf8_decode($prue2["descripcion"])),0,1,'L');
			}
			$this->Ln(5);
			
			$this->Cell(30,5,strtoupper(utf8_decode("4.- CARACTERÍSCAS")),0,1,'L');
			$this->SetLineWidth(.1);
            $this->Cell(0,.1,"",1,1,'C',true);			
			$this->Ln(3);
			
			$this->SetFont('Arial','B',10);
			$this->SetWidths(array(10,150,));
			$this->SetAligns(array('C','C'));
	
			$prueb3 = $this->execute_select("select idmaterial,descripcion from material_caracteristicas 
							where idmaterial=".$query[1]["idmaterial"],1);
			$this->SetFont('Arial','',10);
			foreach($prueb3[1] as $prue3){
				$count++;
				$this->Cell(10,5,utf8_decode("*"),0,0,'C');
				$this->Cell(180,5,strtoupper(utf8_decode($prue3["descripcion"])),0,1,'L');
			}
			$this->Ln(5);
			
			$this->Cell(30,5,strtoupper(utf8_decode("5.- DOCUMENTACIÓN")),0,1,'L');
			$this->SetLineWidth(.1);
            $this->Cell(0,.1,"",1,1,'C',true);			
			$this->Ln(3);
			$this->Cell(10,5,"*",0,0,'C');
			$this->Cell(100,5,strtoupper(utf8_decode($query[1]["documentos"])),0,1,'L');
			$this->Ln(5);
						
			$this->Cell(45,5,utf8_decode("6.- OTRAS REFERENCIAS"),0,1,'L');
			$this->SetLineWidth(.1);
            $this->Cell(0,.1,"",1,1,'C',true);			
			$this->Ln(3);
			$this->Cell(10,5,"*",0,0,'C');
			$this->Cell(100,5,strtoupper(utf8_decode($query[1]["especificaiones"])),0,1,'L');
			
	
			
		/*
			new barCodeGenrator($query[1]["codbarra"],1,"../../img/codbarra.gif",190,130,VERDADERO);
			
			$texto_qr = "Laboratorio Referencial Regional de Salud Pública de San Martín.\n".$tpexam[1]["descripcion"]." - ".$query[1]["tipmuestra"].".\n".trim($query[1]["codbarra"]).".";
			
		  //set it to writable location, a place for temp generated PNG files
		  //$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;
			$PNG_TEMP_DIR = $this->path . 'img/' ;
		    
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
			
			//$this->Ln(10);
			//$this->Image("img/codigoqr.png");   
			$this->Image($filename);   
					*/	
		}
		function Footer(){
			
		//	$this->Image("../../img/codbarra.gif",70,255,80,20);   
			
		//	$this->Image("../../img/firmaHeriberto.jpg",130,245,80,35,'JPG',"http://hospitaltarapoto.gob.pe/");
         
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
	
	$nromovimiento 	= $_GET["idpc"];
	
	$pdf=new impresion();
	$pdf->AliasNbPages();
    $pdf->AddPage();
	$pdf->contenido($pc_nro);
	$pdf->Output();	
	
?>