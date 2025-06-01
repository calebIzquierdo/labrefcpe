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

	$finicio = $_REQUEST["finicio"];
	$ffinal =  $_REQUEST["ffinal"];
	
	
				
	$consulta1 = "select count(*) as total from vista_data_alimentos_aguas 					
					where '[".$finicio.", ".$ffinal."]'::daterange @> fecharecepcion";
	

    $cuenta = $objconfig->execute_select($consulta1 );

   	if($cuenta[1]["total"] > 0 ){
	
		if (PHP_SAPI == "cli")
            die("Este archivo solo se puede ver desde un navegador web");


		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Soporte Técnico") //Autor
							 ->setLastModifiedBy("Soporte Técnico") //Ultimo usuario que lo modificó
							 ->setTitle("REPORTE DE DATOS ALIMENTOS Y AGUAS")
							 ->setSubject("Reporte Excel con PHP y PostgreSql")
							 ->setDescription("LABORATORIO REFERENCIAL REGIONAL DE SALUD PUBLICA DE SAN MARTIN")
							 ->setKeywords("REPORTE DE MUESTRAS RECEPCIONADAS")
							 ->setCategory("Reporte excel");
		
		$tituloReporte = "REPORTE DE MUESTRAS RECEPCIONADAS ALIMENTOS Y AGUAS - LABORATORIO REFERENCIAS DE SAN MARTIN ";
		$desde = "DESDE: ".$objconfig->FechaDMY($finicio)." HASTA ".$objconfig->FechaDMY($ffinal)." ";
		
		$titulosColumnas = array("Nro","Fecha Recepción","Año","Mes1","Mes","Matriz","Sub MAtrix","Codigo Barra","Solicitante", "Tipo Atención","Examen");

        // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A3:K3')
            ->mergeCells('A4:K4')
			->mergeCells('A5:K5')
           
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
					->setCellValue("I6",  $titulosColumnas[8])
					->setCellValue("J6",  $titulosColumnas[9])
					->setCellValue("K6",  $titulosColumnas[10])
					/*->setCellValue("L6",  $titulosColumnas[11])
					->setCellValue("M6",  $titulosColumnas[12])
					->setCellValue("N6",  $titulosColumnas[13])
					->setCellValue("O6",  $titulosColumnas[14])
					->setCellValue("P6",  $titulosColumnas[15])
					->setCellValue("Q6",  $titulosColumnas[16])
					->setCellValue("R6",  $titulosColumnas[17])
					->setCellValue("S6",  $titulosColumnas[18])
					->setCellValue("T6",  $titulosColumnas[19])
                    ->setCellValue("U6",  $titulosColumnas[20])	
					->setCellValue("V6",  $titulosColumnas[21])
					->setCellValue("W6",  $titulosColumnas[22])
					->setCellValue("X6",  $titulosColumnas[23])
					->setCellValue("Y6",  $titulosColumnas[24])
					->setCellValue("Z6",  $titulosColumnas[25])
					
					*/
                    ;
        
		// Se agrega el fitrado de las columnas 
		$objPHPExcel->getActiveSheet()->setAutoFilter("A6:K6");

     	$i = 7; //Numero de fila donde se va a comenzar a rellenar
        $n =0;
					
        $consulta = "select * from vista_data_alimentos_aguas where '[".$finicio.", ".$ffinal."]'::daterange @> fecharecepcion";

        $resultado = $objconfig->execute_select($consulta,1 );

		foreach ( $resultado[1] as $fila )
		{
            $n++;

            //Se agregan los datos de los alumnos
            $objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $n)
				->setCellValue('B'.$i, $objconfig->FechaDMY($fila['fecharecepcion']))
				->setCellValueExplicit('C'.$i, $fila['anio'],PHPExcel_Cell_DataType::TYPE_STRING )
				->setCellValue('D'.$i, $fila['mesnum'])
				->setCellValue('E'.$i, utf8_decode($fila['mes'] ))				
				->setCellValue('F'.$i, utf8_decode($fila['alimento']))
				->setCellValue('G'.$i, utf8_decode($fila['subalimento']))
				->setCellValueExplicit('H'.$i, $fila['codbarra'],PHPExcel_Cell_DataType::TYPE_STRING )				
				->setCellValue('I'.$i, utf8_decode($fila['establecimiento']))
				->setCellValue('J'.$i, $fila['tipoatencion'])
				->setCellValue('K'.$i, $fila['tipoexamen'])
		/*  
				->setCellValue('L'.$i, strtoupper($fila['rdes']))
				->setCellValue('M'.$i, strtoupper($estab[1]['eje']))
				->setCellValue('N'.$i, strtoupper($comp))
				->setCellValue('O'.$i, $nrocomprobante)
                ->setCellValueExplicit('P'.$i, strtoupper($fila['razonsocial']) ,PHPExcel_Cell_DataType::TYPE_STRING )
                ->setCellValueExplicit('Q'.$i, $fila['tipodocumento'])
                ->setCellValueExplicit('R'.$i, $fila['ruc'])
                ->setCellValue('S'.$i, $fpago)
                ->setCellValue('T'.$i, $fila['tipopago'])
                ->setCellValueExplicit('U'.$i, $pago[1]['valor'],PHPExcel_Cell_DataType::TYPE_STRING )
                ->setCellValueExplicit('V'.$i, $pago[1]['descuento'],PHPExcel_Cell_DataType::TYPE_STRING )
                ->setCellValueExplicit('W'.$i, $vfact,PHPExcel_Cell_DataType::TYPE_STRING )
            ->setCellValue('S'.$i, strtoupper($diagnosticosTip)) 
                ->setCellValue('T'.$i, strtoupper($diagTip22))
				->setCellValue('U'.$i, $Fymd)
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
		$objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A4:K4')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, 'A7:K'.($i-1));
        $objPHPExcel->getActiveSheet()->getStyle('A7:K'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
       
       
		for($i = 'A'; $i <= 'K'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)
				//->getColumnDimension($i)->setAutoSize(TRUE);
				->getColumnDimension($i)->setAutoSize(true)->setWidth("15");
			}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('MuestraRecepcionada');

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
		$fecha = date("d/m/Y h:i:s a ");
		$hora = date("h_i_s");
	 
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=ReporteMuestras_$hora.xlsx");
        header("Cache-Control: max-age=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save("php://output");
		exit;
		//return true;
	}
	
	else{
		echo "<script> alert('No hay Registro que Mostrar') 
		location.href='index.php' 
		 window.close()
		</script>  ";
		//print_r("No hay rows para mostrar");
		}

?>
