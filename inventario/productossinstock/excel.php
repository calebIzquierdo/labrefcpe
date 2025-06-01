<?php
	
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

	$idcodigo = $_REQUEST["id"];
	if (PHP_SAPI == "cli")
		die("Este archivo solo se puede ver desde un navegador web");


		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Soporte Técnico")
							 ->setLastModifiedBy("Soporte Técnico")
							 ->setTitle("LISTA DE MATERIALES SIN STOCK")
							 ->setSubject("Reporte Excel con PHP y PostgreSql")
							 ->setDescription("LABORATORIO REFERENCIAL REGIONAL DE SALUD PUBLICA DE SAN MARTIN")
							 ->setKeywords("LISTA DE MATERIALES SIN STOCK")
							 ->setCategory("Reporte excel");
		
		$tituloReporte = "LABORATORIO REFERENCIAS DE SAN MARTIN";
		$tituloReporte1 = "LISTA DE MATERIALES SIN STOCK";
			
		$titulosColumnas = array("#", "Requerimiento", "Fecha Registro", "Area Solicitante", "Tipo", "Material","Especificaciones", "Cant. Requerida", "Cant. Aprobada", "Stock");

        // Se combinan las celdas A1 hasta H1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1')->mergeCells('A2:H2')->mergeCells('A3:H3');

       // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A1",  $tituloReporte)
				    ->setCellValue("A2",  $tituloReporte1)

					->setCellValue("A4",  $titulosColumnas[0])
        		  	->setCellValue("B4",  $titulosColumnas[1])
					->setCellValue("C4",  $titulosColumnas[2])
					->setCellValue("D4",  $titulosColumnas[3])
					->setCellValue("E4",  $titulosColumnas[4])
					->setCellValue("F4",  $titulosColumnas[5])
					->setCellValue("G4",  $titulosColumnas[6])
					->setCellValue("H4",  $titulosColumnas[7])
					->setCellValue("I4",  $titulosColumnas[8])
					->setCellValue("J4",  $titulosColumnas[9]);
            	
		$objPHPExcel->getActiveSheet()->setAutoFilter("A4:I4");

		// Numero de fila donde se va a comenzar a rellenar
     	$i = 5;
        $n = 0;
	
        $consulta = "SELECT * FROM vista_materiales_sin_stock WHERE estareg = 4 AND stock = 0";
        $resultado = $objconfig->execute_select($consulta, 1 );

		foreach ($resultado[1] as $fila)
		{ 
			$n++;
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $n)
				->setCellValue('B'.$i, strtoupper($fila['correlativo']))
				->setCellValue('C'.$i, $fila['fecharegistro'])
				->setCellValue('D'.$i, $fila['solicitante'])
				->setCellValue('E'.$i, strtoupper($fila['tipo']))
				->setCellValue('F'.$i, strtoupper($fila['material']))
				->setCellValue('G'.$i, strtoupper($fila['especificaciones']))
				->setCellValue('H'.$i, $fila['cantidad'])
				->setCellValue('I'.$i, strtoupper($fila['cant_aprobada']))
				->setCellValue('J'.$i, strtoupper($fila['stock']));
			$i++;
		}

		$estiloTituloReporte = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' 		=> 16,
                'color'     => array('rgb' => '000000')
            ),
            'fill' => array(
				'type'  	=> PHPExcel_Style_Fill::FILL_SOLID,
			),
            'borders' => array(
               	'allborders' => array(
                	'style'  => PHPExcel_Style_Border::BORDER_NONE
               	)
            ),
            'alignment' =>  array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'       => TRUE
			)
        );


        $estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'color'     => array('rgb' => 'FFFFFF')
            ),
            'fill'	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'  => 90,
        		'startcolor'=> array('rgb' => '6699FF'),
        		'endcolor'  => array('argb'	=> '6699FF')
			),
            'borders' => array(
            	'top'   => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
					'color' => array('rgb'	=> '000000')
                ),
                'bottom'	=> array(
					'style'		=> PHPExcel_Style_Border::BORDER_MEDIUM ,
					'color'		=> array('rgb' => '000000')
                )
            ),
			'alignment' =>  array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				"justify"	 => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY ,
				'wrap'       => TRUE
    		)
		);
			

		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' 		=> array(
					'name'      => 'Arial',
					'color'     => array('rgb' => '000000')
				),
				'fill' 	=> array(
					'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
					'color'		=> array('argb' => 'ECEBEC')
				),
				'borders' 	=> array(
					'left'  => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN ,
						'color' => array('rgb' => '3a2a47')
					),
					'right'  => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN ,
						'color' => array('rgb' => '3a2a47')
					),
					'top'  => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN ,
						'color' => array('rgb' => '3a2a47')
					),
					'bottom'  => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN ,
						'color' => array('rgb' => '3a2a47')
					)
				)
        	)
		);

		$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A4:J4')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, 'A5:J'.($i-1));   
       
		for($i = 'A'; $i <= 'J'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Materiales Sin Stock');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);

		// Inmovilizar paneles 
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 5);

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
		$fecha = date("d/m/Y h:i:s a ");
		$hora = date("h_i_s");
	 
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=MaterialesSinStock$hora.xlsx");
        header("Cache-Control: max-age=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save("php://output");
		exit;
	
		echo "<script> 
				alert('No hay Registro que Mostrar') 
				location.href='index.php' 
		 		window.close()
			</script>";


?>