<?php 
	if(!session_start()){session_start();}
	 /*session_start();
    $idperfil = $_SESSION['idperfil'];
*/
	include("../../objetos/class.cabecera.php");	
	
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
			
			$xx = 170;
			$yy = 17;
			$this->SetXY($xx,$yy);
			$this->SetFont('Arial','',6);
            
          /*  $this->Cell(15, 3,"Nro. de Ingreso",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,substr("0000000000".$nromovimiento,strlen("0000000000".$nromovimiento)-10),0,1,'R');
			*/
		//	$this->SetXY(170,23);
            $this->Cell(15, 3,"Pag",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,$this->PageNo()." de {nb}",0,1,'R');
			$this->SetXY($xx,$yy+3);
			$this->Cell(15, 3,"Fecha",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,$fecha,0,1,'R');
			$this->SetXY($xx,$yy+6);
			$this->Cell(15, 3,"Hora",0,0,'L');
			$this->Cell(5,5,":",0,0,'C');
			$this->Cell(15, 3,$hora,0,1,'R');
			
			$this->SetFont('Arial','B',14);

			$this->SetXY(10,27);
			$this->Cell(190,5,"STOCK DE KITS / DETERMINACIONES",0,1,'C');
			
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
			global $idtm,$idlab, $items ;
			$idtm=$_GET["idtm"];
			$idlab=$_GET["idlab"];
			$saldos = 0;
			
			$this->SetFont('Arial','',7);
		
				
                    $this->Ln(2);

                    $this->Cell(10,5,"Item",1,0,'C');
					$this->Cell(60,5,"Establecimiento",1,0,'C');
                    $this->Cell(60,5,"Material / Kits",1,0,'C');
                    $this->Cell(30,5,"Marca",1,0,'C');
                    $this->Cell(20,5,"Lote",1,0,'C');
                    $this->Cell(15,5,"Saldo Unids.",1,1,'C');
       

					$where ="";
					$consul = "select idkit,cantidad,idmaterial, serie,fvencimiento,idejecutora,idred,idmicrored,idestablecimiento,
					correlativo,fecharecepcion, idejecutorasolicita,idredsolicita,idmicroredsolicita,idestablesolicita,
					fechadigitacion,micro_solicita,estab_solicita,red_solicita,eje_solicita,umedida,tipmate,materia,marc,
					lote,idregistro,cantkits,totales
					/*um.descripcion AS unmedida ,COALESCE (sm.cantidad,0) as cant 	   */  	     
					from vista_kitsalida_det 
				";

				if($idtm ==0 && $idlab ==0 ){
					$where =" where 1=1 order by estab_solicita asc ";
				}elseif ($idlab ==0 && $idtm !=0){
					$where =" where idmaterial = ".$idtm." order by estab_solicita asc";
				}elseif($idlab !=0 && $idtm ==0){
					$where =" where idestablesolicita = ".$idlab." order by estab_solicita asc";;
				} else {
					$where =" where idestablesolicita = ".$idlab." and idmaterial = ".$idtm." order by estab_solicita asc";;
				}
				$consul = $consul.$where;
				$resultadoD = $this->execute_select($consul,1);
					
					$X =10;
					$Y =48;
					$alto	=	5;
					$borde	=	0;
					$alineacion	=	'L';
					$alineacionC	=	'C';
					$ancho	=	10;
					
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

				
                    foreach($resultadoD[1] as $rowsD){
						
						$totalKits += $rowsD["cantkits"];
						
						$rows = $this->execute_select($query);
						//$rows = ExecuteSelect($query);
						if ($rowsD["idregistro"]==0){
							$saldos = $rowsD["cantkits"];
						}else {
							$saldos = $rowsD["totales"];
						}

                        $TotalConsumo   += $rowsD["cantidad"];
						$totaSaldo += $saldos;
                        $count++;
                        
						
						$this->SetXY($X,$Y);
						$this->MultiCell($ancho,$alto,$count,$borde, $alineacionC);
						
						$X +=$ancho;
						$ancho	+=	50;
						$this->SetXY($X,$Y);
						$this->MultiCell($ancho,$alto,strtoupper(utf8_decode($rowsD["estab_solicita"])),$borde, $alineacion);
						
						$X +=$ancho;
						//$ancho	+=	5;
						$this->SetXY($X,$Y);
						$this->MultiCell($ancho,$alto,strtoupper(utf8_decode($rowsD["materia"])),$borde, $alineacion);
												
						$X +=$ancho;
						$ancho	-=	30;
						$this->SetXY($X,$Y);
						$this->MultiCell($ancho,$alto,strtoupper(utf8_decode($rowsD["marc"])),$borde, $alineacionC);
						
						$X +=$ancho;
						$ancho	-=	10;
						$this->SetXY($X,$Y);
						$this->MultiCell($ancho,$alto,strtoupper(utf8_decode($rowsD["lote"])),$borde, $alineacionC);
						
						$X +=$ancho;
						$ancho	-=	5;
						$this->SetXY($X,$Y);
						$this->MultiCell($ancho,$alto,$saldos,$borde,$alineacionC);
                        $this->Ln(5);            
                        $this->Cell(195,.1,"",1,1,'L');
    					
						$X =10;
						$Y +=10;
						$alto	=	5;
						$borde	=	0;
						$alineacion	=	'L';
						$alineacionC	=	'C';
						$ancho	=	10;
						

                    }

                    

                    $this->Ln(5);

