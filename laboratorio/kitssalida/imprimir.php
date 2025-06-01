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
			$fecha = date("d/m/Y ");
			$hora = date("h:i:s a ");
			
			$this->SetXY(170,20);
			$this->SetFont('Arial','',6);
            
            $this->Cell(15, 3,"Nro. de Ingreso",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,substr("0000000000".$nromovimiento,strlen("0000000000".$nromovimiento)-10),0,1,'R');
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
			$this->Cell(190,5,"REGISTROS DEL CONSUMO DE DETERMINANTES",0,1,'C');
			
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
			global $nromovimiento,$count, $items ;
			$nromovimiento 	= $_GET["nromovimiento"];
			$saldos = 0;
			
			$this->SetFont('Arial','',7);

                    $query = "select  idkit, cantidad, serie, fvencimiento, idejecutora,idred,idmicrored,idestablecimiento,
							 correlativo,  fecharecepcion,  idejecutorasolicita,  idredsolicita, idmicroredsolicita,
							 idestablesolicita, observaciones,  estareg, micro_solicita,estab_solicita,red_solicita,
							 eje_solicita, estado_reg, umedida, tipmate, materia,marc, lote, idregistro,cantkits,totales
                              from vista_kitsalida_det 
                              where idkit=".$nromovimiento."
							  ";
					
					$rows = $this->execute_select($query);
                    //$rows = ExecuteSelect($query);
					if ($rows[1]["idregistro"]==0){
						$saldos = $rows[1]["cantkits"];
					}else {
						$saldos = $rows[1]["totales"];
					}
		

                    $this->Ln(5);
					 $this->Cell(20,5,"Establecimiento",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(180,5,utf8_decode($rows[1]["estab_solicita"]),0,1,'L');
					
					
                    $this->Cell(20,5,"Material",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(100,5,utf8_decode($rows[1]["materia"]),0,1,'L');

                    $this->Cell(20,5,"Tipo",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(100,5,utf8_decode($rows[1]["tipmate"]),0,0,'L');

                                                            
                    $this->Cell(10,5,"Marca",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(60,5,utf8_decode($rows[1]["marc"]),0,1,'L');             
					
					
					$this->Cell(20,5,"Lote",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(100,5,utf8_decode($rows[1]["lote"]),0,0,'L');
					
					
                    $this->Cell(10,5,"Saldos",0,0,'l');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(50,5,utf8_decode($saldos),0,1,'L');

					
					$this->Cell(20,5,"Glosa",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->MultiCell(155,5,utf8_decode(strtoupper($rows[1]["observaciones"])),0,"J",false);
					
                 
                    $this->Ln(2);

                     $this->Cell(10,5,"Item",1,0,'C');

					$this->Cell(30,5,"Fecha",1,0,'C');

                    $this->Cell(40,5,"Tipo Uso",1,0,'C');

                    $this->Cell(40,5,"Resultado",1,0,'C');

                    $this->Cell(20,5,"Cantidad",1,1,'C');

             

                    $TotalConsumo    = 0;
                    $totalKits     = 0;
                    $Muestras	= 0;
					$Control 	= 0;
					$Postivos   = 0;
                    $Negativos    = 0;
                    $Muestras    = 0;
                    $Control    = 0;
                    $Otros    = 0;
                    $OtrosResultados    = 0;

                    

                    $queryD = "select fechauso, iduso, cantidad,idresultado,idtipomaterial,tipuso, result,cantkits
								from vista_kitsalida_fechas 
								where  idregistro=".$rows[1]["idregistro"]." order by fechauso asc ";
				//	echo $queryD;
                    $resultadoD = $this->execute_select($queryD,1);

                    foreach($resultadoD[1] as $rowsD){

                        $TotalConsumo   += $rowsD["cantidad"];
                        $count++;
                        $totalKits = $rowsD["cantkits"];
						
						switch ($rowsD["iduso"]){
							case 1:
								$Muestras += $rowsD["cantidad"];
								break;
							case 2:
								$Control += $rowsD["cantidad"];
								break;
							default :
								$Otros += $rowsD["cantidad"];
								break;
								
							
						}
						
						switch ($rowsD["idresultado"]){
							case 29:
								$Negativos += $rowsD["cantidad"];
								break;
							case 28:
								$Postivos += $rowsD["cantidad"];
								break;
							case 72:
								$Control2 += $rowsD["cantidad"];
								break;
							default :
								$OtrosResultados += $rowsD["cantidad"];
								break;
						}
						$this->Cell(10,5,$count,0,0,'C');

                        $this->Cell(30,5,$this->FechaDMY($rowsD["fechauso"]),0,0,'C');
                        $this->Cell(40,5,$rowsD["tipuso"],0,0,'C');
                        $this->Cell(40,5,$rowsD["result"],0,0,'C');
                        $this->Cell(20,5,$rowsD["cantidad"],0,1,'C');

                        $this->Cell(140,.1,"",1,1,'L');

                        $this->Ln(2);

						$idgrupo = 0;

                    }

                    

                    $this->Ln(5);

//                    $this->Cell(190,.1,"",1,1,'R');

                    

                    $this->Ln(2);

                    $this->Cell(30,5,"Total Determinantes",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,number_format($totalKits,2),0,1,'L');

                    

                    $this->Cell(30,5,"Total Positivos",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,number_format($Postivos,2),0,1,'L');
					
					
					 $this->Cell(30,5,"Total Negativos",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,number_format($Negativos,2),0,1,'L');
					

                    $this->Cell(30,5,"Total Uso Muestras",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,number_format($Muestras,2),0,1,'L');
					
					
					$this->Cell(30,5,"Total Uso Control",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,number_format($Control2,2),0,1,'L');
					
					
                    $this->Cell(30,5,"Total del Salida",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,$TotalConsumo,0,1,'L');
					
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
	
	$nromovimiento 	= $_GET["nromovimiento"];
	
	$pdf=new impresion();
	$pdf->AliasNbPages();
    $pdf->AddPage();
	$pdf->contenido($nromovimiento);
	$pdf->Output();	
	
?>
