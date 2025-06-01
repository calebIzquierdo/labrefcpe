<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");

	include("../../objetos/class.funciones.php");
	
	
	class impresion extends clsreporte
	{
		function Header(){
			global $finicial,$ffinal,$tpref,$codred,$codmicrored,$codestablecimiento;
			
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
			$tit1 	= "REPORTE DE MUESTRAS PROCESADAS";
			$tit2 	= "DESDE: ".$this->FechaDMY($finicial)." HASTA ".$this->FechaDMY($ffinal);
		//	$tit3	= "";
			
			$this->Cell(190,5,utf8_decode($tit1),0,1,'C');	
			$this->Cell(190,5,utf8_decode($tit2),0,1,'C');
			//$this->Cell(190,5,utf8_decode($tit3),0,1,'C');
		// http://10.10.10.214/labrefcpe/reportes/entomologia/imp_unidad.php?finicio=2023-05-01&ffinal=2023-05-09&
		//idr=0&idmr=undefined&idests=undefined&codp=1	
	
        }

		function contenido($finicial,$ffinal,$tpref,$codred,$codmicrored,$codestablecimiento )
		{
            $finicial	=	$_GET["finicio"];
            $ffinal		=	$_GET["ffinal"];
         	$codred		=	$_GET["idr"];
			$codmicrored	=	$_GET["idmr"];
			$codestablecimiento	= $_GET["idests"];

			$and = "";
            if($codred!=0 ){$and .= " and idredsolicita=".$codred;}
			if($codmicrored!=0 ){$and .= " and idmicroredsolicita=".$codmicrored;}
			if($codestablecimiento!=0 ){$and .= " and idestablesolicita=".$codestablecimiento;}

			
            $this->Ln(7);
			$h = 7;
			
            $this->SetWidths(array(10, 13, 17, 45,25, 35, 25,15, 12 ));
            $this->SetFont('Arial','B',6);
            $this->SetAligns(array('C','C','C','C','C','C','C','C','C'));
            $this->Row(array(utf8_decode("N°"),"Ingreso.","Cod. Barra","Red","MicroRed","E.E. S.S.S - Procedencia",strtoupper(utf8_decode("Intervención")),utf8_decode("Población"),utf8_decode("M. Proc." )));

            $consulta = "select * from vista_aedes where fecharecepcion between '".$finicial."' and '".$ffinal."' ".$and."    
                            order by idaedes ";
          
			// echo $consulta;
            $rows = $this->execute_select($consulta,1);
			
			$count = 0;
			$tmus = 0;
					
            $this->SetFont('Arial','',6);

            foreach($rows[1] as $rf)
            {
                $count++;
				$muest = $this->execute_select("select count(*) as tmus from aedes_muestra where  idfoco !=9 and idaedes=".$rf["idaedes"]);
				$tmus += $muest[1]["tmus"];
                $fecharef = $this->FechaDMY($rf["fecharecepcion"]);
				
                $this->SetWidths(array(10, 13, 17, 45,25, 35, 25,15, 12 ));
				$this->SetFont('Arial','B');
				$this->SetAligns(array('C','C','C','C','C','C','C','C','C')); 
                $this->Row(array($count,$fecharef,$rf["codbarra"],$rf["redes"],$rf["micro_red"],strtoupper(utf8_decode($rf["estab_solicita"])),strtoupper(utf8_decode($rf["tp_interv"])),strtoupper(utf8_decode($rf["poblacion"])),$muest[1]["tmus"] ));
            }
		
            $this->SetFont('Arial','',8);
			$this->Ln(5);
			$this->Cell(35,5,"TOTAL REGISTROS ==>",'T',0,'L');
			$this->Cell(20,5,$count,'T',0,'L');
			$this->Cell(35,5,"TOTAL Muestras ==>",'T',0,'L');
			$this->Cell(20,5,$tmus,'T',0,'L');
			$this->Cell(35,5,"Prome Muestras ==>",'T',0,'L');
			$this->Cell(50,5,number_format($tmus/$count,2),'T',1,'L');
				
			
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
	$pdf->contenido($finicial,$ffinal,$tpref,$codred,$codmicrored,$codestablecimiento);
	$pdf->Output('ReporteMuestras'.$hora.'.pdf', 'I');
	

?>