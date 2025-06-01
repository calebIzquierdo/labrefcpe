<?php
 /* Ejemplo 1 generando excel desde mysql con PHP
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
					
	$consulta = "select COUNT (idreferencia) as total from vista_referencia where fecreferencia BETWEEN '".$finicio."' and '".$ffinal."' ";
    $cuenta = $objconfig->execute_select($consulta );

   	if($cuenta[1]["total"] > 0 ){
	
		if (PHP_SAPI == "cli")
            die("Este archivo solo se puede ver desde un navegador web");


		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Computer Solution") //Autor
							 ->setLastModifiedBy("Soporte Técnico") //Ultimo usuario que lo modificó
							 ->setTitle("REPORTE DE REFERENCIAS Y CONTRARREFERENCIAS")
							 ->setSubject("Reporte Excel con PHP y PostgreSql")
							 ->setDescription("HOSPITAL RURAL - SISA")
							 ->setKeywords("REPORTE DE REFERENCIAS Y CONTRARREFERENCIA")
							 ->setCategory("Reporte excel");

		$tituloReporte = "PACIENTES REFERIDOS Y CONTRARREFERIDOS  PERIFERIE 2018";
		$desde = "DESDE: ".$finicio." HASTA ".$ffinal." ";
		$seguro = "ES AFILIADO AL SIS?";
		$referencia = "REFERENCIA ";
		//$referencia = array("REFERENCIA");
		$titulosColumnas = array("N°","MES","RED","MICRORED","E.E. S.S. ORIGEN","FECHA REFERENCIA","HIST. CLIN","APELLIDOS Y NOMBRES","EDAD","D.N.I","SIS","ESSALUD","CONS. EXTER.","EMERG","APOYO DIAG.","DIAGNOSTICO REFERENCIA","EE.SS. DESTINO ","FECHA CONTRARREFERENCIA","DIAGNOSTICO CONTRARREFERENCIA");

        // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('B3:T3')
            ->mergeCells('B4:T4')
            ->mergeCells('L5:M5')
            ->mergeCells('N5:P5');

       // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("B3",  $tituloReporte)
					->setCellValue("B4",  $desde)
        		    ->setCellValue("L5",  $seguro )
		            ->setCellValue("N5",  $referencia )
        		   	->setCellValue("B6",  $titulosColumnas[0])
					->setCellValue("C6",  $titulosColumnas[1])
					->setCellValue("D6",  $titulosColumnas[2])
					->setCellValue("E6",  $titulosColumnas[3])
					->setCellValue("F6",  $titulosColumnas[4])
					->setCellValue("G6",  $titulosColumnas[5])
					->setCellValue("H6",  $titulosColumnas[6])
					->setCellValue("I6",  $titulosColumnas[7])
					->setCellValue("J6",  $titulosColumnas[8])
					->setCellValue("K6",  $titulosColumnas[9])
					->setCellValue("L6",  $titulosColumnas[10])
					->setCellValue("M6",  $titulosColumnas[11])
					->setCellValue("N6",  $titulosColumnas[12])
					->setCellValue("O6",  $titulosColumnas[13])
					->setCellValue("P6",  $titulosColumnas[14])
					->setCellValue("Q6",  $titulosColumnas[15])
					->setCellValue("R6",  $titulosColumnas[16])
					->setCellValue("S6",  $titulosColumnas[17])
					->setCellValue("T6",  $titulosColumnas[18])
                    ;
            		//->setCellValue("I6",  $titulosColumnas[8]);

//		$objPHPExcel->getActiveSheet()->setAutoFilter("B6:U6");

     	$i = 7; //Numero de fila donde se va a comenzar a rellenar
        $n =0;

        $consulta = "select * from vista_referencia where fecreferencia BETWEEN '".$finicio."' and '".$ffinal."' order by fecreferencia asc";

        $resultado = $objconfig->execute_select($consulta,1 );

		foreach ( $resultado[1] as $fila )
		{
            $n++;
            $mes_det = explode ("-",$objconfig->FechaDMY($fila['fecreferencia']));

            if ($fila['idseguro']==1){
                $SIS = "X";
                $ESSALUD = "";
            } else {
                $SIS = " ";
                $ESSALUD = "X";
            }

            switch ($fila['idtiporeferencia']) {
                case 1:
                    $CONSEXT = "X";
                    $EMERGE = "";
                    $DX = "";
                    break;
                case 2:
                    $CONSEXT = "";
                    $EMERGE = "X";
                    $DX = "";
                    break;
                case 3:
                    $CONSEXT = "";
                    $EMERGE = "";
                    $DX = "X";
                    break;
            }

            $diagnosticos="";

            $row6 = $objconfig->execute_select("select iddiagnostico from referencia_diagnostico 
													where idreferencia=".$fila["idreferencia"],1);
            $dg=0;
            foreach($row6[1] as $r6)
            {
                $dg++;
                $rowsDiag = $objconfig->execute_select("SELECT descripcion FROM diagnostico WHERE iddiagnostico =".$r6["iddiagnostico"]);
                $diagnosticos.=$dg.".-". preg_replace('/( ){2,}/u',' ',$rowsDiag[1]["descripcion"])." ";
            }

            $rowctr = $objconfig->execute_select("select idcontrareferencia, fegreso from contrareferencia 
														where idreferencia=".$fila["idreferencia"]);
            if ($rowctr[1]['fegreso']==""){
                $fegreso="";
            }else {
                $fegreso =  $objconfig->FechaDMY($rowctr[1]['fegreso']);
            }

            $diag="";

            $rdg = $objconfig->execute_select("select iddiagnostico from contra_diagnostico 
													where idreferencia=".$fila["idreferencia"],1);
            $dg2=0;
            foreach($rdg[1] as $rwdg)
            {
                $dg2++;
                $rowsDiag2 = $objconfig->execute_select("SELECT descripcion FROM diagnostico WHERE iddiagnostico =".$rwdg["iddiagnostico"]);
                $diag.=$dg2.".-". preg_replace('/( ){2,}/u',' ',$rowsDiag2[1]["descripcion"])." ";
            }

            //Se agregan los datos de los alumnos
            $objPHPExcel->setActiveSheetIndex(0)
			//	->setCellValue("C3", strtoupper($fila["productor"]))
			//	->setCellValueExplicit("C4", $fila["nrodocumento"], PHPExcel_Cell_DataType::TYPE_STRING)

				->setCellValue('B'.$i,  $n)
				->setCellValue('C'.$i, ($mes_det[1]) )
				->setCellValue('D'.$i, strtoupper($fila['red']) )
				->setCellValue('E'.$i, strtoupper($fila['mrored']) )
				->setCellValue('F'.$i, strtoupper($fila['estable']) )
				->setCellValue('G'.$i, $objconfig->FechaDMY($fila['fecreferencia']))
				->setCellValueExplicit('H'.$i, $fila['historiaclin'],PHPExcel_Cell_DataType::TYPE_STRING )
				->setCellValue('I'.$i, strtoupper($fila['pacientes']))
				->setCellValue('J'.$i, strtoupper($fila['edadactual']))
                ->setCellValueExplicit('K'.$i, $fila['dni'],PHPExcel_Cell_DataType::TYPE_STRING )
                ->setCellValue('L'.$i, strtoupper($SIS))
                ->setCellValue('M'.$i, strtoupper($ESSALUD))
                ->setCellValue('N'.$i, strtoupper($CONSEXT))
                ->setCellValue('O'.$i, strtoupper($EMERGE))
                ->setCellValue('P'.$i, strtoupper($DX))
                ->setCellValue('Q'.$i, strtoupper($diagnosticos))
                ->setCellValue('R'.$i, strtoupper($fila['estdestino']))
                ->setCellValue('S'.$i, $fegreso)
                ->setCellValue('T'.$i, strtoupper($diag))
                //->setCellValue('U'.$i, strtoupper($fila['tipseg']))
                ;
				//->setCellValue("D".$i, utf8_encode($fila["carrera"]));
				$i++;

		}

		$estiloTituloReporte = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>16,
                'color'     => array(
                    'rgb' => '000000' //color negro
                )
            ),
            'fill' => array(
                    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
				//"color"	=> array("argb" => "FF220835")
                //'color'	=> array('argb' => 'ffffff')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE
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
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
        		'startcolor' => array(
            		//'rgb' => '000000' // Color de Fondo de la Tabla
            		'rgb' => '6699FF' // Color de Fondo de la Tabla
        		),
        		'endcolor'   => array(
            		'argb' => '6699FF' // COntraste del fondo de la tabla
        		)
			),
            'borders' => array(
            	'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000' // Color de los bordes Superior
                    )
                ),
                'bottom'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000' // Borde inferior de la tabla
                    )
                )
            ),
			'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'wrap'       => TRUE
    		));

		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' => array(
               	'name'      => 'Arial',
               	'color'     => array(
                   	'rgb' => '000000'
               	)
           	),
           	'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'C0C0C0')
			),
           	'borders' => array(
               	'left'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '3a2a47'
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
		$objPHPExcel->getActiveSheet()->getStyle('B3:T3')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('B4:T4')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('B6:T6')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, 'B7:T'.($i-1));
        $objPHPExcel->getActiveSheet()->getStyle('G7:H'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('K7:K'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('L7:P'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		for($i = 'B'; $i <= 'T'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)
				->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Referencias');

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
        header("Content-Disposition: attachment;filename=ReporteReferencias_$hora.xlsx");
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