<?php 	ob_start();
	if(!session_start()){session_start();}
	
	include("../../../resources/class.reporte.php");
	
	//include("../../resources/pdf/barcode.inc.php");
		
	class impresion extends clsreporte
	{
		function Header()
		{			
			$x=3;
			
			$this->Image($_SERVER['DOCUMENT_ROOT']."/sgl/resources/imagenes/icono-laboratorio.jpg",6,7,28,28);
			
			$this->SetFont('Arial','B',8);
			
			$this->SetX($x);
			$this->Cell(291,5,"LABORATORIO REFERENCIAL REGIONAL DE SALUD PUBLICA DE SAN MARTIN",0,1,'C');
			$this->Ln(3);
			$this->Cell(291,5,"RECIPIENTES PREFERIDOS PARA LA CRIA DE AEDES AEGYPTI",0,1,'C');
			$this->SetX($x);
			$this->Cell(291,5,"ENCUESTA ENTOMOLOGICA",0,1,'C');
						
                        
            $this->SetFont('Arial','B',5);
			$this->Ln(5);
            $this->SetX($x);
			$this->Cell(111,5,"",0,0,'C');
			$this->Cell(20,5,"C-1",1,0,'C');
			$this->Cell(20,5,"C-2",1,0,'C');
			$this->Cell(20,5,"C-3",1,0,'C');
			$this->Cell(20,5,"C-4",1,0,'C');
			$this->Cell(20,5,"C-5",1,0,'C');
			$this->Cell(20,5,"C-6",1,0,'C');
			$this->Cell(20,5,"C-7",1,0,'C');
			$this->Cell(20,5,"C-8",1,0,'C');
			$this->Cell(20,5,"","LRT",1,'C');
						
			$this->SetX($x);
			$this->Cell(20,5,"Departamento","LRT",0,'C');
			$this->Cell(20,5,"Provincia","LRT",0,'C');
			$this->Cell(26,5,"Distrito","LRT",0,'C');
			$this->Cell(25,5,"Localidad","LRT",0,'C');
			$this->Cell(20,5,"Recipientes","LRT",0,'C');
			$this->Cell(20,5,"Tanque Alto","LR",0,'C');
			$this->Cell(20,5,"Barril, cilindro","LR",0,'C');
			$this->Cell(20,5,"Balde, Batea","LR",0,'C');
			$this->Cell(20,5,"Ollas, Cantaros","LR",0,'C');
			$this->Cell(20,5,"Florero","LR",0,'C');
			$this->Cell(20,5,"Llantas","LR",0,'C');
			$this->Cell(20,5,"Inservibles que","LR",0,'C');
			$this->Cell(20,5,"Otros","LR",0,'C');
			$this->Cell(20,5,"Total","LR",1,'C');
			
			$this->SetX($x);
			$this->Cell(20,5,"","LRB",0,'C');
			$this->Cell(20,5,"","LRB",0,'C');
			$this->Cell(26,5,"","LRB",0,'C');
			$this->Cell(25,5,"","LRB",0,'C');
			$this->Cell(20,5,"","LRB",0,'C');
			$this->Cell(20,5,"T. Bajo Pozo","LRB",0,'C');
			$this->Cell(20,5,"Sanson","LRB",0,'C');
			$this->Cell(20,5,"Tina","LRB",0,'C');
			$this->Cell(20,5,"de Barro","LRB",0,'C');
			$this->Cell(20,5,"Macetas","LRB",0,'C');
			$this->Cell(20,5,"","LRB",0,'C');
			$this->Cell(20,5,"son Criaderos","LRB",0,'C');
			$this->Cell(20,5,"Criaderos","LRB",0,'C');
			$this->Cell(20,5,"","LRB",1,'C');

		}
        function contenido($fechainicio,$fechafinal,$codred,$codmicrored,$codestablecimiento){
			$x=3;
			

			$and="";
			if($codred!=0){$and .= " and f.codred=".$codred;}
			if($codmicrored!=0){$and .= " and f.codmicrored=".$codmicrored;}
			if($codestablecimiento!=0){$and .= " and f.codestablecimiento=".$codestablecimiento;}
                        
            $this->SetFont('Arial','',5);
			$queryD = "select (select departamento from ubigeo where coddep=f.coddep group by departamento) as 'departamento',
							  (select provincia from ubigeo where coddep=f.coddep and codprov=f.codprov group by provincia) as 'provincia',
							  (select distrito from ubigeo where coddep=f.coddep and codprov=f.codprov and coddist=f.coddist group by distrito) as 'distrito',
							   f.local,
							   sum(tanque) as 'tanque',
							   sum(barril) as 'barril',
							   sum(baldes) as 'baldes',
							   sum(ollas) as 'ollas',
							   sum(floreros) as 'floreros',
							   sum(llantas) as 'llantas',
							   sum(inservibles) as 'inservibles',
							   sum(orecipientes) as 'orecipientes',
							   sum(c1) as 'c1',
							   sum(c2) as 'c2',
							   sum(c3) as 'c3',
							   sum(c4) as 'c4',
							   sum(c5) as 'c5',
							   sum(c6) as 'c6',
							   sum(c7) as 'c7',
							   sum(c8) as 'c8'
					  from ficha_entomologica as f
					  where f.tipo=2 and f.estado=1 and f.fechainitrabajo between '".$fechainicio."' and '".$fechafinal."' ".$and."
					  group by f.coddep,f.codprov,f.coddist,f.local";		//	echo $queryD;
			$resultadoD = mysql_query($queryD);
    		while ($rows=mysql_fetch_assoc($resultadoD)){
				$tc1 	= ($rows["c1"]*100)/$rows["tanque"];
				$tc2	= ($rows["c2"]*100)/$rows["barril"];
				$tc3	= ($rows["c3"]*100)/$rows["baldes"];
				$tc4	= ($rows["c4"]*100)/$rows["ollas"];
				$tc5	= ($rows["c5"]*100)/$rows["floreros"];
				$tc6	= ($rows["c6"]*100)/$rows["llantas"];
				$tc7	= ($rows["c7"]*100)/$rows["inservibles"];
				$tc8	= ($rows["c8"]*100)/$rows["orecipientes"];
				
				$totInspeccionados 	= $rows["tanque"]+$rows["barril"]+$rows["baldes"]+$rows["ollas"]+$rows["floreros"]+$rows["llantas"]+$rows["inservibles"]+$rows["orecipientes"];
				$totPositivos		= $rows["c1"]+$rows["c2"]+$rows["c3"]+$rows["c4"]+$rows["c5"]+$rows["c6"]+$rows["c7"]+$rows["c8"];
				
				$totGenerado 		= ($totPositivos*100)/$totInspeccionados;
				
				$this->SetX($x);
				$this->Cell(20,5,$rows["departamento"],"LRT",0,'L');
				$this->Cell(20,5,$rows["provincia"],"LRT",0,'L');
				$this->Cell(26,5,$rows["distrito"],"LRT",0,'L');
				$this->Cell(25,5,$rows["local"],"LRT",0,'L');
				$this->Cell(20,5,"Inspeccionados","LRB",0,'L');
				$this->Cell(20,5,$rows["tanque"],"LRB",0,'C');
				$this->Cell(20,5,$rows["barril"],"LRB",0,'C');
				$this->Cell(20,5,$rows["baldes"],"LRB",0,'C');
				$this->Cell(20,5,$rows["ollas"],"LRB",0,'C');
				$this->Cell(20,5,$rows["floreros"],"LRB",0,'C');
				$this->Cell(20,5,$rows["llantas"],"LRB",0,'C');
				$this->Cell(20,5,$rows["inservibles"],"LRB",0,'C');
				$this->Cell(20,5,$rows["orecipientes"],"LRB",0,'C');
				$this->Cell(20,5,$totInspeccionados,"LRB",1,'C');
				
				$this->SetX($x);
				$this->Cell(20,5,"","LR",0,'L');
				$this->Cell(20,5,"","LR",0,'L');
				$this->Cell(26,5,"","LR",0,'L');
				$this->Cell(25,5,"","LR",0,'L');
				$this->Cell(20,5,"Positivos","LRB",0,'L');
				$this->Cell(20,5,$rows["c1"],"LRB",0,'C');
				$this->Cell(20,5,$rows["c2"],"LRB",0,'C');
				$this->Cell(20,5,$rows["c3"],"LRB",0,'C');
				$this->Cell(20,5,$rows["c4"],"LRB",0,'C');
				$this->Cell(20,5,$rows["c5"],"LRB",0,'C');
				$this->Cell(20,5,$rows["c6"],"LRB",0,'C');
				$this->Cell(20,5,$rows["c7"],"LRB",0,'C');
				$this->Cell(20,5,$rows["c8"],"LRB",0,'C');
				$this->Cell(20,5,$totPositivos,"LRB",1,'C');
				
				$this->SetX($x);
				$this->Cell(20,5,"","LRB",0,'L');
				$this->Cell(20,5,"","LRB",0,'L');
				$this->Cell(26,5,"","LRB",0,'L');
				$this->Cell(25,5,"","LRB",0,'L');
				$this->Cell(20,5,"Ind. de Recipientes","LRB",0,'L');
				$this->Cell(20,5,number_format($tc1,2)."%","LRB",0,'C');
				$this->Cell(20,5,number_format($tc2,2)."%","LRB",0,'C');
				$this->Cell(20,5,number_format($tc3,2)."%","LRB",0,'C');
				$this->Cell(20,5,number_format($tc4,2)."%","LRB",0,'C');
				$this->Cell(20,5,number_format($tc5,2)."%","LRB",0,'C');
				$this->Cell(20,5,number_format($tc6,2)."%","LRB",0,'C');
				$this->Cell(20,5,number_format($tc7,2)."%","LRB",0,'C');
				$this->Cell(20,5,number_format($tc8,2)."%","LRB",0,'C');
				$this->Cell(20,5,number_format($totGenerado,2)."%","LRB",1,'C');
			}	
                                $resultado = mysql_query("select observacion from paramae where codparamae=1");
                                $rp        = mysql_fetch_assoc($resultado);
                        
                                $this->Ln(6);
                                $this->SetFont('Arial','B',7);
                                $this->SetX($x);
                                $this->Cell(30,5,"OBSERVACIONES",0,0,'L');
                                $this->Cell(5,5,":",0,1,'C');
                                $this->SetFont('Arial','',7);
                                $this->SetX(7);
                                $this->MultiCell(197,5,utf8_decode($rp["observacion"]),0,'J');
                        
				$this->Ln(20);
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
				
				$this->SetX($x);
				$this->SetFont('Arial','IB',10);
				$this->Cell(80,5,"Morales, ".$r[2]." de ".$meses[$r[1]]." del ".$r[0],0,0,'L');
			
        }
       function Footer(){
//	   		$this->SetY(-10);
//			$this->SetFont('Arial','I',6);
//			$this->SetTextColor(0);
//			$this->SetLineWidth(.1);
//			$this->Cell(0,.1,"",1,1,'C',true);
//			$this->Ln(1);
//			$this->Cell(80,4,'',0,0,'L');
//			$this->Cell(200,4,'Pag. '.$this->PageNo().' de {nb}',0,0,'R');
	   }                	
	}
	
	$codred 			= isset($_REQUEST["codred"])?$_REQUEST["codred"]:0;
	$codmicrored		= isset($_REQUEST["codmicrored"])?$_REQUEST["codmicrored"]:0;
	$codestablecimiento	= isset($_REQUEST["codestablecimiento"])?$_REQUEST["codestablecimiento"]:0;
	$fechainicial		= $_REQUEST["fechainicial"];
	$fechafinal			= $_REQUEST["fechafinal"];
	
	$pdf = new impresion("L");	
    $pdf->SetAutoPageBreak(true,5);
	$pdf->AliasNbPages();
    $pdf->AddPage();

	$pdf->contenido($fechainicial,$fechafinal,$codred,$codmicrored,$codestablecimiento);
	    $pdf->Output();		ob_end_flush();
?>