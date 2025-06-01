<?php 
	if(!session_start()){session_start();}
	
	include("../../../resources/class.reporte.php");
	
	//include("../../resources/pdf/barcode.inc.php");
		
	class impresion extends clsreporte
	{
		function Header()
		{			
                        $x=3;
			
			$this->Image($_SERVER['DOCUMENT_ROOT']."/sgl/resources/imagenes/icono-laboratorio.jpg",6,7,25,25);
			
			$this->SetFont('Arial','B',8);
			
			$this->SetX($x);
			$this->Cell(291,5,"LABORATORIO REFERENCIAL REGIONAL DE SALUD PUBLICA DE SAN MARTIN",0,1,'C');
			$this->Ln(3);
			$this->SetX($x);
			$this->Cell(291,5,"DIVISION DE ENTOMOLOGIA",0,1,'C');
			$this->SetX($x);
			$this->Cell(291,5,"LISTADO DE MUESTRAS",0,1,'C');
			$this->SetX($x);
			$this->Cell(291,5,"",0,1,'C');
						
			$this->SetFont('Arial','',6);
			
			$this->Ln(3);			
			$this->SetX($x);
			$this->Cell(5,5,"Item",1,0,'C');
            $this->Cell(20,5,"Departamento",1,0,'C');
			$this->Cell(20,5,"Provincia",1,0,'C');
			$this->Cell(25,5,"Distrito",1,0,'C');
			$this->Cell(30,5,"Localidad",1,0,'C');
			$this->Cell(10,5,"Zona",1,0,'C');
			$this->Cell(13,5,"Fecha",1,0,'C');
			$this->Cell(10,5,"Mza.",1,0,'C');
			$this->Cell(40,5,"Direccion",1,0,'C');
			$this->Cell(40,5,"Inspector",1,0,'C');
			$this->Cell(13,5,"Nro. Foco",1,0,'C');
			$this->Cell(13,5,"Larva",1,0,'C');
			$this->Cell(13,5,"Pupa",1,0,'C');
			$this->Cell(13,5,"Adulto",1,0,'C');
			$this->Cell(15,5,"Aedes Agipty",1,0,'C');
			$this->Cell(11,5,"Otros",1,1,'C');
		}
        function contenido($fechainicio,$fechafinal,$codred,$codmicrored,$codestablecimiento){
		$x=3;
		
		$and="";
		if($codred!=0){$and .= " and f.codred=".$codred;}
		if($codmicrored!=0){$and .= " and f.codmicrored=".$codmicrored;}
		if($codestablecimiento!=0){$and .= " and f.codestablecimiento=".$codestablecimiento;}
		
		$count=0;
		$queryG = "select coddep,
						  codprov,
						  coddist,
						  zona,local
				   from ficha_entomologica as f
				   where tipo=1 and estado=1 and fechainitrabajo between '".$fechainicio."' and '".$fechafinal."' ".$and."
				   group by coddep,codprov,coddist,zona,local
				   order by zona";
		
		$resultadoG = mysql_query($queryG);
		while ($rowsG=mysql_fetch_assoc($resultadoG)){
			$tnrofoco 	= 0;
			$tlarva		= 0;
			$tpupa		= 0;
			$tadulto	= 0;
			$taedes		= 0;
			$totros		= 0;
			
			$query = "select (select departamento from ubigeo where coddep=f.coddep group by departamento) as 'departamento',
							 (select provincia from ubigeo where coddep=f.coddep and codprov=f.codprov group by provincia) as 'provincia',
							 (select distrito from ubigeo where coddep=f.coddep and codprov=f.codprov and coddist=f.coddist group by distrito) as 'distrito',
							  f.zona,
							  date_format(f.fechainitrabajo,'%d/%m/%Y') as 'fecharecepcion',
							  f.mza,
							  f.direccion,
							  f.inspector,
							  f.nrofoco,
							  f.larva,
							  f.pupa,
							  f.adulto,
							  f.aedes,
							  f.otros,
							  f.local
					  from ficha_entomologica as f
					  where f.tipo=1 and f.estado=1 and 
							f.fechainitrabajo between '".$fechainicio."' and '".$fechafinal."' ".$and." and
							f.coddep=".$rowsG["coddep"]." and
							f.codprov=".$rowsG["codprov"]." and
							f.coddist=".$rowsG["coddist"]." and
							f.zona='".$rowsG["zona"]."' order by f.zona asc";
			//echo $query;
			$resultado = mysql_query($query);
			while ($rows=mysql_fetch_assoc($resultado)){
				$count++;
				
				$this->SetX($x);
				$this->Cell(5,5,$count,1,0,'C');
				$this->Cell(20,5,$rows["departamento"],1,0,'L');
				$this->Cell(20,5,$rows["provincia"],1,0,'L');
				$this->Cell(25,5,$rows["distrito"],1,0,'L');
				$this->Cell(30,5,$rows["local"],1,0,'L');
				$this->Cell(10,5,$rows["zona"],1,0,'C');
				$this->Cell(13,5,$rows["fecharecepcion"],1,0,'C');
				$this->Cell(10,5,$rows["mza"],1,0,'C');
				$this->Cell(40,5,utf8_decode($rows["direccion"]),1,0,'L');
				$this->Cell(40,5,$rows["inspector"],1,0,'L');
				$this->Cell(13,5,$rows["nrofoco"],1,0,'C');
				$this->Cell(13,5,$rows["larva"],1,0,'C');
				$this->Cell(13,5,$rows["pupa"],1,0,'C');
				$this->Cell(13,5,$rows["adulto"],1,0,'C');
				$this->Cell(15,5,$rows["aedes"],1,0,'C');
				$this->Cell(11,5,$rows["otros"],1,1,'C');
								
				$tnrofoco   += $rows["nrofoco"];
				$tlarva		+= $rows["larva"];
				$tpupa		+= $rows["pupa"];
				$tadulto	+= $rows["adulto"];
				$taedes		+= $rows["aedes"];
				$totros		+= $rows["otros"];
				
			}
			
			$this->SetFont('Arial','B',6);
			
			$this->SetX($x);
			$this->Cell(213,5,"Total Zona ".$rowsG["zona"]." =>",1,0,'R');
			$this->Cell(13,5,$tnrofoco,1,0,'C');
			$this->Cell(13,5,$tlarva,1,0,'C');
			$this->Cell(13,5,$tpupa,1,0,'C');
			$this->Cell(13,5,$tadulto,1,0,'C');
			$this->Cell(15,5,$taedes,1,0,'C');
			$this->Cell(11,5,$totros,1,1,'C');
			
			$this->SetFont('Arial','',6);
		}
/*        $this->Ln(2);
        $this->Cell(20,5,"Total de Muestras ==>",0,0,'L');
		$this->Cell(5,5,":",0,0,'C');
		$this->Cell(10,5,$count,0,1,'L');*/
		
		
		$this->Ln(15);
		$fecha 	= date("Y-m-d");
		$r		= explode("-",$fecha);
				
		$meses = array("01"=>"ENERO","02"=>"FEBRERO","03"=>"MARZO","04"=>"ABRIL","05"=>"MAYO","06"=>"JUNIO",
					   "07"=>"JULIO","08"=>"AGOSTO","09"=>"SETIEMBRE","10"=>"OCTUBRE","11"=>"NOVIEMBRE","12"=>"DICIEMBRE");
				
		$this->SetX($x);
		$this->SetFont('Arial','IB',10);
		$this->Cell(80,5,"Morales, ".$r[2]." de ".$meses[$r[1]]." del ".$r[0],0,0,'L');
				
        }  
       function Footer(){}                	
	}
	
	$codred 		= isset($_REQUEST["codred"])?$_REQUEST["codred"]:0;
	$codmicrored		= isset($_REQUEST["codmicrored"])?$_REQUEST["codmicrored"]:0;
	$codestablecimiento	= isset($_REQUEST["codestablecimiento"])?$_REQUEST["codestablecimiento"]:0;
	$fechainicial		= $_REQUEST["fechainicial"];
	$fechafinal		= $_REQUEST["fechafinal"];
	
	$pdf = new impresion("L");
    //$pdf->SetAutoPageBreak(true,5);
	$pdf->AliasNbPages();
    $pdf->AddPage();

	$pdf->contenido($fechainicial,$fechafinal,$codred,$codmicrored,$codestablecimiento);

    $pdf->Output();	
	
?>