//                    $this->Cell(190,.1,"",1,1,'R');
                    

                    $this->Ln(2);
					$this->Cell(30,5,"Total Kits Recibidos",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
					$this->Cell(20,5,number_format($totalKits/96,2),0,0,'L'); 

                    $this->Cell(30,5,"Total Determinaciones Recibido",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format($totalKits,2),0,1,'L');
					
					$this->Cell(30,5,"Total Kits Usados",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format(($totalKits-$totaSaldo)/96,2),0,0,'L');
					
                    $this->Cell(30,5,"Total Determinaciones Usados",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format($totalKits-$totaSaldo,2),0,1,'L');
					
					
					$this->Cell(30,5,"Saldo En Kits",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format($totaSaldo/96,2),0,0,'L');
					
					$this->Cell(30,5,"Saldo en Determinaciones",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format($totaSaldo,2),0,1,'L');
					
				/* Resumen por Kits */ 
				 $this->Ln(5);
				 $this->Cell(190,.1,"",1,1,'R');
				$where2 ="";
				$consu2 = "select idmaterial from vista_kitsalida_det ";

				if($idtm ==0 && $idlab ==0 ){
					$where2 =" group by idmaterial";
					$whereA ="";
				}elseif ($idlab ==0 && $idtm !=0){
					$where2 =" where idmaterial = ".$idtm." group by idmaterial";
					$whereA =	" ";
				}elseif($idlab !=0 && $idtm ==0){
					$where2 =" where idestablesolicita = ".$idlab." group by idmaterial";
					$whereA =	" and idestablesolicita = ".$idlab."";
				} else {
					$where2 =" where idestablesolicita = ".$idlab." and idmaterial = ".$idtm." group by idmaterial";
					$whereA =	" and idestablesolicita = ".$idlab."";
				}
				$queryA = $consu2.$where2;
			
				$resD = $this->execute_select($queryA,1);

			$s=0;
			$ini = 0;
			$totalProced=0;
			
			$this->Ln(5);
			$this->Cell(30,5,"Total Determinaciones",'0',0,'L');
			$this->Cell(5,5,":",'0',0,'C');
			foreach($resD[1] as $rPrd) {
			$sum =" SELECT  sum(
							CASE WHEN idregistro = 0  THEN cantkits ELSE totales END) AS total from vista_kitsalida_det 
							where idmaterial = ".$rPrd["idmaterial"]."  ".$whereA;
			
            $total = $this->execute_select($sum);

          //  if ($total[1]["total"] != null){
            if ($total[1]["total"] >= 0){
               $nomProc = $this->execute_select("select descripcion,cantprueba from materiales where idmaterial= ".$rPrd["idmaterial"]."");
               $s++;
                $ini++;
                $salto =0;
				if($ini==1){$salto =1; $ini=0; }
				
				if ($s>=2){
					$this->Cell(35,5,"",'',0,'L');
					
					}
				
                $this->Cell(100,5,$s.".- ".$nomProc[1]["descripcion"]."",'0',0,'L');
                $this->Cell(5,5," ==>",'0',0,'C');
                $this->Cell(10,5,$total[1]["total"],'0',0,'C');
				$this->Cell(20,5,"TOTAL KITS ",'0',0 ,'L');
				$this->Cell(5,5," ==>",'0',0,'C');
				$this->Cell(10,5,number_format($total[1]["total"]/$nomProc[1]["cantprueba"],2),'0',$salto,'C');
                }
				
			}
			/*
			if ($ini==2){
				$this->Cell(1,5,"",'',1,'L');
			}
		*/
                
			
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
	
	$fecha = date("dmY");
	$hora = date("his");
	$momento = $fecha."_".$hora;
	
	
	$pdf=new impresion();
	$pdf->AliasNbPages();
    $pdf->AddPage();
	$pdf->contenido($nromovimiento);
	$pdf->Output('Kits'.$momento.'.pdf', 'I');
	
?>
