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
			$this->Cell(190,5,strtoupper(utf8_decode("NOTA DE SALIDA DE ALMACÉN")),0,1,'C');
			
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
			
			$this->SetFont('Arial','',7);

                    $query = "select  fechasalida, idtiposalida, nrorden, idsolicita, solicitado, entregadoo, tipingreso, areaas,solicitado,entregadoo,
								case when  estareg=1 then 'REGISTRADO' else 'ANULADO' end as estado ,estable ,areatrabajo, observaciones

                              from vista_salida 
                              where idsalida=".$nromovimiento;
					
					$rows = $this->execute_select($query);
                    //$rows = ExecuteSelect($query);


                    $this->Ln(5);
					 $this->Cell(30,5,"Establecimiento",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(120,5,utf8_decode($rows[1]["estable"]),0,1,'L');
					
					
                    $this->Cell(30,5,"Condicion",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(60,5,utf8_decode($rows[1]["estado"]),0,0,'L');

                    $this->Cell(20,5,"Tipo de Salida",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(70,5,utf8_decode($rows[1]["tipingreso"]),0,1,'L');

                                                            
                    $this->Cell(30,5,"Und. Trabajo",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(60,5,utf8_decode($rows[1]["areaas"]),0,0,'L');             
					

                    $this->Cell(20,5,"Area Trabajo",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(70,5,utf8_decode($rows[1]["areatrabajo"]),0,1,'L');

					
                    $this->Cell(30,5,"Recibido por",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(60,5,utf8_decode($rows[1]["solicitado"]),0,0,'L');


                    $this->Cell(20,5,"Elaborado por",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(155,5,utf8_decode($rows[1]["entregadoo"]),0,1,'L');
                    
					
					$this->Cell(30,5,"Fecha de Salida",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(60,5,$this->FechaDMY2($rows[1]["fechasalida"]),0,1,'L');
					
                    $this->Cell(30,5,"Glosa",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->MultiCell(155,5,utf8_decode(strtoupper($rows[1]["observaciones"])),0,"J",false);
					
                   
                    

                    $this->Ln(2);

                     $this->Cell(10,5,"Item",1,0,'C');

					$this->Cell(105,5,"Material",1,0,'C');

                    $this->Cell(20,5,"Und. Medida",1,0,'C');

                    $this->Cell(20,5,"Marca",1,0,'C');

                    $this->Cell(20,5,"Fecha de Venc.",1,0,'C');

                    $this->Cell(15,5,"Cantidad",1,1,'C');


                    

                    $pCompra    = 0;

                    $pVenta     = 0;

                    $Cantidad   = 0;

                    $idgrupo    = 0;

                    

                    $queryD = "select cantidad, idtipomaterial, unidad, tpmate,  mrcas, fvencimiento, serie, 
								codpatri, codpatrilab,grupo,modelo,saldo_stock,lote
								from vista_salida_material 
								where  idsalida=".$nromovimiento." order by fvencimiento asc ";
					
                    $resultadoD = $this->execute_select($queryD,1);

                    foreach($resultadoD[1] as $rowsD){

                        $Cantidad   += $rowsD["cantidad"];

                        $count++;
                        $items++;
						
						 if($idgrupo!=$rowsD["idtipomaterial"]){

                            $this->Cell(10,5,"Grupo",0,0,'L');

                            $this->Cell(5,5,":",0,0,'C');

                            $this->Cell(100,5,utf8_decode($rowsD["grupo"]),0,0,'L');
							$this->Cell(20,5,utf8_decode($rowsD["unidad"]),0,0,'C');
							$this->Cell(20,5,utf8_decode($rowsD["mrcas"]),0,0,'C');
							$this->Cell(20,5,$this->FechaDMY2($rowsD["fvencimiento"]),0,1,'C');

                        }
						
			
						$this->Cell(10,5,$items,0,0,'C');

                        $this->Cell(155,5,utf8_decode($rowsD["tpmate"]),0,0,'L');

                        $this->Cell(15,5,$rowsD["cantidad"],0,1,'R');

						
                        $this->Cell(30,5,"Modelo",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(50,5,strtoupper(utf8_decode($rowsD["modelo"])),0,0,'L');

                        
                        $this->Cell(10,5,"Lote",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(45,5,strtoupper(utf8_decode($rowsD["lote"])),0,0,'L');
						
						$this->Cell(10,5,"Series",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(40,5,strtoupper(utf8_decode($rowsD["serie"])),0,1,'L');

                        
                        $this->Cell(30,5,"Cod. Patrimonial",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(45,5,strtoupper(utf8_decode($rowsD["codpatri"])),0,0,'L');

                        
                        $this->Cell(15,5,"Cod. LabRef",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(35,5,strtoupper(utf8_decode($rowsD["codpatrilab"])),0,0,'L');
						
						$this->Cell(20,5,utf8_decode("Stock Almacén"),0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(35,5,number_format($rowsD["saldo_stock"],2),0,1,'L');


                        $this->Ln(2);

                        $this->Cell(190,.1,"",1,1,'L');

                        $this->Ln(2);

                        

					//	$idgrupo = $rowsD["idtipomaterial"];
						$idgrupo = 0;

                    }

                    

                    $this->Ln(5);

//                    $this->Cell(190,.1,"",1,1,'R');

                    

                    $this->Ln(2);

                    $this->Cell(30,5,"Monto Precio Compra",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,number_format($pCompra,2),0,1,'L');

                    

                    $this->Cell(30,5,"Monto Precio Venta",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,number_format($pVenta,2),0,1,'L');

                    

                    $this->Cell(30,5,"Salida",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(20,5,$Cantidad,0,1,'L');
					
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
	$pdf->Output('NotaSalida'.$nromovimiento.'.pdf', 'I');
	
?>
