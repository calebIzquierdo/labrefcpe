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

                              comprob, c.fechacompra, c.nrocomprobante, c.estable, case when c.estareg=1 then 'REGISTRADO' else 'ANULADO' end as estado 

                              from vista_ingresomaterial as c
                              where idingreso=".$nromovimiento;
					
					$rows = $this->execute_select($query);
                    //$rows = ExecuteSelect($query);


                    $this->Ln(5);

                    $this->Cell(30,5,"Establecimiento",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(155,5,$rows[1]["estable"],0,1,'L');

                    

                    $this->Cell(30,5,"Condicion",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(155,5,$rows[1]["estado"],0,1,'L');

                    

                    $this->Cell(30,5,"Tipo de Ingreso",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(40,5,$rows[1]["tipingreso"],0,0,'L');

                    $this->Cell(30,5,"Fecha de Recepcion",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(30,5,$this->FechaDMY2($rows[1]["fecharecepcion"]),0,0,'L');

                    $this->Cell(20,5,"Nro. Orden",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(25,5,$rows[1]["nrorden"],0,1,'L');

                    

                    $this->Cell(30,5,"Proveedor",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(155,5,$rows[1]["proveedores"],0,1,'L');

                    

                    $this->Ln(2);

                    $this->SetFont('Arial','B',7);

                    $this->Cell(190,5,"Datos del comprobbante",0,1,'L');

                    $this->SetFont('Arial','',7);

                    $this->Ln(2);

                    

                    $this->Cell(30,5,"comprobbante",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(155,5,$rows[1]["comprob"],0,1,'L');

                    

                    $this->Cell(30,5,"Fecha de comprobbante",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(40,5,$this->FechaDMY2($rows[1]["fechacompra"]),0,0,'L');

                    $this->Cell(30,5,"Nro. comprobbante",0,0,'L');

                    $this->Cell(5,5,":",0,0,'C');

                    $this->Cell(30,5,$rows[1]["nrocomprobante"],0,0,'L');

                    $this->Cell(20,5,"",0,0,'L');

                    $this->Cell(5,5,"",0,0,'C');

                    $this->Cell(25,5,"",0,1,'L');

                    

                    $this->Ln(2);

                    $this->Cell(83,5,"Material",1,0,'C');

                    $this->Cell(20,5,"Medida",1,0,'C');
					
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

                    

                    $queryD = "select mt.descripcion as material, m.descripcion, i.cantidad, i.pcompra, i.pventa, mt.idtipomaterial,
								t.descripcion as grupo, i.fechacompra, i.fvencimiento, i.modelo,i.serie, i.codpatri, i.codpatrilab, i.idunidad,
								u.descripcion as unidadmed
								from ingreso_det as i
								inner join marcas as m on(i.idmarca=m.idmarca)
								inner join materiales as mt on(i.idmaterial=mt.idmaterial)
	                            inner join tipo_material as t on(mt.idtipomaterial=t.idtipomaterial)
	                            inner join unidad_medida as u on(u.idunidad=mt.idunidad)
								where i.idingreso=".$nromovimiento;
					
                    $resultadoD = $this->execute_select($queryD,1);

                    foreach($resultadoD[1] as $rowsD){

                        $pCompra    += $rowsD["pcompra"];

                        $pVenta     += $rowsD["pventa"];

                        $Cantidad   += $rowsD["cantidad"];

                        if($idgrupo!=$rowsD["idtipomaterial"]){

                            $this->Cell(10,5,"Grupo",0,0,'L');

                            $this->Cell(5,5,":",0,0,'C');

                            $this->Cell(80,5,$rowsD["grupo"],0,1,'L');

                        }

                        $this->Cell(83,5,$rowsD["material"],0,0,'L');

                        $this->Cell(20,5,$rowsD["unidadmed"],0,0,'C');
						
						$this->Cell(20,5,$rowsD["descripcion"],0,0,'C');

                        $this->Cell(15,5,$rowsD["cantidad"],0,0,'C');

                        $this->Cell(15,5,$this->FechaDMY2($rowsD["fechacompra"]),0,0,'C');

                        $this->Cell(15,5,$this->FechaDMY2($rowsD["fvencimiento"]),0,0,'C');                        

                        $this->Cell(15,5,number_format($rowsD["pcompra"],2),0,0,'R');

                        $this->Cell(15,5,number_format($rowsD["pventa"],2),0,1,'R');

                        

                        $this->Cell(30,5,"Modelo",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(40,5,strtoupper($rowsD["modelo"]),0,0,'L');

                        

                        $this->Cell(15,5,"Series",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(80,5,strtoupper($rowsD["serie"]),0,1,'L');

                        

                        $this->Cell(30,5,"Cod. Patrimonial",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(80,5,strtoupper($rowsD["codpatri"]),0,1,'L');

                        

                        $this->Cell(30,5,"Cod. Patrimonial LabRef",0,0,'L');

                        $this->Cell(5,5,":",0,0,'C');

                        $this->Cell(80,5,strtoupper($rowsD["codpatrilab"]),0,1,'L');

                        

                        $this->Ln(2);

                        $this->Cell(190,.1,"",1,1,'L');

                        $this->Ln(2);

                        

                        $idgrupo = $rowsD["codtipomaterial"];

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