<?php 
	if(!session_start()){session_start();}
	
	include("../../objetos/class.reporte.php");
	
	include("../../objetos/class.funciones.php");
        	
	class impresion extends clsreporte
	{
		 function Header(){

            global $id;
			
			$id	=	$_GET["idpc"];
			
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

				$rp  = $this->execute_select("select nroreporte from consolidado where idconsolidado=".$id);
				
				

				$this->Ln(3);

				$this->SetX($x);

				$this->SetFont('Arial','B',8);

				$this->Cell(115,5,utf8_decode($rp[1]["nroreporte"]),0,0,'L'); 
				//$this->Cell(116,5,"",0,0,'L');

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

				$this->Cell(20,5,"Localidadidad",1,0,'C');

				$this->Cell(15,5,"Zona",1,0,'C');

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
			
			$$id	=	$_GET["idpc"];
		

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

                        

			$queryG = "select iddepartamento, idprovincia, iddistrito, localidad, departamento, provincia, distrito 
						from vista_consolidado  where estareg=1 and idconsolidado=".$id." 
						group by iddepartamento, idprovincia, iddistrito,localidad,departamento, provincia, distrito";

						
		//	echo $queryG;
			$rowsG = $this->execute_select($queryG);
			
			//foreach($rowsD[1] as $rowsG){
					
          
				$tvinspec1          = 0;

				$tmrecibida1        = 0;

				$tvpositiva1        = 0;

				$trinspeccionado1   = 0;

				$trpositiva1        = 0;
	
			/*	$this->execute_select("delete from tmp_ficha_entomologica");

				$this->cargar_ficha_entomologica($fechainicio,$fechafinal,$rowsG[1]["iddepartamento"],$rowsG[1]["idprovincia"],$rowsG[1]["iddistrito"],$rowsG[1]["localidad"],$and);
			*/
                $queryW = "select * from vista_consolidado_muestra where idconsolidado =".$id." order by idzona asc ";
			
                $rowsD = $this->execute_select($queryW,1);
			
				foreach($rowsD[1] as $rows){
					$n++;

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

						

						$this->SetX($x);
						
						
						$this->Cell(25,5,$n.".- ".$rowsG[1]["departamento"],1,0,'L');

						$this->Cell(25,5,$rowsG[1]["provincia"],1,0,'L');

						$this->Cell(30,5,$rowsG[1]["distrito"],1,0,'L');
						
						$this->Cell(20,5,substr(strtoupper($rows["localidad"]),0,14),1,0,'L');

						$this->Cell(15,5,$rows["zona"],1,0,'C');

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

						$this->Cell(20,5,strtoupper($rows["tinterven"]),"LRB",1,'C');



				}

				

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

				$this->Cell(145,5,"Total =>",1,0,'R');

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

		//	}

			

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

			$this->Cell(25,5,"localidadidad","LRT",0,'C');

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

			
			$this->SetFont('Arial','',5);
			
			$queryDGs = "select iddepartamento, idprovincia, iddistrito, localidad, departamento, provincia, distrito 
						from vista_consolidado  where estareg=1 and idconsolidado=".$id." 
						group by iddepartamento, idprovincia, iddistrito,localidad,departamento, provincia, distrito";

						
		//	echo $queryG;
			$rowsG = $this->execute_select($queryDGs);
			
			

			$queryD = "select f.localidad, sum(f.c1) as tanque, sum(f.c2) as barril, sum(f.c3) as baldes, sum(f.c4) as ollas,
						sum(f.c5) as floreros, sum(f.c6) as llantas, sum(f.c7) as inservibles, 
						sum(f.c8) as orecipientes, sum(f.c1positivo) as c1, sum(f.c2positivo) as c2, 
						sum(f.c3positivo) as c3, sum(f.c4positivo) as c4, sum(f.c5positivo) as c5, 
                        sum(f.c6positivo) as c6, 
						sum(f.c7positivo) as c7, sum(f.c8positivo) as c8 
						from consolidado_muestra as f 
						where f.idconsolidado=".$id." 
                        group by f.localidad
					";
				//	  echo $queryD;
				    $resultadod  = $this->execute_select($queryD,1);
					foreach($resultadod[1] as $rows){


			//	$op=1;

				$tc1 	= ($rows["c1"]*100)/($rows["tanque"]!=0?$rows["tanque"]:1);

				$tc2	= ($rows["c2"]*100)/($rows["barril"]!=0?$rows["barril"]:1);

				$tc3	= ($rows["c3"]*100)/($rows["baldes"]!=0?$rows["baldes"]:1);

				$tc4	= ($rows["c4"]*100)/($rows["ollas"]!=0?$rows["ollas"]:1);

				$tc5	= ($rows["c5"]*100)/($rows["floreros"]!=0?$rows["floreros"]:1);

				$tc6	= ($rows["c6"]*100)/($rows["llantas"]!=0?$rows["llantas"]:1);

				$tc7	= ($rows["c7"]*100)/($rows["inservibles"]!=0?$rows["inservibles"]:1);

				$tc8	= ($rows["c8"]*100)/($rows["inservibles"]!=0?$rows["inservibles"]:1);

				

				$totInspeccionados 	= $rows["tanque"]+$rows["barril"]+$rows["baldes"]+$rows["ollas"]+$rows["floreros"]+$rows["llantas"]+$rows["inservibles"]+$rows["orecipientes"];

				$totPositivos		= $rows["c1"]+$rows["c2"]+$rows["c3"]+$rows["c4"]+$rows["c5"]+$rows["c6"]+$rows["c7"]+$rows["c8"];

				

				$totGenerado 		= ($totPositivos*100)/($totInspeccionados!=0?$totInspeccionados:1);

				

				$this->SetX($x);

				$this->Cell(20,5,$rowsG[1]["departamento"],"LRT",0,'L');

				$this->Cell(20,5,$rowsG[1]["provincia"],"LRT",0,'L');

				$this->Cell(26,5,$rowsG[1]["distrito"],"LRT",0,'L');

				$this->Cell(25,5,$rows["localidad"],"LRT",0,'L');

				$this->Cell(20,5,"Inspeccionados","LRB",0,'L');

				$this->Cell(20,5,$rows["tanque"],"LRB",0,'C');

				$this->Cell(20,5,$rows["barril"],"LRB",0,'C');

				$this->Cell(20,5,$rows["baldes"],"LRB",0,'C');

				$this->Cell(20,5,$rows["ollas"],"LRB",0,'C');

				$this->Cell(20,5,$rows["floreros"],"LRB",0,'C');

				$this->Cell(20,5,$rows["llantas"],"LRB",0,'C');

				$this->Cell(20,5,$rows["inservibles"],"LRB",0,'C');

				$this->Cell(20,5,$rows["orecipientes"],"LRB",0,'C');

				$this->Cell(20,5,$totInspeccionados,"LRB",1,'C');

				

				$this->SetX($x);

				$this->Cell(20,5,"","LR",0,'L');

				$this->Cell(20,5,"","LR",0,'L');

				$this->Cell(26,5,"","LR",0,'L');

				$this->Cell(25,5,"","LR",0,'L');

				$this->Cell(20,5,"Positivos","LRB",0,'L');

				$this->Cell(20,5,$rows["c1"],"LRB",0,'C');

				$this->Cell(20,5,$rows["c2"],"LRB",0,'C');

				$this->Cell(20,5,$rows["c3"],"LRB",0,'C');

				$this->Cell(20,5,$rows["c4"],"LRB",0,'C');

				$this->Cell(20,5,$rows["c5"],"LRB",0,'C');

				$this->Cell(20,5,$rows["c6"],"LRB",0,'C');

				$this->Cell(20,5,$rows["c7"],"LRB",0,'C');

				$this->Cell(20,5,$rows["c8"],"LRB",0,'C');

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


			$rp  = $this->execute_select("select observacion from consolidado where idconsolidado=".$id);


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

	
	$pdf=new impresion();
	$pdf->AliasNbPages();
    $pdf->AddPage("L");
	$pdf->contenido($fechainicio,$fechafinal,$codred,$codmicrored,$codestablecimiento);
	$pdf->Output();	
	
?>