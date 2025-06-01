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
           
			$this->Image("../../img/head_Vertical.jpg",10,3,280,15,'JPG',"http://hospitaltarapoto.gob.pe/");
			
			$this->SetXY($X2,$Y2);
          //  $this->MultiCell($ancho2,$altura," LABORATORIO REFERENCIAL DE SALUD PUBLICA - SAN MARTIN ",$borde, $alineacion2);
			
			$fecha = date("d/m/Y ");
			$hora = date("h:i:s a ");
            $this->SetXY(265,20);
            $this->SetFont('Arial','',8);
            $this->Cell(85, 3,"F.I: ".$fecha,0,1,'L');
			$this->SetXY(265,23);
            $this->Cell(85, 3,"H.I: ".$hora,0,1,'L');
			global $finicial,$ffinal;
			
		//	$this->Ln(5);
			$this->SetFont('Arial','B',12);
			$tit1 	= "LISTA DE MUESTRAS RECIBIDAS.";
		//	$tit2 	= "";
		//	$tit3	= "";
			
			$this->Cell(280,5,utf8_decode($tit1),0,1,'C');	
		//	$this->Cell(190,5,utf8_decode($tit2),0,1,'C');
		//	$this->Cell(190,5,utf8_decode($tit3),0,1,'C');
			
			$this->Ln(3);
			$this->SetFont('Arial','',10);
        }
		
		function contenido($cod)
		{
			 global $codbarra,$tPapel;
			$cod 	= $_GET["idaed"];

			$h = 5;
			$X		=	30; // POSICIÓN DE HORIZONTAL
				// POSICIÓN VERTICAL
			$alto	=	40;
			$borde	=	0;
			$alineacion	=	'L';
			$ancho	=	110;
			
			$query = "select * from aedes where idaedes=".$cod;
			$row = $this->execute_select($query);
			
			$codbarra = $row[1]["codbarra"];
			
			$esta= "select idestablecimiento, eje,red, micro, esta,codrenaes, idred, idmicrored from vista_establecimiento where idestablecimiento=".$row[1]["idestablesolicita"];
			$rowEstable = $this->execute_select($esta);
			$establecimiento = $rowEstable[1]["codrenaes"]." - ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"];
						 
			$dist= "select iddistrito, descripcion, provincia, departamento from vista_distrito where iddistrito=".$row[1]["iddistrito"];
			$rowD = $this->execute_select($dist);
			$rowDistri = $rowD[1]["descripcion"]." / ".$rowD[1]["provincia"]." / ".$rowD[1]["departamento"];
		         
			$this->Cell(35,5,utf8_decode("Fecha Recepción"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(180,5,strtoupper(utf8_decode($this->FechaDMY2($row[1]["fecharecepcion"]))),0,0,'L');
		
			$this->Cell(35,5,utf8_decode("Población"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(10,5,$row[1]["poblacion"],0,1,'L');
						
			$this->Cell(35,5,utf8_decode("Fecha Inicio Trabajo"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(180,5,strtoupper($this->FechaDMY2($row[1]["fechainicio"])),0,0,'L');
			
			$this->Cell(35,5,utf8_decode("Fecha Final Trabajo"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(30,5,$this->FechaDMY2($row[1]["fechatermino"]),0,1,'L');
						
			$this->Cell(35,5,utf8_decode("Distrito"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(180,5,strtoupper(utf8_decode($rowDistri)),0,1,'L');
			
			$this->Cell(35,5,utf8_decode("EE.SS. Solicitante"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(180,5,strtoupper(utf8_decode($establecimiento)),0,1,'L');
			
			$count = 0;
						
			$this->Ln(5);
			$this->SetFont('Arial','B',12);
            $this->Cell(10,5,"LISTA DE MUESTRAS RECIBIDAS:",0,1,'L');
           // $this->Ln(5);
			
			$muest = "select m.idaedes,m.idingresomuestra,m.codbarra,m.poblacion,m.fecharecepcion,m.fechainicio, m.fechatermino, 
					m.fechrecojo,m.idzona,m.poblacion,m.idmanzana,m.familia,m.idinspector, m.idfoco,m.idlarva,m.idpupa,m.idadulto, 
					m.idaedes_a,m.idotros,z.descripcion as tzona, m.idtipointervencion, i.descripcion AS tinterven,
					p.nrodocumento ||' - '|| p.apellidos ||' '|| p.nombres as inspe_text, tf.codigo as tipfoco, m.localidad,
					m.totalviviendas, m.viviprogramadas,m.viviinspeccion,m.latitud,m.longitud ,m.direccion
					from aedes_muestra as m
					inner join tipo_zona as z on(z.idzona=m.idzona)
					inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
					inner join inspector as p ON (p.idinspector = m.idinspector)
					inner join tipo_foco as tf ON (tf.idfoco = m.idfoco)
					where m.idaedes=".$cod." order by  m.idzona asc";
										
				$pr = $this->execute_select($muest);
			
			$this->Cell(30,5,utf8_decode("LOCALIDAD"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(45,5,strtoupper(utf8_decode($pr[1]["localidad"])),0,1,'L');
			$this->Ln(2);
			$this->SetFont('Arial','B',8);
		    $this->SetWidths(array(10,10,10,10,10,20,10,30,35,15,15,45,15,10,10,10,10,10));
			$this->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C'));
			$this->Row(array("#","T. VIV","V PG","V INS","ZONA","F REC","MZA","FAMILIA",utf8_decode("DIRECCIÓN"),"LAT","LONG","INSPECTOR","FOCO","LARV","PUPA","ADUL","AED","OTR"));
			//echo $query;

				
			$prueb = $this->execute_select($muest,1);	
			$this->SetFont('Arial','',8);
			foreach($prueb[1] as $prue){
				$count++;
				
				  $this->SetWidths(array(10,10,10,10,10,20,10,30,35,15,15,45,15,10,10,10,10,10));
				$this->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C'));
				$this->Row(array($count,$prue["totalviviendas"],$prue["viviprogramadas"],$prue["viviinspeccion"],$prue["tzona"],$this->FechaDMY2($prue["fechrecojo"]),$prue["idmanzana"],utf8_decode($prue["familia"]),utf8_decode($prue["direccion"]),$prue["latitud"],$prue["longitud"],$prue["inspe_text"],$prue["tipfoco"],$prue["idlarva"],$prue["idpupa"],$prue["idadulto"],$prue["idaedes_a"],$prue["idotros"],),0);
				}
			
		
			
			/*				
			$this->Cell(30,5,utf8_decode("Observaciones"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(80,5,utf8_decode($query[1]["observaciones"]),0,1,'L');
			$this->Ln(5);
		
			$X =60;
			$Y =140;
			$alto	=	5;
			$borde	=	0;
			$alineacion	=	'L';
			$ancho	=	140;
			$this->SetXY($X,$Y);
			$this->MultiCell($ancho,$alto,utf8_decode($query[1]["observaciones"]),$borde, $alineacion);
			*/
			$this->Ln(5);
			$this->Cell(45,5,utf8_decode("FECHA DE EMISIÓN"),0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(70,5,date("d/m/Y"),0,1,'L');
			
			$fecha 	= date("Y-m-d");
			$r		= explode("-",$fecha);
			$meses = array("01"=>"ENERO",
						   "02"=>"FEBRERO",
						   "03"=>"MARZO",
						   "04"=>"ABRIL",
						   "05"=>"MAYO",
						   "06"=>"JUNIO",
						   "07"=>"JULIO",
						   "08"=>"AGOSTO",
						   "09"=>"SETIEMBRE",
						   "10"=>"OCTUBRE",
						   "11"=>"NOVIEMBRE",
						   "12"=>"DICIEMBRE");

			$x		=	10; // POSICIÓN DE HORIZONTAL
			$this->SetX($x);

			$this->SetFont('Arial','IB',10);

			$this->Cell(80,5,"Morales, ".$r[2]." de ".$meses[$r[1]]." del ".$r[0],0,1,'L');

			new barCodeGenrator($row[1]["codbarra"],1,"../../img/codbarra.gif",190,130,VERDADERO);
			
			$texto_qr = "Laboratorio Referencial Regional de Salud Pública de San Martín.\n Lista de Muestras Endenicas - \nSolicitante: ".$establecimiento.".\n".trim($row[1]["codbarra"]).".";
			
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
			
			//$this->Ln(10);
			$this->Image("img/codigoqr.png");   
						
		}
		function Footer(){
			
			$this->Image("../../img/codbarra.gif",70,255,80,20);   
			
			$this->Image("../../img/firmaHeriberto.jpg",130,245,80,35,'JPG',"http://hospitaltarapoto.gob.pe/");
         
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
	$pdf->AddPage("L");
	$pdf->contenido($pc_nro);
	$pdf->Output('ListadoMuestras_'.$codbarra.'.pdf', 'I');
	
?>