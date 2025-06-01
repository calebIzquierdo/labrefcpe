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
			$tit1 	= "REPORTE DE MUESTRAS SOLICITADAS";
			$tit2 	= "DESDE: ".$this->FechaDMY($finicial)." HASTA ".$this->FechaDMY($ffinal);
		//	$tit3	= "";
			
			$this->Cell(190,5,utf8_decode($tit1),0,1,'C');	
			$this->Cell(190,5,utf8_decode($tit2),0,1,'C');
			//$this->Cell(190,5,utf8_decode($tit3),0,1,'C');
			
	
        }

		function contenido($finicial,$ffinal,$tpref )
		{
            $finicial = $_GET["finicio"];
            $ffinal = $_GET["ffinal"];
            $tpref = $_GET["ida"];

            $and = "";
            if($tpref !=0){
                $and = " idareatrabajo = ".$tpref." and ";
            }

            $this->Ln(7);
			$h = 7;
			
            $this->SetWidths(array(10, 13, 17, 25,25, 35, 20,23, 30 ));
            $this->SetFont('Arial','B',6);
            $this->SetAligns(array('C','C','C','C','C','C','C','C','C'));
            $this->Row(array(utf8_decode("N°"),"Ingreso.","Cod. Barra","Red","MicroRed","E.E. S.S.S - Procedencia","Tipo Atencion",utf8_decode("TIpo Exámen"),utf8_decode("Área Encargada" )));

            $consulta = "select * from vista_muestra_detalle where ".$and." estareg!=3  and fecharecepcion between '".$finicial."' and '".$ffinal."'  
                            order by fecharecepcion ";
          //echo $consulta;
            $rows = $this->execute_select($consulta,1);
			
			$count = 0;
		
			
            $this->SetFont('Arial','',6);

            foreach($rows[1] as $rf)
            {
                $count++;

                $fecharef = $this->FechaDMY($rf["fecharecepcion"]);
				
                $this->SetWidths(array(10, 13, 17, 25,25, 35, 20,23, 30 ));
				$this->SetFont('Arial','B');
				$this->SetAligns(array('C','C','C','C','C','C','C','C','C')); 
                $this->Row(array($count,$fecharef,$rf["codbarra"],$rf["rdes"],$rf["mred"],strtoupper(utf8_decode($rf["procedencia"])),strtoupper(utf8_decode($rf["tipoatencion"])),strtoupper(utf8_decode($rf["tiexamen"])),utf8_decode($rf["areadestino"]) ));
            }
		
            $this->SetFont('Arial','',8);
			$this->Ln(5);
			$this->Cell(35,5,"TOTAL REGISTROS ==>",'T',0,'L');
			$this->Cell(160,5,$count,'T',1,'L');
				
			
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