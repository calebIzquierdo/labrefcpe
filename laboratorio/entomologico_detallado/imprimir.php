<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");
	
	include("../../objetos/class.funciones.php");
        	
	class impresion extends clsreporte
	{
		 function Header(){

            global $id;
			
			$id	= $_GET["idpc"];

			// Para la firma del responsable del Equipo;
			$x=3;
			
            $this->SetFont('Arial','',8);
     
			$this->Image("../../img/head_Vertical.jpg",10,3,280,15,'JPG',"http://hospitaltarapoto.gob.pe/");
			
			$this->Ln(8);
			
				$this->SetFont('Arial','B',8);

				$this->SetX($x);

				$this->Cell(291,5,"DIVISION DE ENTOMOLOGIA",0,1,'C');

				$this->SetX($x);

				$this->Cell(291,5,"VIGILANCIA Y CONTROL DEL AEDES AEGYPTI",0,1,'C');

				$this->SetX($x);

				$this->Cell(291,5,"INDICE DE INFESTACION DOMICILIARIA",0,1,'C');

				$rp  = $this->execute_select("select nroreporte from paramae where codparamae=1");
				
				

				$this->Ln(3);

				$this->SetX($x);

				$this->SetFont('Arial','B',8);

				$this->Cell(116,5,utf8_decode($rp[1]["nroreporte"]),0,0,'L');

				$this->SetFont('Arial','',6);
							
							

				$this->Cell(30,5,"Fecha",1,0,'C');

				$this->Cell(15,5,"Vivien.","LRT",0,'C');

				$this->Cell(15,5,"Muest.","LRT",0,'C');

				$this->Cell(15,5,"Vivien.","LRT",0,'C');

				$this->Cell(15,5,"Recip.","LRT",0,'C');

				$this->Cell(15,5,"Recip.","LRT",0,'C');

				$this->Cell(30,5,"Indice",1,0,'C');


				$this->Cell(20,5,"Grado de","LRT",0,'C');

				$this->Cell(20,5,"Tipo de","LRT",1,'C');

				
				$this->SetX($x);

				$this->Cell(25,5,"Departamento",1,0,'C');

				$this->Cell(25,5,"Provincia",1,0,'C');

				$this->Cell(30,5,"Distrito",1,0,'C');

				$this->Cell(20,5,"Localidad",1,0,'C');

				$this->Cell(16,5,"Zona",1,0,'C');

				$this->Cell(15,5,"Trabajo",1,0,'C');

				$this->Cell(15,5,"Recepcion",1,0,'C');

				$this->Cell(15,5,"Inspecc.","LRB",0,'C');

				$this->Cell(15,5,"Recib.","LRB",0,'C');

				$this->Cell(15,5,"Posit.","LRB",0,'C');

				$this->Cell(15,5,"Inspecc.","LRB",0,'C');

				$this->Cell(15,5,"Posit.","LRB",0,'C');

				$this->Cell(10,5,"Vivienda",1,0,'C');

				$this->Cell(10,5,"Breteau",1,0,'C');

				$this->Cell(10,5,"Recip.",1,0,'C');

				$this->Cell(20,5,"Insfect.","LRB",0,'C');

				$this->Cell(20,5,"Interv.","LRB",1,'C');

			
        }
		
		function contenido($id)
		{
			global $id;
			
			$id	= $_GET["idpc"];

			$x=3;

			$indVivienda            = 0;

			$indBreteau             = 0;

			$indRecipiente          = 0;

			$grado                  = "";

			

			$tvinspec				= 0;

			$tmrecibida				= 0;

			$tvpositiva				= 0;

			$trinspeccionado		= 0;

			$trpositiva				= 0;

			

            $tvinspec1			= 0;

			$tmrecibida1		= 0;

			$tvpositiva1		= 0;

			$trinspeccionado1	= 0;

			$trpositiva1		= 0;
         
			$queryG = "select * from vista_entomologia where estareg=1 and identomologia='".$id."'   ";
			$rowsG = $this->execute_select($queryG,1);
			
			foreach($rowsG[1] as $rowsD){
				
				$n++;
				$tvinspec1          = 0;

				$tmrecibida1        = 0;

				$tvpositiva1        = 0;

				$trinspeccionado1   = 0;

				$trpositiva1        = 0;
				
				$this->SetX($x);
				
				$dep = $this->execute_select("select descripcion,provincia,departamento  from vista_distrito where  iddistrito='".$rowsD["iddistrito"]."'");
				
				$this->Cell(25,5,$n." - ".$dep[1]["departamento"],1,0,'L');

				$this->Cell(25,5,$dep[1]["provincia"],1,0,'L');

				$this->Cell(30,5,$dep[1]["descripcion"],1,0,'L');

				$this->Cell(20,5,substr(strtoupper($rowsD["local"]),0,13),1,0,'L');
				
				/*				
				$queryW = "select identomologia , idzona,fecharecepcion, fechainicio, fechatermino,sum(aedes) as vpositiva,vinspec, 
							sum(mrecibida) as mrecibida  
							from entomologia_muestra where identomologia= ".$rowsD["identomologia"]." 
							group by idzona,identomologia,fecharecepcion, fechainicio, fechatermino,vinspec
							order by idzona	"; */
							
				$queryW = "select identomologia , idzona,fecharecepcion, fechainicio, fechatermino,sum(aedes) as vpositiva,vinspec, 
							count(idzona) as mrecibida ,rinspeccionado,rpositiva
							from entomologia_muestra where identomologia= ".$rowsD["identomologia"]." 
							group by idzona,identomologia,fecharecepcion, fechainicio, fechatermino,vinspec,rinspeccionado,rpositiva
							order by idzona	";
			
               $rows2 = $this->execute_select($queryW,1);
			
				foreach($rows2[1] as $rows){
					$n++;
											
					$rows3 = $this->execute_select("select identomologia, idzona, sum(aedes) as vpositiva,vinspec 
								from entomologia_muestra where identomologia='".$rowsD["identomologia"]."'  
								group by identomologia,idzona,vinspec order by idzona ");
					
						$indVivienda 	= ($rows["vpositiva"]/($rows["vinspec"]==0?1:$rows["vinspec"])) * 100;

						$indBreteau 	= ($rows["rpositiva"]/($rows["vinspec"]==0?1:$rows["vinspec"])) * 100;

						$indRecipiente 	= ($rows["rpositiva"]/($rows["rinspeccionado"]==0?1:$rows["rinspeccionado"])) * 100;



						if($indVivienda<1){

							$grado = "BAJO RIESGO";

						}else{

							if($indVivienda>=1 && $indVivienda<2){

								$grado = "MEDIANO RIESGO";

							}else{

								$grado="ALTO RIESGO";

							}

						}

						$tvinspec           += $rows["vinspec"];

						$tmrecibida         += $rows["mrecibida"];

						$tvpositiva         += $rows["vpositiva"];

						$trinspeccionado    += $rows["rinspeccionado"];

						$trpositiva         += $rows["rpositiva"];

						

						$tvinspec1          += $rows["vinspec"];

						$tmrecibida1        += $rows["mrecibida"];

						$tvpositiva1        += $rows["vpositiva"];

						$trinspeccionado1   += $rows["rinspeccionado"];

						$trpositiva1        += $rows["rpositiva"];

						

						$fitrabajo 	= explode("-",$rows["fechainicio"]);

						$frecepcion = explode("-",$rows["fecharecepcion"]);

						$ffin 		= explode("-",$rows["fechatermino"]);

						

						$x = 103;
						$this->SetX($x);
						
						$zona=  $this->execute_select("select descripcion from tipo_zona where idzona='".$rows["idzona"]."' ");
					
						
						$this->Cell(16,5,$zona[1]["descripcion"],1,0,'C');

						$this->Cell(15,5,$fitrabajo[2]."-".($ffin[2]."/".$ffin[1]."/".$ffin[0]),1,0,'C');

						$this->Cell(15,5,$frecepcion[2]."/".$frecepcion[1]."/".$frecepcion[0],1,0,'C');

						$this->Cell(15,5,$rows ["vinspec"],"LRB",0,'C');

						$this->Cell(15,5,$rows["mrecibida"],"LRB",0,'C');

						$this->Cell(15,5,$rows["vpositiva"],"LRB",0,'C');

						$this->Cell(15,5,$rows["rinspeccionado"],"LRB",0,'C');

						$this->Cell(15,5,$rows["rpositiva"],"LRB",0,'C');

						$this->Cell(10,5,number_format($indVivienda,2),1,0,'C');

						$this->Cell(10,5,number_format($indBreteau,2),1,0,'C');

						$this->Cell(10,5,number_format($indRecipiente,2),1,0,'C');

						$this->Cell(20,5,$grado,"LRB",0,'C');

						$this->Cell(20,5,strtoupper($rows["tintervencion"]),"LRB",1,'C');



				}
		$x = 3;
				

				$indVivienda1   = ($tvpositiva1/($tvinspec1==0?1:$tvinspec1)) * 100;

				$indBreteau1    = ($trpositiva1/($tvinspec1==0?1:$tvinspec1)) * 100;

				$indRecipiente1 = ($trpositiva1/($trinspeccionado1==0?1:$trinspeccionado1)) * 100;



				if($indVivienda1<1){

					$grado1 = "BAJO RIESGO";

				   

				}else{

					if($indVivienda1>=1 && $indVivienda1<2){

						$grado1 = "MEDIANO RIESGO";

					}else{

						$grado1="ALTO RIESGO";

					}

				}

				

				$this->SetFont('Arial','B',6);

				$this->SetX($x);

				$this->Cell(146,5,"Total =>",1,0,'R');

				$this->Cell(15,5,$tvinspec1,"LRB",0,'C');

				$this->Cell(15,5,$tmrecibida1,"LRB",0,'C');

				$this->Cell(15,5,$tvpositiva1,"LRB",0,'C');

				$this->Cell(15,5,$trinspeccionado1,"LRB",0,'C');

				$this->Cell(15,5,$trpositiva1,"LRB",0,'C');

				$this->Cell(10,5,number_format($indVivienda1,2),1,0,'C');

				$this->Cell(10,5,number_format($indBreteau1,2),1,0,'C');

				$this->Cell(10,5,number_format($indRecipiente1,2),1,0,'C');

				$this->Cell(20,5,$grado1,"LB",0,'C');

				$this->Cell(20,5,"","RB",1,'C');

				$this->SetFont('Arial','',6);

		}

			

			//----------------Empieza e Segundo Reporte ------------------------------

			$this->Ln(10);

			

			//$this->Image($_SERVER['DOCUMENT_ROOT']."/sgl/resources/imagenes/icono-laboratorio.jpg",6,7,28,28);

			

			$this->SetFont('Arial','B',8);

			

			$this->SetX($x);

			$this->Cell(291,5,"RECIPIENTES PREFERIDOS PARA LA CRIA DE AEDES AEGYPTI",0,1,'C');

			$this->SetX($x);

			$this->Cell(291,5,"ENCUESTA ENTOMOLOGICA",0,1,'C');						

                        

            $this->SetFont('Arial','B',5);

			$this->Ln(5);

            $this->SetX($x);

			$this->Cell(111,5,"",0,0,'C');

			$this->Cell(20,5,"C-1",1,0,'C');

			$this->Cell(20,5,"C-2",1,0,'C');

			$this->Cell(20,5,"C-3",1,0,'C');

			$this->Cell(20,5,"C-4",1,0,'C');

			$this->Cell(20,5,"C-5",1,0,'C');

			$this->Cell(20,5,"C-6",1,0,'C');

			$this->Cell(20,5,"C-7",1,0,'C');

			$this->Cell(20,5,"C-8",1,0,'C');

			$this->Cell(20,5,"","LRT",1,'C');

						

			$this->SetX($x);

			$this->Cell(20,5,"Departamento","LRT",0,'C');

			$this->Cell(20,5,"Provincia","LRT",0,'C');

			$this->Cell(26,5,"Distrito","LRT",0,'C');

			$this->Cell(25,5,"Localidad","LRT",0,'C');

			$this->Cell(20,5,"Recipientes","LRT",0,'C');

			$this->Cell(20,5,"Tanque Alto","LR",0,'C');

			$this->Cell(20,5,"Barril, cilindro","LR",0,'C');

			$this->Cell(20,5,"Balde, Batea","LR",0,'C');

			$this->Cell(20,5,"Ollas, Cantaros","LR",0,'C');

			$this->Cell(20,5,"Florero","LR",0,'C');

			$this->Cell(20,5,"Llantas","LR",0,'C');

			$this->Cell(20,5,"Inservibles que","LR",0,'C');

			$this->Cell(20,5,"Otros","LR",0,'C');

			$this->Cell(20,5,"Total","LR",1,'C');

			

			$this->SetX($x);

			$this->Cell(20,5,"","LRB",0,'C');

			$this->Cell(20,5,"","LRB",0,'C');

			$this->Cell(26,5,"","LRB",0,'C');

			$this->Cell(25,5,"","LRB",0,'C');

			$this->Cell(20,5,"","LRB",0,'C');

			$this->Cell(20,5,"T. Bajo Pozo","LRB",0,'C');

			$this->Cell(20,5,"Sanson","LRB",0,'C');

			$this->Cell(20,5,"Tina","LRB",0,'C');

			$this->Cell(20,5,"de Barro","LRB",0,'C');

			$this->Cell(20,5,"Macetas","LRB",0,'C');

			$this->Cell(20,5,"","LRB",0,'C');

			$this->Cell(20,5,"son Criaderos","LRB",0,'C');

			$this->Cell(20,5,"Criaderos","LRB",0,'C');

			$this->Cell(20,5,"","LRB",1,'C');

			
			$and="";

			if($codred!=0){$and .= " and f.idred=".$codred;}

			if($codmicrored!=0){$and .= " and f.idmicrored=".$codmicrored;}

			if($codestablecimiento!=0){$and .= " and f.idestablecimiento=".$codestablecimiento;}


			$this->SetFont('Arial','',5);
			/*
			$queryD = "select d.descripcion as departamento, p.descripcion as provincia, ds.descripcion as distrito,
						f.local, sum(f.tanque) as tanque, sum(f.barril) as barril, sum(f.baldes) as baldes, sum(f.ollas) as ollas,
						sum(f.floreros) as floreros, sum(f.llantas) as llantas, sum(f.inservibles) as inservibles, 
						sum(f.orecipientes) as orecipientes, sum(f.c1) as c1, sum(f.c2) as c2, 
						sum(f.c3) as c3, sum(f.c4) as c4, sum(f.c5) as c5, sum(f.c6) as c6, sum(f.c7) as c7, sum(f.c8) as c8 
						from entomologia as f 
						inner join tipo_intervencion as t on (t.idtipointervencion=f.idtipointervencion)
						inner join departamento as d on (d.iddepartamento=f.iddepartamento)
						inner join provincia as p on (p.idprovincia=f.idprovincia)
						inner join distrito as ds on (ds.iddistrito=f.iddistrito)
						where  f.estareg=1 and f.fechainicio between '".$fechainicio."' and '".$fechafinal."' ".$and."
						group by departamento,provincia,distrito,f.local
					";
				*/
				//	  echo $queryD;
				
				$query2 = "select * from vista_entomologia where estareg=1 and identomologia='".$id."'   ";
				$resultadod = $this->execute_select($query2,1);
			
			//	$resultadod  = $this->execute_select($queryD,1);
				foreach($resultadod[1] as $rows){
				
				$tanque			= $this->execute_select("select rinspeccionado as tanque, rpositiva as c1 from entomologia_foco where idingresomuestra='".$rows["idingresomuestra"]."' and idtipofoco=1");
				$barril			= $this->execute_select("select rinspeccionado as barril, rpositiva as c2 from entomologia_foco where idingresomuestra='".$rows["idingresomuestra"]."' and idtipofoco=2");
				$baldes			= $this->execute_select("select rinspeccionado as baldes, rpositiva as c3 from entomologia_foco where idingresomuestra='".$rows["idingresomuestra"]."' and idtipofoco=3");
				$ollas			= $this->execute_select("select rinspeccionado as ollas, rpositiva as c4 from entomologia_foco where idingresomuestra='".$rows["idingresomuestra"]."' and idtipofoco=4");
				$floreros		= $this->execute_select("select rinspeccionado as floreros, rpositiva as c5 from entomologia_foco where idingresomuestra='".$rows["idingresomuestra"]."' and idtipofoco=5");
				$llantas	 	= $this->execute_select("select rinspeccionado as llantas, rpositiva as c6 from entomologia_foco where idingresomuestra='".$rows["idingresomuestra"]."' and idtipofoco=6");
				$inservibles	= $this->execute_select("select rinspeccionado as inservibles, rpositiva as c7 from entomologia_foco where idingresomuestra='".$rows["idingresomuestra"]."' and idtipofoco=7");
				$orecipientes	= $this->execute_select("select rinspeccionado as orecipientes, rpositiva as c8 from entomologia_foco where idingresomuestra='".$rows["idingresomuestra"]."' and idtipofoco=8");

			//	$op=1;

				$tc1 	= ($tanque[1]["c1"]*100)/($tanque[1]["tanque"]!=0?$tanque[1]["tanque"]:1);

				$tc2	= ($barril[1]["c2"]*100)/($barril[1]["barril"]!=0?$barril[1]["barril"]:1);

				$tc3	= ($baldes[1]["c3"]*100)/($baldes[1]["baldes"]!=0?$baldes[1]["baldes"]:1);

				$tc4	= ($ollas[1]["c4"]*100)/($ollas[1]["ollas"]!=0?$ollas[1]["ollas"]:1);

				$tc5	= ($floreros[1]["c5"]*100)/($floreros[1]["floreros"]!=0?$floreros[1]["floreros"]:1);

				$tc6	= ($llantas[1]["c6"]*100)/($llantas[1]["llantas"]!=0?$llantas[1]["llantas"]:1);

				$tc7	= ($inservibles[1]["c7"]*100)/($inservibles[1]["inservibles"]!=0?$inservibles[1]["inservibles"]:1);

				$tc8	= ($orecipientes[1]["c8"]*100)/($orecipientes[1]["orecipientes"]!=0?$orecipientes[1]["orecipientes"]:1);

				

				$totInspeccionados 	= $tanque[1]["tanque"]+$barril[1]["barril"]+$baldes[1]["baldes"]+$ollas[1]["ollas"]+$floreros[1]["floreros"]+$llantas[1]["llantas"]+$inservibles[1]["inservibles"]+$orecipientes[1]["orecipientes"];

				$totPositivos		= $tanque[1]["c1"]+$barril[1]["c2"]+$baldes[1]["c3"]+$ollas[1]["c4"]+$floreros[1]["c5"]+$llantas[1]["c6"]+$inservibles[1]["c7"]+$orecipientes[1]["c8"];

				

				$totGenerado 		= ($totPositivos*100)/($totInspeccionados!=0?$totInspeccionados:1);

				$dep = $this->execute_select("select descripcion as distrito,provincia,departamento  from vista_distrito where  iddistrito='".$rows["iddistrito"]."'");
				
					
				$this->SetX($x);

				$this->Cell(20,5,$dep[1]["departamento"],"LRT",0,'L');

				$this->Cell(20,5,$dep[1]["provincia"],"LRT",0,'L');

				$this->Cell(26,5,$dep[1]["distrito"],"LRT",0,'L');

				$this->Cell(25,5,$rows["local"],"LRT",0,'L');

				$this->Cell(20,5,"Inspeccionados","LRB",0,'L');
				
			
				//$this->Cell(20,5,$foco[1]["tanque"],"LRB",0,'C');
				$this->Cell(20,5,$tanque[1]["tanque"],"LRB",0,'C');

				$this->Cell(20,5,$barril[1]["barril"],"LRB",0,'C');

				$this->Cell(20,5,$baldes[1]["baldes"],"LRB",0,'C');

				$this->Cell(20,5,$ollas[1]["ollas"],"LRB",0,'C');

				$this->Cell(20,5,$floreros[1]["floreros"],"LRB",0,'C');

				$this->Cell(20,5,$llantas[1]["llantas"],"LRB",0,'C');

				$this->Cell(20,5,$inservibles[1]["inservibles"],"LRB",0,'C');

				$this->Cell(20,5,$orecipientes[1]["orecipientes"],"LRB",0,'C');

				$this->Cell(20,5,$totInspeccionados,"LRB",1,'C');

				

				$this->SetX($x);

				$this->Cell(20,5,"","LR",0,'L');

				$this->Cell(20,5,"","LR",0,'L');

				$this->Cell(26,5,"","LR",0,'L');

				$this->Cell(25,5,"","LR",0,'L');

				$this->Cell(20,5,"Positivos","LRB",0,'L');

				$this->Cell(20,5,$tanque[1]["c1"],"LRB",0,'C');

				$this->Cell(20,5,$barril[1]["c2"],"LRB",0,'C');

				$this->Cell(20,5,$baldes[1]["c3"],"LRB",0,'C');

				$this->Cell(20,5,$ollas[1]["c4"],"LRB",0,'C');

				$this->Cell(20,5,$floreros[1]["c5"],"LRB",0,'C');

				$this->Cell(20,5,$llantas[1]["c6"],"LRB",0,'C');

				$this->Cell(20,5,$inservibles[1]["c7"],"LRB",0,'C');

				$this->Cell(20,5,$orecipientes[1]["c8"],"LRB",0,'C');

				$this->Cell(20,5,$totPositivos,"LRB",1,'C');

				

				$this->SetX($x);

				$this->Cell(20,5,"","LRB",0,'L');

				$this->Cell(20,5,"","LRB",0,'L');

				$this->Cell(26,5,"","LRB",0,'L');

				$this->Cell(25,5,"","LRB",0,'L');

				$this->Cell(20,5,"Ind. de Recipientes","LRB",0,'L');

				$this->Cell(20,5,number_format($tc1,2)."%","LRB",0,'C');

				$this->Cell(20,5,number_format($tc2,2)."%","LRB",0,'C');

				$this->Cell(20,5,number_format($tc3,2)."%","LRB",0,'C');

				$this->Cell(20,5,number_format($tc4,2)."%","LRB",0,'C');

				$this->Cell(20,5,number_format($tc5,2)."%","LRB",0,'C');

				$this->Cell(20,5,number_format($tc6,2)."%","LRB",0,'C');

				$this->Cell(20,5,number_format($tc7,2)."%","LRB",0,'C');

				$this->Cell(20,5,number_format($tc8,2)."%","LRB",0,'C');

				$this->Cell(20,5,number_format($totGenerado,2)."%","LRB",1,'C');

			}	

			

                        $rp  = $this->execute_select("select observacion from paramae where codparamae=1");

						
                                

//			$rp = $this->ExecuteSelect("select observacion from paramae where codparamae=1");	

			$this->Ln(6);

			$this->SetFont('Arial','B',7);

			$this->SetX($x);

			$this->Cell(30,5,"OBSERVACIONES",0,0,'L');

			$this->Cell(5,5,":",0,1,'C');

			$this->SetFont('Arial','',7);

			$this->SetX(7);

			$this->MultiCell(197,5,utf8_decode($rp[1]["observacion"]),0,'J');     





			$this->Ln(7);

			$fecha 	= date("Y-m-d");

			$r		= explode("-",$fecha);

			

			$meses = array("01"=>"ENERO",

						   "02"=>"FEBRERO",

						   "03"=>"MARZO",

						   "04"=>"ABRIL",

						   "05"=>"MAYO",

						   "06"=>"JUNIO",

						   "07"=>"JULIO",

						   "08"=>"AGOSTO",

						   "09"=>"SETIEMBRE",

						   "10"=>"OCTUBRE",

						   "11"=>"NOVIEMBRE",

						   "12"=>"DICIEMBRE");

			

			$this->SetX($x);

			$this->SetFont('Arial','IB',10);

			$this->Cell(80,5,"Morales, ".$r[2]." de ".$meses[$r[1]]." del ".$r[0],0,0,'L');


				        

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
	
	$fechainicio	=	$_GET["fechainicial"];
	$fechafinal		=	$_GET["fechafinal"];
	$codred			=	$_GET["idr"];
	$codmicrored	=	$_GET["idmr"];
	$codestablecimiento	= $_GET["idests"];

	
	$pdf=new impresion("L");
	$pdf->AliasNbPages();
    $pdf->AddPage();
	$pdf->contenido($fechainicio,$fechafinal,$codred,$codmicrored,$codestablecimiento);
	$pdf->Output();	
	
?>