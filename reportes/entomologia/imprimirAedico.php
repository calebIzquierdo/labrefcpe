<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");	
	include("../../objetos/class.funciones.php");
	class impresion extends clsReporte
	{
            function __construct() {
                parent::__construct();
            }
            
            function Header()
			{
				global $fechainicio,$fechafinal,$codred,$codmicrored,$codestablecimiento,$codpar;

				$fechainicio	=	$_GET["finicio"];
				$fechafinal		=	$_GET["ffinal"];
				$codred			=	$_GET["idr"];
				$codmicrored	=	$_GET["idmr"];
				$codestablecimiento	= $_GET["idests"];
				$codpar			= 	$_GET["codp"];
				
				if($codred!=0 ){$and .= " and f.codred=".$codred;}
				if($codmicrored!=0 && !isset($codmicrored)){$and .= " and f.codmred=".$codmicrored;}
				if($codestablecimiento!=0 && $codestablecimiento!='undefined'){$and .= " and f.idestablesolicita=".$codestablecimiento;}

				$treg = "select f.iddepartamento, f.idprovincia, f.iddistrito, f.localidad as local 
							from vista_aedes_consolidado as f
							where  f.estareg=1 AND idestadomuestra!=2 and f.fechainicio between '".$fechainicio."' and '".$fechafinal."' ".$and."
							group by f.iddepartamento, f.idprovincia, f.iddistrito,f.localidad  
							";
				//echo $treg;
				$nreg = $this->execute_select($treg);
				
				$this->execute_select("delete from tmp_ficha_entomologica_aedes");
						$this->cargar_ficha_entomologicaAedico($fechainicio,$fechafinal,$nreg[1]["iddepartamento"],$nreg[1]["idprovincia"],$nreg[1]["iddistrito"],$nreg[1]["local"],$and);
				$nrW = $this->execute_select("select count(*) as total from tmp_ficha_entomologica_aedes ");
				$totalPag =  ceil($nrW[1]["total"]/14);
				
				if($this->PageNo()<= $totalPag)
				{
			
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
				$rp  = $this->execute_select("select nroreporte from paramae where codparamae=".$codpar);

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
				
				}else {
					
				// Para la firma del responsable del Equipo;
				$x=3;
				
                $this->SetFont('Arial','',8);

				$this->Image("../../img/head_Vertical.jpg",10,3,280,15,'JPG',"http://hospitaltarapoto.gob.pe/");

				$this->Ln(8);			
				}
            }

            function contenido($fechainicio,$fechafinal,$codred,$codmicrored,$codestablecimiento,$codpar)
			{
				
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

				$and="";
				///*///
				$tvinspecCons           = 0;
				$tmrecibidaCons        = 0;
				$tvpositivaCons         = 0;
				$trinspeccionadoCons    = 0;
				$trpositivaCons         = 0;
				$tvinspec1Cons          = 0;
				$tmrecibida1Cons        = 0;
				$tvpositiva1Cons        = 0;
				$trinspeccionado1Cons   = 0;
				$trpositiva1Cons        = 0;
				///*///
				if($codred!=0 ){$and .= " and f.codred=".$codred;}
				if($codmicrored!=0 && !isset($codmicrored)){$and .= " and f.codmred=".$codmicrored;}
				if($codestablecimiento!=0 && $codestablecimiento!='undefined'){$and .= " and f.idestablesolicita=".$codestablecimiento;}

				$queryG = "select f.iddepartamento, f.idprovincia, f.iddistrito, f.localidad as local 
							from vista_aedes_consolidado as f
							where  f.estareg=1 AND idestadomuestra!=2 and f.fechainicio between '".$fechainicio."' and '".$fechafinal."' ".$and."
							group by f.iddepartamento, f.idprovincia, f.iddistrito,f.localidad  
							";
				
				$rowsG = $this->execute_select($queryG);
				
						
						$tvinspec1          = 0;
						$tmrecibida1        = 0;
						$tvpositiva1        = 0;
						$trinspeccionado1   = 0;
						$trpositiva1        = 0;	
					/*	$this->execute_select("delete from tmp_ficha_entomologica_aedes");
						$this->cargar_ficha_entomologicaAedico($fechainicio,$fechafinal,$rowsG[1]["iddepartamento"],$rowsG[1]["idprovincia"],$rowsG[1]["iddistrito"],$rowsG[1]["local"],$and);
					*/
                    $queryW = "select * from tmp_ficha_entomologica_aedes 
								order by departamento, provincia,distrito, local, zona asc";
                    
                    $rowsD = $this->execute_select($queryW,1);
                    $temLocalidad="";
					foreach($rowsD[1] as $rows){
						$n++;
						if($n>1){
							if($temLocalidad != substr(strtoupper($rows["local"]),0,13)){
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
								//
								$tvinspec           =0;
								$tmrecibida         =0;
								$tvpositiva         =0;
								$trinspeccionado    =0;
								$trpositiva         =0;
								$tvinspec1          =0;
								$tmrecibida1        =0;
								$tvpositiva1        =0;
								$trinspeccionado1   =0;
								$trpositiva1        =0;
							}
						}else{
							$temLocalidad=substr(strtoupper($rows["local"]),0,13);
						}  
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
						
						///*//
						$tvinspecCons           += $rows["vinspec"];
						$tmrecibidaCons        += $rows["mrecibida"];
						$tvpositivaCons         += $rows["vpositiva"];
						$trinspeccionadoCons    += $rows["rinspeccionado"];
						$trpositivaCons         += $rows["rpositiva"];
						$tvinspec1Cons          += $rows["vinspec"];
						$tmrecibida1Cons        += $rows["mrecibida"];
						$tvpositiva1Cons        += $rows["vpositiva"];
						$trinspeccionado1Cons   += $rows["rinspeccionado"];
						$trpositiva1Cons        += $rows["rpositiva"];
						///*//
						$fitrabajo 	= explode("-",$rows["fechainicio"]);
						$frecepcion = explode("-",$rows["fecharecepcion"]);
						$ffin 		= explode("-",$rows["fechatermino"]);					

						$this->SetX($x);
						$this->Cell(25,5,$n.".- ".$rows["departamento"],1,0,'L');
						$this->Cell(25,5,$rows["provincia"],1,0,'L');
						$this->Cell(30,5,$rows["distrito"],1,0,'L');
						$this->Cell(20,5,substr(strtoupper($rows["local"]),0,13),1,0,'L');
						$this->Cell(16,5,$rows["zona"],1,0,'C');
						$this->Cell(15,5,$fitrabajo[2]."-".($ffin[2]."/".$ffin[1]."/".$ffin[0]),1,0,'C');
						$this->Cell(15,5,$frecepcion[2]."/".$frecepcion[1]."/".$frecepcion[0],1,0,'C');
						$this->Cell(15,5,$rows["vinspec"],"LRB",0,'C');
						$this->Cell(15,5,$rows["mrecibida"],"LRB",0,'C');
						$this->Cell(15,5,$rows["vpositiva"],"LRB",0,'C');
						$this->Cell(15,5,$rows["rinspeccionado"],"LRB",0,'C');
						$this->Cell(15,5,$rows["rpositiva"],"LRB",0,'C');
						$this->Cell(10,5,number_format($indVivienda,2),1,0,'C');
						$this->Cell(10,5,number_format($indBreteau,2),1,0,'C');
						$this->Cell(10,5,number_format($indRecipiente,2),1,0,'C');
						$this->Cell(20,5,$grado,"LRB",0,'C');
						$this->Cell(20,5,strtoupper($rows["tintervencion"]),"LRB",1,'C');
						if($n==count($rowsD[1])){
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
						}


						   
						$indVivienda1Cons   = ($tvpositiva1Cons/($tvinspec1Cons==0?1:$tvinspec1Cons)) * 100;
						$indBreteau1Cons   = ($trpositiva1Cons/($tvinspec1Cons==0?1:$tvinspec1Cons)) * 100;
						$indRecipiente1Cons = ($trpositiva1Cons/($trinspeccionado1Cons==0?1:$trinspeccionado1Cons)) * 100;


						if($indVivienda1Cons<1){
								$grado1 = "BAJO RIESGO";		   
						}else{
								if($indVivienda1Cons>=1 && $indVivienda1Cons<2){
										$grado1 = "MEDIANO RIESGO";
								}else{
										$grado1="ALTO RIESGO";
								}
						}

						$this->SetFont('Arial','B',6);
						$this->SetX($x);
						$this->Cell(146,5,"Total Consolidado=>",1,0,'R');
						$this->Cell(15,5,$tvinspec1Cons,"LRB",0,'C');
						$this->Cell(15,5,$tmrecibida1Cons,"LRB",0,'C');
						$this->Cell(15,5,$tvpositiva1Cons,"LRB",0,'C');
						$this->Cell(15,5,$trinspeccionado1Cons,"LRB",0,'C');
						$this->Cell(15,5,$trpositiva1Cons,"LRB",0,'C');
						$this->Cell(10,5,number_format($indVivienda1Cons,2),1,0,'C');
						$this->Cell(10,5,number_format($indBreteau1Cons,2),1,0,'C');
						$this->Cell(10,5,number_format($indRecipiente1Cons,2),1,0,'C');
						$this->Cell(20,5,$grado1,"LB",0,'C');
						$this->Cell(20,5,"","RB",1,'C');
						$this->SetFont('Arial','',6);

		//----------------Empieza e Segundo Reporte ------------------------------
					$this->AddPage("L");
					//$this->Image($_SERVER['DOCUMENT_ROOT']."../../img/icono-laboratorio.jpg",6,7,28,28);
					//$this->Image("../../img/icono-laboratorio.jpg",6,7,28,28);
					/////////////////***************************////////////////////////
					/////////////////***************************////////////////////////
					/////////////////***************************////////////////////////
					$this->SetFont('Arial','B',8);
					$this->SetX($x);
					$this->Cell(291,5,"RECIPIENTES PREFERIDOS PARA LA CRIA DE AEDES AEGYPTI ",0,1,'C');
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
				
				
				if($codred!=0){$and .= " and f.codred=".$codred;}
				if($codmicrored!=0&& !isset($codmicrored)){$and .= " and f.codmred=".$codmicrored;}
				if($codestablecimiento!=0 && $codestablecimiento!='undefined'){$and .= " and f.idestablesolicita=".$codestablecimiento;}

				$this->SetFont('Arial','',5);

				$queryD = "select d.descripcion as departamento, p.descripcion as provincia, ds.descripcion as distrito, 
							f.localidad as local, 
							sum(f.c1positivo) as tanque, sum(f.c2positivo) as barril, 
							sum(f.c3positivo) as baldes, sum(f.c4positivo) as ollas,
							sum(f.c5positivo) as floreros, sum(f.c6positivo) as llantas, 
							sum(f.c7positivo) as inservibles, sum(f.c8positivo) as orecipientes, 
							sum(f.c1) as c1, sum(f.c2) as c2, sum(f.c3) as c3, sum(f.c4) as c4, 
							sum(f.c5) as c5, sum(f.c6) as c6, sum(f.c7) as c7, sum(f.c8) as c8 
							from vista_aedes_consolidado as f 
							inner join departamento as d on (d.iddepartamento=f.iddepartamento) 
							inner join provincia as p on (p.idprovincia=f.idprovincia) 
							inner join distrito as ds on (ds.iddistrito=f.iddistrito) 
							where  f.estareg=1 and f.fechainicio between '".$fechainicio."' and '".$fechafinal."' ".$and."
							group by departamento,provincia,distrito,f.localidad
							order by departamento, provincia,distrito, local asc";
						//	echo $queryD;
								  
							$resultadod  = $this->execute_select($queryD,1);
								foreach($resultadod[1] as $rows){
								   

						$tc1 	= ($rows["tanque"]*100)/($rows["c1"]!=0?$rows["c1"]:1);
						$tc2	= ($rows["barril"]*100)/($rows["c2"]!=0?$rows["c2"]:1);
						$tc3	= ($rows["baldes"]*100)/($rows["c3"]!=0?$rows["c3"]:1);
						$tc4	= ($rows["ollas"]*100)/($rows["c4"]!=0?$rows["c4"]:1);
						$tc5	= ($rows["floreros"]*100)/($rows["c5"]!=0?$rows["c5"]:1);
						$tc6	= ($rows["llantas"]*100)/($rows["c6"]!=0?$rows["c6"]:1);
						$tc7	= ($rows["inserviblesc7"]*100)/($rows["c7"]!=0?$rows["c7"]:1);
						$tc8	= ($rows["orecipientes"]*100)/($rows["c8"]!=0?$rows["c8"]:1); //corregido				

						$totInspeccionados 	= $rows["c1"]+$rows["c2"]+$rows["c3"]+$rows["c4"]+$rows["c5"]+$rows["c6"]+$rows["c7"]+$rows["c8"];
						$totPositivos		= $rows["tanque"]+$rows["barril"]+$rows["baldes"]+$rows["ollas"]+$rows["floreros"]+$rows["llantas"]+$rows["inservibles"]+$rows["orecipientes"];
						$totGenerado 		= ($totPositivos*100)/($totInspeccionados!=0?$totInspeccionados:1);



						$this->SetX($x);

						$this->Cell(20,5,$rows["departamento"],"LRT",0,'L');
						$this->Cell(20,5,$rows["provincia"],"LRT",0,'L');
						$this->Cell(26,5,$rows["distrito"],"LRT",0,'L');
						$this->Cell(25,5,$rows["local"],"LRT",0,'L');
						$this->Cell(20,5,"Inspeccionados","LRB",0,'L');
						//
						$this->Cell(20,5,$rows["c1"],"LRB",0,'C');
						$this->Cell(20,5,$rows["c2"],"LRB",0,'C');
						//
						$this->Cell(20,5,$rows["c3"],"LRB",0,'C');
						$this->Cell(20,5,$rows["c4"],"LRB",0,'C');
						$this->Cell(20,5,$rows["c5"],"LRB",0,'C');
						$this->Cell(20,5,$rows["c6"],"LRB",0,'C');
						$this->Cell(20,5,$rows["c7"],"LRB",0,'C');
						$this->Cell(20,5,$rows["c8"],"LRB",0,'C');
						$this->Cell(20,5,$totInspeccionados,"LRB",1,'C');				

						$this->SetX($x);
						$this->Cell(20,5,"","LR",0,'L');
						$this->Cell(20,5,"","LR",0,'L');
						$this->Cell(26,5,"","LR",0,'L');
						$this->Cell(25,5,"","LR",0,'L');
						$this->Cell(20,5,"Positivos","LRB",0,'L');
						//$this->Cell(20,5,$rows["c1"],"LRB",0,'C');
						$this->Cell(20,5,$rows["tanque"],"LRB",0,'C');
						$this->Cell(20,5,$rows["barril"],"LRB",0,'C');
						$this->Cell(20,5,$rows["baldes"],"LRB",0,'C');
						$this->Cell(20,5,$rows["ollas"],"LRB",0,'C');
						$this->Cell(20,5,$rows["floreros"],"LRB",0,'C');
						$this->Cell(20,5,$rows["llantas"],"LRB",0,'C');
						$this->Cell(20,5,$rows["inservibles"],"LRB",0,'C');
						$this->Cell(20,5,$rows["orecipientes"],"LRB",0,'C');
						$this->Cell(20,5,$totPositivos,"LRB",1,'C');



						$this->SetX($x);
						$this->Cell(20,5,"","LRB",0,'L');
						$this->Cell(20,5,"","LRB",0,'L');
						$this->Cell(26,5,"","LRB",0,'L');
						$this->Cell(25,5,"","LRB",0,'L');
						$this->Cell(20,5,"Ind. de Recipientes","LRB",0,'L');
						$this->Cell(20,5,number_format($tc1,3)."%","LRB",0,'C');
						$this->Cell(20,5,number_format($tc2,3)."%","LRB",0,'C');
						$this->Cell(20,5,number_format($tc3,3)."%","LRB",0,'C');
						$this->Cell(20,5,number_format($tc4,3)."%","LRB",0,'C');
						$this->Cell(20,5,number_format($tc5,3)."%","LRB",0,'C');
						$this->Cell(20,5,number_format($tc6,3)."%","LRB",0,'C');
						$this->Cell(20,5,number_format($tc7,3)."%","LRB",0,'C');
						$this->Cell(20,5,number_format($tc8,3)."%","LRB",0,'C');
						$this->Cell(20,5,number_format($totGenerado,2)."%","LRB",1,'C');
				}	



                         //   $rp  = $this->execute_select("select observacion from paramae where codparamae=1");


                            
                            $rp  = $this->execute_select("select observacion from paramae where codparamae=".$codpar);
                            
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
                $this->SetY(-15);
                $this->SetFont('Arial','I',6);
                $this->SetTextColor(0);
                $this->SetLineWidth(.1);
                $this->Cell(0,.1,"",1,1,'C',true);
                $this->Ln(1);
                $this->SetFont('Arial','I',6);
			//	$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,1,'C');
                $this->Cell(0,4,utf8_decode("Jr. Túpac Amaru 5° cuadra, teléfonos: 042-526451 - 042-526589")." - Pag. ".$this->PageNo().'/{nb}',0,0,'C');
				
            }        
}
	
	$fechainicio	=	$_GET["fechainicial"];
	$fechafinal		=	$_GET["fechafinal"];
	$codred			=	$_GET["idr"];
	$codmicrored	=	$_GET["idmr"];
	$codestablecimiento	= $_GET["idests"];
	$codpar			= 	$_GET["codp"];	

	
	$pdf=new impresion();
        
	
	//$fecha = date("d/m/Y h:i:s a ");
	$fecha = date("dmY");
	$hora = date("his");
		
	$pdf=new impresion();
        
	$pdf->AliasNbPages();
    $pdf->AddPage("L");
	$pdf->contenido($fechainicio,$fechafinal,$codred,$codmicrored,$codestablecimiento,$codpar);
	
	$pdf->Output('ConsolidadoAedico_'.$fecha."_".$hora .'.pdf', 'I');
	//$pdf->Output();	
	
?>
	
?>