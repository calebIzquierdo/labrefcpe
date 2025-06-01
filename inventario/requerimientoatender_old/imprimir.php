<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");
	
	include("../../objetos/class.funciones.php");
        
	include("../../objetos/num2letra.php");
	
	class impresion extends clsreporte
	{
		 function Header(){

             global $nromovimiento,$count;
			 
			$count=0;
			$this->Image("../../img/head_Vertical.jpg",10,1,195,15,'JPG',"http://hospitaltarapoto.gob.pe/");
					
					$x 	= 7;
                    $y 	= 15;

            //CONSULTA PARA CABECERA DE FICHA DE REQUERIMIENTO
            $query = "select correlativo from vista_requerimiento 
            where idrequerimiento=".$_GET['idrequerimiento'];
  
            $cabe = $this->execute_select($query);
			$fecha = date("d/m/Y ");
			$hora = date("h:i:s a ");
			
			$this->SetXY(170,20);
			$this->SetFont('Arial','',6);
            
            $this->Cell(15, 3,"Nro.",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,$cabe[1]["correlativo"],0,1,'R');
			$this->SetXY(170,23);
            $this->Cell(15, 3,"Pag",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,$this->PageNo()." de {nb}",0,1,'R');
			$this->SetXY(170,26);
			$this->Cell(15, 3,"Fecha",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,$fecha,0,1,'R');
			$this->SetXY(170,29);
			$this->Cell(15, 3,"Hora",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,$hora,0,1,'R');
			
			$this->SetFont('Arial','B',14);

			$this->SetXY(10,27);
			$this->Cell(150,5,"REQUERIMIENTO DE LABORATORIO REFERENCIAL SP",0,1,'C');
			
			global $finicial,$ffinal;
            $this->Ln(5);
            $this->SetLineWidth(.1);
            $this->Cell(0,.1,"",1,1,'C',true);
            $this->Ln(1);
            $this->Cell(0,4,'',0,0,'L');
            $this->Ln(3);					
        }
		
		function contenido($nromovimiento)
		{
			global $count, $items ;			
            
			
			$this->SetFont('Arial','',7);

                    $query = "select correlativo,fecha,area,subarea,solicitante,nombres,glosa,observacion,estable,estado from vista_requerimiento 
                              where idrequerimiento=".$nromovimiento;
					
					$rows = $this->execute_select($query);
                    //$rows = ExecuteSelect($query);


                    $this->Ln(5);
					 $this->Cell(30,5,"Establecimiento",0,0,'L');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(120,5,utf8_decode($rows[1]["estable"]),0,1,'L');		
                                                                             
                    $this->Cell(30,5,"Und. Trabajo",0,0,'L');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(60,5,utf8_decode($rows[1]["area"]),0,0,'L');  
                    $this->Cell(20,5,"Area Trabajo",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(70,5,utf8_decode($rows[1]["subarea"]),0,1,'L');
                    
                    $this->Cell(30,5,"Responsable de area",0,0,'L');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(155,5,utf8_decode($rows[1]["solicitante"]),0,1,'L');

					$this->Cell(30,5,"Fecha Requerimiento",0,0,'L');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(60,5,$this->FechaDMY2($rows[1]["fecha"]),0,0,'L');

                    $this->Cell(20,5,"Condicion",0,0,'L');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(60,5,utf8_decode($rows[1]["estado"]),0,1,'L');

                    $this->Cell(30,5,"Glosa",0,0,'L');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->MultiCell(155,5,utf8_decode(strtoupper($rows[1]["observacion"])),0,"J",false);
                    $this->Ln(2);
                    $this->Cell(10,5,"Item",1,0,'C');
	            $this->Cell(80,5,"Material",1,0,'C');
                    $this->Cell(25,5,"Und. Medida",1,0,'C');                   
                    $this->Cell(25,5,"Cantidad",1,0,'C');
		    $this->Cell(50,5,"Especificaciones",1,1,'C');
                    $queryD = "select * from vista_requerimiento_validar 
								where  idrequerimiento=".$nromovimiento." and cant>0";
					
                    $resultadoD = $this->execute_select($queryD,1);

                    foreach($resultadoD[1] as $rowsD){
                        
                        $items++;					
                        $this->Cell(10,5,$items,0,0,'L');                        
                        $this->Cell(80,5,utf8_decode($rowsD["mate"]),0,0,'L');
                        $this->Cell(25,5,utf8_decode($rowsD["und"]),0,0,'C');
                        $this->Cell(25,5,utf8_decode($rowsD["cant"]),0,0,'C');
			$this->MultiCell(50,5,utf8_decode($rowsD["especificaciones"]),0,"J",false);
                        $this->Ln(3);                      

                    }

                    $this->Ln(5);
				
					if ($count <=8){
					 
                        $this->SetY(270);                        
                        $this->SetFont('Arial','I',7);
                        $this->SetTextColor(0);
                        $this->SetLineWidth(.1);
                        $this->Cell(60,.1,"",1,0,'C',true);
                        $this->Cell(5,.1,"",0,0,'C',false);
                        $this->Cell(60,.1,"",1,0,'C',true);
                        $this->Cell(5,.1,"",0,0,'C',false);
                        $this->Cell(60,.1,"",1,0,'C',true);
                        $this->Ln(1);
                        $this->Cell(60,5,utf8_decode('V°B° Of. Enlace'),0,0,'C');
                        $this->Cell(5,.1,"",0,0,'C',false);
                        $this->Cell(60,5,'Elaborado',0,0,'C');
                        $this->Cell(5,.1,"",0,0,'C',false);
                        $this->Cell(60,5,'Recibido',0,0,'C');
					} 
		}
		
		function Footer(){
			//$this->Image("../../img/firmaraul.jpg",120,240,80,50,'JPG',"http://hospitaltarapoto.gob.pe/");
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
	
	$nromovimiento 	= $_GET["idrequerimiento"];
	
	$pdf=new impresion();
	$pdf->AliasNbPages();
    $pdf->AddPage();
	$pdf->contenido($nromovimiento);
	$pdf->Output();	
	
?>
