<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");
	
	include("../../objetos/class.funciones.php");
        
	include("../../objetos/num2letra.php");
	
	class impresion extends clsreporte
	{
		 function Header(){

             global $nromovimiento;

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
			$this->Cell(190,5,"NOTA DE INGRESO A ALMACEN",0,1,'C');
			
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
			global $nromovimiento;
			$nromovimiento 	= $_GET["nromovimiento"];
			
			$this->SetFont('Arial','',7);

                    $query = "select c.tipingreso, c.fechareg, c.fecharecepcion, c.nrorden, c.proveedores,
                              comprob, c.fechacompra, c.nrocomprobante, c.estable, case when c.estareg=1 then 'REGISTRADO' else 'ANULADO' end as estado ,observacion

                              from vista_ingresomaterial as c
                              where idingreso=".$nromovimiento;
					
					$rows = $this->execute_select($query);
                    //$rows = ExecuteSelect($query);


                    $this->Ln(5);

                    $this->Cell(30,5,"Establecimiento",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(155,5,utf8_decode($rows[1]["estable"]),0,1,'L');

                    

                    $this->Cell(30,5,"Condicion",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(155,5,utf8_decode($rows[1]["estado"]),0,1,'L');

                    

                    $this->Cell(30,5,"Tipo de Ingreso",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(40,5,utf8_decode($rows[1]["tipingreso"]),0,0,'L');

                    $this->Cell(25,5,"Fecha de Recepcion",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(30,5,$this->FechaDMY2($rows[1]["fecharecepcion"]),0,0,'L');

                    $this->Cell(20,5,"Nro. Orden",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(25,5,$rows[1]["nrorden"],0,1,'L');

                    

                    $this->Cell(30,5,"Proveedor",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(155,5,utf8_decode($rows[1]["proveedores"]),0,1,'L');

                    

                    $this->Ln(2);

                    $this->SetFont('Arial','B',7);

                    $this->Cell(190,5,"Datos del comprobbante",0,1,'L');

                    $this->SetFont('Arial','',7);

                    $this->Ln(2);

                    
					$this->Cell(30,5,"Fecha de comprobante",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(40,5,$this->FechaDMY2($rows[1]["fechacompra"]),0,0,'L');
					
                    $this->Cell(25,5,"Tipo Comprobante",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(30,5,utf8_decode($rows[1]["comprob"]),0,0,'L');
					
					$this->Cell(20,5,"Nro. Compro",0,0,'R');

                    $this->Cell(5,5,":",0,0,'C');
					
					$this->Cell(30,5,$rows[1]["nrocomprobante"],0,1,'L');

                    
                    $this->Cell(30,5,utf8_decode("Observación"),0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(60,5,utf8_decode($rows[1]["observacion"]),0,1,'L');

                    $this->Cell(20,5,"",0,0,'L');

                    $this->Cell(5,5,"",0,0,'C');

                    $this->Cell(25,5,"",0,1,'L');

                    

                    $this->Ln(2);

                    $this->Cell(100,5,"Material",1,0,'C');

                //    $this->Cell(20,5,"Medida",1,0,'C');
					
					$this->Cell(20,5,"Marca",1,0,'C');
                 				
                    $this->Cell(15,5,"Stock",1,0,'C');

                    $this->Cell(15,5,"F. Compra",1,0,'C');

                    $this->Cell(15,5,"F. Venc.",1,0,'C');

                    $this->Cell(15,5,"P. Compra",1,0,'C');

                    $this->Cell(15,5,"P. Venta",1,1,'C');

                    

                    $pCompra    = 0;

                    $pVenta     = 0;

                    $Cantidad   = 0;

                    $idgrupo    = 0;

                    

                    $queryD = "select i.idingreso,mt.descripcion as material, m.descripcion, i.cantidad, i.pcompra, i.pventa, mt.idtipomaterial,i.lote,
								t.descripcion as grupo, i.fechacompra, i.fvencimiento, md.descripcion as modelo,i.serie, i.codpatri, i.codpatrilab, i.idunidad,
								u.descripcion as unidadmed
								from ingreso_det as i
								inner join marcas as m on(i.idmarca=m.idmarca)
								inner join materiales as mt on(i.idmaterial=mt.idmaterial)
	                            inner join tipo_material as t on(mt.idtipomaterial=t.idtipomaterial)
	                            inner join unidad_medida as u on(u.idunidad=mt.idunidad)
                                inner join modelo as md on(md.idmodelo=i.idmodelo)
								where i.idingreso=".$nromovimiento;
					
                    $resultadoD = $this->execute_select($queryD,1);
	
					$X =10;
					$Y =98;
					$count=0;
			
                    foreach($resultadoD[1] as $rowsD){
						$count++;

                        $pCompra    += $rowsD["pcompra"];

                        $pVenta     += $rowsD["pventa"];

                        $Cantidad   += $rowsD["cantidad"];

                        if($idgrupo!=$rowsD["idtipomaterial"]){

                            $this->Cell(10,5,"Grupo",0,0,'L');

                            $this->Cell(5,5,":",0,0,'C');

                            $this->Cell(85,5,utf8_decode($rowsD["grupo"]),0,0,'L');

                        }
					//	$this->Cell(100,5,"",0,0,'L');
						$this->Cell(20,5,strtoupper(utf8_decode($rowsD["descripcion"])),0,0,'C');

						$this->Cell(15,5,$rowsD["cantidad"],0,0,'C');

						$this->Cell(15,5,$this->FechaDMY2($rowsD["fechacompra"]),0,0,'C');

						$this->Cell(15,5,$this->FechaDMY2($rowsD["fvencimiento"]),0,0,'C');                        

						$this->Cell(15,5,number_format($rowsD["pcompra"],2),0,0,'R');

						$this->Cell(15,5,number_format($rowsD["pventa"],2),0,1,'R');
				 /*	
					$alto	=	5;
					$borde	=	0;
					$alineacion	=	'L';
					$ancho	=	85;
					$this->SetXY($X,$Y);
					$this->MultiCell($ancho,$alto,strtoupper(utf8_decode($rowsD["material"])),$borde, $alineacion);
					
					$X +=$ancho;
					$ancho	=	20;
					$this->SetXY($X,$Y);
					$this->MultiCell($ancho,$alto,strtoupper(utf8_decode($rowsD["unidadmed"])),$borde, $alineacion);
					
					$X +=$ancho;
					$ancho	=	20;
					$this->SetXY($X,$Y);
					$this->MultiCell($ancho,$alto,strtoupper(utf8_decode($rowsD["descripcion"])),$borde, $alineacion);
					
					$X +=$ancho;
					$ancho	=	10;
					$alineacion	=	'C';
					$this->SetXY($X,$Y);
					$this->MultiCell($ancho,$alto,strtoupper(utf8_decode($rowsD["cantidad"])),$borde, $alineacion);
					
					$X +=$ancho;
					$ancho	=	15;
					$this->SetXY($X,$Y);
					$this->MultiCell($ancho,$alto,$this->FechaDMY2($rowsD["fechacompra"]),$borde, $alineacion);
					
					$X +=$ancho;
					$ancho	=	20;
					$this->SetXY($X,$Y);
					$this->MultiCell($ancho,$alto,$this->FechaDMY2($rowsD["fvencimiento"]),$borde, $alineacion);
					
					$X +=$ancho;
					$ancho	=	15;
					$this->SetXY($X,$Y);
					$this->MultiCell($ancho,$alto,$rowsD["pcompra"],$borde, $alineacion);
					
					$X +=$ancho;
					$ancho	=	15;
					$this->SetXY($X,$Y);
					$this->MultiCell($ancho,$alto,$rowsD["pventa"],$borde, $alineacion);
					 */
					
					

				//	$this->Cell(20,5,strtoupper(utf8_decode($rowsD["unidadmed"])),0,0,'C');
						
					$this->Cell(100,5,$count.".- ".strtoupper(utf8_decode($rowsD["material"])),0,1,'L');

                       
					//	$this->Ln();
                        $this->Cell(30,5,"Medida",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(30,5,strtoupper(utf8_decode($rowsD["unidadmed"])),0,0,'L');
						
						$this->Cell(20,5,"Modelo",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(50,5,strtoupper(utf8_decode($rowsD["modelo"])),0,0,'L');

                        

                        $this->Cell(15,5,"Series",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(20,5,strtoupper($rowsD["serie"]),0,1,'L');

                        

                        $this->Cell(30,5,"Cod. Patrimonial",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(40,5,strtoupper($rowsD["codpatri"]),0,0,'L');

                        

                        $this->Cell(20,5,"Cod. Patrim LabRef",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(40,5,strtoupper($rowsD["codpatrilab"]),0,0,'L');
						
						
						
						$this->Cell(15,5,utf8_decode("Lote N°"),0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(40,5,strtoupper($rowsD["lote"]),0,1,'L');
					
                        $this->Ln(2);

                        $this->Cell(190,.1,"",1,1,'L');

                        $this->Ln(2);
						
						$X =10;
						$Y +=15;
                        

                      //  $idgrupo = $rowsD["codtipomaterial"];
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

                    

                    $this->Cell(30,5,"Stock Total del Ingreso",0,0,'R');

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