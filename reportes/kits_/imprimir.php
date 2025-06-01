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
                  
					$this->Cell(30,5,"Total Kits Recibidos",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
					$this->Cell(20,5,number_format($totalKits/96,2),0,0,'L'); 

                    $this->Cell(30,5,"Total Determinantes Recibido",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format($totalKits,2),0,1,'L');
					
					$this->Cell(30,5,"Total Kits Usados",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format(($totalKits-$totaSaldo)/96,2),0,0,'L');
					
                    $this->Cell(30,5,"Total Determinantes Usados",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format($totalKits-$totaSaldo,2),0,1,'L');
					
					
					$this->Cell(30,5,"Saldo En Kits",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format($totaSaldo/96,2),0,0,'L');
					
					$this->Cell(30,5,"Saldo en Determinantes",0,0,'R');
                    $this->Cell(5,5,":",0,0,'C');
                    $this->Cell(20,5,number_format($totaSaldo,2),0,1,'L');
					
					$this->Ln(5);
					$this->SetFont('Arial','B');
					$this->Cell(30,5,"TIPO MATERIAL",'',0,'R');
					$this->Cell(5,5,":",'',0,'C');
					$this->SetFont('Arial','');
					
					$where ="";
					$consul2 = "select idmaterial from vista_kitsalida_det 
					";

					if($idtm ==0 && $idlab ==0 ){
						$where2 ="  group by idmaterial order by idmaterial asc ";
					}elseif ($idlab ==0 && $idtm !=0){
						$where2 =" where idmaterial =".$idtm." group by idmaterial order by idmaterial asc";
					}elseif($idlab !=0 && $idtm ==0){
						$where2 ="where  idestablesolicita='".$idlab."' group by idmaterial order by idmaterial asc";;
					} else {
						$where2 =" where  idmaterial=".$idtm." and idestablesolicita=".$idlab." group by idmaterial ";
					}
					$consul2 = $consul2.$where2;
				//	echo $consul2;
					$idseg = $this->execute_select($consul2,1);
					
					
					
					$s1=0;
					$ini1 = 0;
					$totalProced1=0;
					$porconfirmar=0;
					foreach($idseg[1] as $rSeg) {
					if($idlab ==0 && $idtm==0 ){
						$where3 =" where idmaterial=".$rSeg["idmaterial"]." group by idestablesolicita,idmaterial";
					} else if($idlab ==0 && $idtm !=0){
						$where3 =" where idmaterial=".$idtm."  group by idmaterial";
					} else if($idlab !=0 && $idtm ==0  ){
						$where3 =" where  idestablesolicita=".$idlab."   group by idmaterial,idestablesolicita";
					} else {
						$where3 =" where  idmaterial=".$idtm." and idestablesolicita=".$idlab." group by idestablesolicita,idmaterial ";
					}
					
					$sum1 =" SELECT sum(CASE
											WHEN idregistro ='0' THEN cantkits
											ELSE totales
										END) AS total
							from vista_kitsalida_det ".$where3;
							
				echo $sum1;
					$total1 = $this->execute_select($sum1);
					
					if ($total1[1]["total"] != null){
					   $nomProc1 = $this->execute_select("select descripcion from materiales where idmaterial= ".$rSeg["idmaterial"]."");
					   $s1++;
						$ini1++;
						$salto1 =0;
						$espacio =40;
						if($ini1==1){$salto1 =1; $ini1=0; }
						
						//if ($s1==2){
						if ($s1>=2){
							$this->Cell(35,5,"",'',0,'L');
							
							}
						$this->Cell(100,5,$s1.".- ".$nomProc1[1]["descripcion"]."",'0',0,'L');
						$this->Cell(5,5," ==>",'0',0,'C');
						$this->Cell(25,5,$total1[1]["total"]." Determinantes - ",'0',0 ,'C');
						
						$this->Cell(13,5,"Total Kits",'0',0,'L');
						$this->Cell(7,5," ==>",'0',0,'C');
						$this->Cell(10,5,number_format($total1[1]["total"]/96,2),'0',$salto1 ,'C');
					   // $totalProced +=$total[1]["total"];
						}
						
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
	
	$fecha = date("dmY");
	$hora = date("his");
	$momento = $fecha."_".$hora;
	
	
	$pdf=new impresion();
	$pdf->AliasNbPages();
    $pdf->AddPage();
	$pdf->contenido($nromovimiento);
	$pdf->Output('Kits'.$momento.'.pdf', 'I');
	
?>
