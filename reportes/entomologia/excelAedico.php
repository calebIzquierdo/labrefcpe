<?php
 /* 
	Ejemplo 1 generando excel desde PostgresSqql con PHP
    @Autor: Carlos Hernan Aguilar Hurtado
	date_default_timezone_set("America/Lima");
*/
	
	include("../../objetos/class.conexion.php");
    $objconfig = new conexion();

	//Se agrega la libreria PHPExcel */
	include("../../objetos/excel/PHPExcel.php");

	// Se crea el objeto PHPExcel
	$objPHPExcel = new PHPExcel();

	// setting page Header && Footer
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader("&CPlease treat this document as confidential!");

	// adding LOGO to the header
	$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
	$objDrawing->setName("Logo");
	$objDrawing->setDescription("Logo");
	$objDrawing->setPath("../../img/banner_inferior.png");
	$objDrawing->setHeight(80);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_CENTER);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader("&C&G");
	
	global $fechainicio,$fechafinal,$codred,$codmicrored,$codestablecimiento,$codpar;
	
	$fechainicio	=	$_GET["finicio"];
	$fechafinal		=	$_GET["ffinal"];
	$codred			=	$_GET["idr"];
	$codmicrored	=	$_GET["idmr"];
	$codestablecimiento	= $_GET["idests"];
	$codpar			= 	$_GET["codp"];
	
	$indVivienda        = 0;
	$indBreteau         = 0;
	$indRecipiente      = 0;
	$grado              = "";
	$tvinspec			= 0;
	$tmrecibida			= 0;
	$tvpositiva			= 0;
	$trinspeccionado	= 0;
	$trpositiva			= 0;
	$tvinspec1			= 0;
	$tmrecibida1		= 0;
	$tvpositiva1		= 0;
	$trinspeccionado1	= 0;
	$trpositiva1		= 0;

    $and="";

	if($codred!=0 ){$and .= " and codred=".$codred;}
	if($codmicrored!=0 && !isset($codmicrored)){$and .= " and codmred=".$codmicrored;}
	if($codestablecimiento!=0 && $codestablecimiento!='undefined'){$and .= " and idestablesolicita=".$codestablecimiento;}

	
	$consulta1 = "select COUNT (*) as total from vista_aedes_consolidado where estareg=1 AND idestadomuestra!=2 and 
				 fechainicio BETWEEN '".$fechainicio."' and '".$fechafinal."' ".$and;
	
    $cuenta = $objconfig->execute_select($consulta1 );
	
   	if($cuenta[1]["total"] > 0 ){
	
		if (PHP_SAPI == "cli")
            die("Este archivo solo se puede ver desde un navegador web");


		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Soporte Técnico") //Autor
							 ->setLastModifiedBy("Soporte Técnico") //Ultimo usuario que lo modificó
							 ->setTitle("REPORTE DE MUESTRAS ENTOMOLÓGICA")
							 ->setSubject("Reporte Excel con PHP y PostgreSql")
							 ->setDescription("LABORATORIO REFERENCIAL REGIONAL DE SALUD PUBLICA DE SAN MARTIN")
							 ->setKeywords("REPORTE DE MUESTRAS ENTOMOLÓGICA")
							 ->setCategory("Reporte excel");
		
		$tituloReporte = "REPORTE DE MUESTRAS ENTOMOLÓGICA - LABORATORIO REFERENCIAS DE SAN MARTIN ";
		$desde = "DESDE: ".$objconfig->FechaDMY($fechainicio)." HASTA ".$objconfig->FechaDMY($fechafinal)." ";
		
		$titulosColumnas = array("Nro","Departamento","Provincia","Distrito","Localidad","Latitud","Longitud","Zona","Fecha Trabajo I","Fecha Trabajo F",
								 "Fecha Recepción","Viviendad Inspeccionada","Muestra Recibida","Vivienda Positiva","Recipiente Inspeccionado",
								 "Recipiente Positivo","Indice Vivienda","Indice Breteau","Indice de Recipiente","Grado de Insfect.","Tipo de Interv." );

        // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A3:M3')
            ->mergeCells('A4:M4')
			->mergeCells('A5:M5')
           
			;

       // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A3",  $tituloReporte)
					->setCellValue("A4",  $desde)
        		 //   ->setCellValue("L5",  $seguro )
		         //   ->setCellValue("N5",  $referencia )
        	->setCellValue("A6",  $titulosColumnas[0])
        	->setCellValue("B6",  $titulosColumnas[1])
					->setCellValue("C6",  $titulosColumnas[2])
					->setCellValue("D6",  $titulosColumnas[3])
					->setCellValue("E6",  $titulosColumnas[4])
					->setCellValue("F6",  $titulosColumnas[5])
					->setCellValue("G6",  $titulosColumnas[6])
					->setCellValue("H6",  $titulosColumnas[7])

					->setCellValue("I6",  $titulosColumnas[8]) ///finicio

					->setCellValue("J6",  $titulosColumnas[9]) ///ffin

					->setCellValue("K6",  $titulosColumnas[10])
					->setCellValue("L6",  $titulosColumnas[11])
					->setCellValue("M6",  $titulosColumnas[12])
					->setCellValue("N6",  $titulosColumnas[13])
					->setCellValue("O6",  $titulosColumnas[14])
					->setCellValue("P6",  $titulosColumnas[15])
					->setCellValue("Q6",  $titulosColumnas[16])
					->setCellValue("R6",  $titulosColumnas[17])
					->setCellValue("S6",  $titulosColumnas[18])
					->setCellValue("T6",  $titulosColumnas[19])
					->setCellValue("U6",  $titulosColumnas[20])
				/*		->setCellValue("U6",  $titulosColumnas[20])
					->setCellValue("V6",  $titulosColumnas[21])
					->setCellValue("W6",  $titulosColumnas[22])
					->setCellValue("X6",  $titulosColumnas[23])
					->setCellValue("Y6",  $titulosColumnas[24])
					->setCellValue("Z6",  $titulosColumnas[25])
					
					*/
                    ;
            	
		$objPHPExcel->getActiveSheet()->setAutoFilter("A6:M6");

     	$i = 7; //Numero de fila donde se va a comenzar a rellenar
        $n =0;
		
		$and="";
		if($codred!=0 ){$and .= " and f.codred=".$codred;}
		if($codmicrored!=0 && !isset($codmicrored)){$and .= " and f.codmred=".$codmicrored;}
		if($codestablecimiento!=0 && $codestablecimiento!='undefined'){$and .= " and f.idestablesolicita=".$codestablecimiento;}

		
        $resultado = $objconfig->execute_select($queryG,1 );

		//foreach ( $resultado[1] as $fila ){
					
           // $n++;
            $tvinspec1          = 0;
			$tmrecibida1        = 0;
			$tvpositiva1        = 0;
			$trinspeccionado1   = 0;
			$trpositiva1        = 0;
			
			
			$objconfig->execute_select("delete from tmp_ficha_entomologica_aedes");
		 	$objconfig->cargar_ficha_entomologicaAedico($fechainicio,$fechafinal,$rowsG[1]["iddepartamento"],$rowsG[1]["idprovincia"],$rowsG[1]["iddistrito"],$rowsG[1]["local"],$and);
            $queryW = "select * from tmp_ficha_entomologica_aedes order by departamento, provincia,distrito, local, zona asc";
		
			$rowsD = $objconfig->execute_select($queryW,1);
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

				$fitrabajo 	= explode("-",$rows["fechainicio"]); //$fitrabajo [0]=20 $fitrabajo [1]=02 $fitrabajo [2]=2023 
				$frecepcion = explode("-",$rows["fecharecepcion"]); //$fitrabajo [0]=24 $fitrabajo [1]=02 $fitrabajo [2]=2023
				$ffin 		= explode("-",$rows["fechatermino"]);

			/*
			if ($rows["zona"]==0){
				$zona = "UNICA";
			} else {
				$zona = $rows["zona"];
			}
		*/
		
            //Se agregan los datos de los alumnos
            $objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $n)
				->setCellValue('B'.$i, $rows["departamento"])
				//->setCellValueExplicit('C'.$i, $fila['codbarra'],PHPExcel_Cell_DataType::TYPE_STRING )
				->setCellValue('C'.$i, $rows["provincia"])
				->setCellValue('D'.$i, strtoupper($rows["distrito"]))
				->setCellValue('E'.$i, strtoupper(utf8_decode($rows["local"])))
				->setCellValue('F'.$i, strtoupper(utf8_decode($rows["latitud"])) )
				->setCellValue('G'.$i, strtoupper(utf8_decode($rows["longitud"])) )
				//->setCellValue('H'.$i, strtoupper($rows["zona"]))
				->setCellValue('H'.$i, strtoupper($rows["zona"]))

				//->setCellValue('I'.$i, $fitrabajo[2]."-".($ffin[2]."/".$ffin[1]."/".$ffin[0]))
				->setCellValue('I'.$i, $fitrabajo[2]."/".$fitrabajo[1]."/".$fitrabajo[0])
				->setCellValue('J'.$i, $ffin[2]."/".$ffin[1]."/".$ffin[0])
				// ->setCellValue('J'.$i, $rows["fechatermino"])
				->setCellValue('K'.$i, $frecepcion[2]."/".$frecepcion[1]."/".$frecepcion[0])
				->setCellValue('L'.$i, strtoupper($rows["vinspec"]) )
				->setCellValue('M'.$i, strtoupper($rows["mrecibida"]))
				->setCellValue('N'.$i, strtoupper($rows["vpositiva"]))
				->setCellValue('O'.$i, strtoupper($rows["rinspeccionado"]))
                ->setCellValue('P'.$i, $rows["rpositiva"])
                ->setCellValue('Q'.$i, number_format($indVivienda,2))
                ->setCellValue('R'.$i, number_format($indBreteau,2))
                ->setCellValue('S'.$i, number_format($indRecipiente,2))
                ->setCellValue('T'.$i, $grado)
                ->setCellValue('U'.$i, strtoupper($rows["tintervencion"]))
			/*	->setCellValue('U'.$i, $Fymd)
				->setCellValue('V'.$i, $objconfig->FechaDMY($fila['fecharecepcion']))
				->setCellValue('W'.$i, $objconfig->FechaDMY($fila['fllegada']))
				->setCellValue('X'.$i, strtoupper($fila['pacientes']))
                ->setCellValue('Y'.$i, $fila['idpoblacion'])
                ->setCellValue('Z'.$i, strtoupper($fila['celular']))
                ->setCellValue('AA'.$i, strtoupper($fila['codseguro']))
                ->setCellValue('AB'.$i, strtoupper($origPasc[1]['descripcion']." / ".$origPasc[1]['provincia']))
				->setCellValueExplicit('AC'.$i, $fila['nroreferencia'],PHPExcel_Cell_DataType::TYPE_STRING )
                ->setCellValue('AD'.$i, $ContraRefe)  
           
				*/
                ;

				$i++;
			}
		//}

		$estiloTituloReporte = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' 		=> 16,
                'color'     => array(
				'rgb'		=> '000000' //color negro
                )
            ),
            'fill' => array(
				'type'  	=> PHPExcel_Style_Fill::FILL_SOLID,
				//"color"	=> array("argb" => "FF220835")
                //'color'	=> array('argb' => 'ffffff')
			),
            'borders' => array(
               	'allborders' => array(
                'style' 	=> PHPExcel_Style_Border::BORDER_NONE
               	)
            ),
            'alignment' =>  array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			//	'justify'	 => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY ,
				'rotation'   => 0,
				'wrap'       => TRUE
			)
        );


        $estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'color'     => array(
                'rgb' 		=> 'FFFFFF'
                )
            ),
            'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'  => 90,
        		'startcolor'=> array(
				//'rgb' 	=> '000000' // Color de Fondo de la Tabla
            	'rgb' 		=> '6699FF' // Color de Fondo de la Tabla
        		),
        		'endcolor'  => array(
				'argb'		=> '6699FF' // COntraste del fondo de la tabla
        		)
			),
            'borders' => array(
            	'top'   => array(
				'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
				'color' => array(
				'rgb'	=> '000000' // Color de los bordes Superior
				)
                ),
                'bottom'	=> array(
                'style'		=> PHPExcel_Style_Border::BORDER_MEDIUM ,
                'color'		=> array(
                'rgb'		=> '000000' // Borde inferior de la tabla
                )
                )
            ),
			'alignment' =>  array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				"justify"	 => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY ,
				'wrap'       => TRUE
					
    		));
			

		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' 		=> array(
               	'name'      => 'Arial',
               	'color'     => array(
				'rgb' 		=> '000000'
               	)
           	),
           	'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'C0C0C0')
			),
           	'borders' => array(
               	'left'    	=> array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
					'rgb' 	=> '3a2a47'
                   	)
               	)
           	) /*
               ,
			'alignment' =>  array(
        			//'horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			//"vertical"   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					"justify"	 => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY ,
        			"rotation"   => 0,
        			"wrap"          => TRUE
    		) */
        ));

		//$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:U3')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A4:U4')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A6:U6')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, 'A7:U'.($i-1));
        $objPHPExcel->getActiveSheet()->getStyle('T7:U'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       
       
		for($i = 'A'; $i <= 'M'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)
				//->getColumnDimension($i)->setAutoSize(TRUE);
				->getColumnDimension($i)->setAutoSize(false)->setWidth("15");
			}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('ZonasInspeccionadas');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane("A4");
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,7);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		/* header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment; filename=millonarios_fc.doc");
		header("Pragma: no-cache");
		header("Expires: 0"); */

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
		//$fecha = date("d/m/Y h:i:s a ");
		$fecha = date("dmY");
		$hora = date("his");
		$time = $fecha."_".$hora;
	 
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=ConsolidadoAedico_$time.xlsx");
        header("Cache-Control: max-age=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save("php://output");
		exit;
		//return true;
	}
	
	else{
		echo "<script> alert('No hay Registro que Mostrar') 
	//	location.href='index.php' 
	//	 window.close()
		</script>  ";
		//print_r("No hay rows para mostrar");
		}

?>