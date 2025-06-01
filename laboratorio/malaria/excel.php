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

	$idcodigo = $_REQUEST["id"];
	if (PHP_SAPI == "cli")
            die("Este archivo solo se puede ver desde un navegador web");


		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Soporte Técnico") //Autor
							 ->setLastModifiedBy("Soporte Técnico") //Ultimo usuario que lo modificó
							 ->setTitle("Lista de Muestra Endemicas Procesadas")
							 ->setSubject("Reporte Excel con PHP y PostgreSql")
							 ->setDescription("LABORATORIO REFERENCIAL REGIONAL DE SALUD PUBLICA DE SAN MARTIN")
							 ->setKeywords("LISTA DE MUESTRAS PROCESADAS")
							 ->setCategory("Reporte excel");
		
		$query = "select * from aedes where idaedes=".$idcodigo;
		$row = $objconfig->execute_select($query);
		
		$codbarra = $row[1]["codbarra"];
		
		$esta= "select idestablecimiento, eje,red, micro, esta,codrenaes, idred, idmicrored from vista_establecimiento where idestablecimiento=".$row[1]["idestablesolicita"];
		$rowEstable = $objconfig->execute_select($esta);
		$establecimiento = $rowEstable[1]["codrenaes"]." - ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"];
					 
		$dist= "select iddistrito, descripcion, provincia, departamento from vista_distrito where iddistrito=".$row[1]["iddistrito"];
		$rowD = $objconfig->execute_select($dist);
		$rowDistri = $rowD[1]["descripcion"]." / ".$rowD[1]["provincia"]." / ".$rowD[1]["departamento"];
	
	
	
		$tituloReporte = "LABORATORIO REFERENCIAS REGIONAL DE SALUD PUBLICA DE SAN MARTIN";
		$tituloReporte1 = "LISTADO DE MUESTRAS PROCESADAS";
		
		$fechaRecep = "Fecha Recepcion";
		$fechainicio= "Fecha Inicio Trabajo";
		$distrito = "Distrito";
		$estable = "Establecimiento";
		$poblacion = "Población";
		$fechafinal = "Fecha Termino";
		$codbarraTitulo = "Código Barra";
		
		
		$titulosColumnas = array("#","T. VIV.","V. PROG","V. INSP","ZONA", "FECHA RECOJO", "MZA","FAMILIA","DIRECCION", "LAT", "LONG","INSPECTOR","FOCO","LARVA","PUPA","ADULTO", "AEDES","OTROS" );

        // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A3:R3')
            ->mergeCells('B4:R4')
            ->mergeCells('B6:c6')
            ->mergeCells('B7:c7')
            ->mergeCells('B8:c8')
            ->mergeCells('D8:I8')
            ->mergeCells('B9:c9')
            ->mergeCells('D9:I9')
           /* ->mergeCells('M6:N6')
            ->mergeCells('M7:N7')
           */
			;

       // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A3",  $tituloReporte)
				    ->setCellValue("B4",  $tituloReporte1 )
				    ->setCellValue("B6",  $fechaRecep )
				    ->setCellValue("B7",  $fechainicio )
				    ->setCellValue("B8",  $distrito )
				    ->setCellValue("B9",  $estable )
				    ->setCellValue("K6",  $poblacion )
				    ->setCellValue("K7",  $fechafinal )
				    ->setCellValue("K8",  $codbarraTitulo )
				    ->setCellValue("K9",  "Item" )
				    
					 ->setCellValue("D6", $objconfig->FechaDMY2($row[1]["fecharecepcion"]) )
				    ->setCellValue("D7",  $objconfig->FechaDMY2($row[1]["fechainicio"]) )
				    ->setCellValue("D8",  strtoupper(utf8_decode($rowDistri)) )
				    ->setCellValue("D9",  strtoupper(utf8_decode($establecimiento)) )
				    ->setCellValue("L6",  strtoupper(utf8_decode($row[1]["poblacion"])) )
				    ->setCellValue("L7",  $objconfig->FechaDMY2($row[1]["fechatermino"]) )
				    ->setCellValue("L8",  strtoupper(utf8_decode($codbarra)) )
				    ->setCellValue("L9",  strtoupper(utf8_decode($idcodigo)) )
					

					->setCellValue("A11",  $titulosColumnas[0])
        		  	->setCellValue("B11",  $titulosColumnas[1])
					->setCellValue("C11",  $titulosColumnas[2])
					->setCellValue("D11",  $titulosColumnas[3])
					->setCellValue("E11",  $titulosColumnas[4])
					->setCellValue("F11",  $titulosColumnas[5])
					->setCellValue("G11",  $titulosColumnas[6])
					->setCellValue("H11",  $titulosColumnas[7])
					->setCellValue("I11",  $titulosColumnas[8])
					->setCellValue("J11",  $titulosColumnas[9])
					->setCellValue("K11",  $titulosColumnas[10])
					->setCellValue("L11",  $titulosColumnas[11])
					->setCellValue("M11",  $titulosColumnas[12])
					->setCellValue("N11",  $titulosColumnas[13])
					->setCellValue("O11",  $titulosColumnas[14])
					->setCellValue("P11",  $titulosColumnas[15])
					->setCellValue("Q11",  $titulosColumnas[16])
					->setCellValue("R11",  $titulosColumnas[17])
							
                    ;
            	
		$objPHPExcel->getActiveSheet()->setAutoFilter("A11:R11");

     	$i = 12; //Numero de fila donde se va a comenzar a rellenar
        $n =0;
	
        $consulta = "select m.idaedes,m.idingresomuestra,m.codbarra,m.poblacion,m.fecharecepcion,m.fechainicio, m.fechatermino, 
					m.fechrecojo,m.idzona,m.poblacion,m.idmanzana,m.familia,m.idinspector, m.idfoco,m.idlarva,m.idpupa,m.idadulto, 
					m.idaedes_a,m.idotros,z.descripcion as tzona, m.idtipointervencion, i.descripcion AS tinterven,
					p.nrodocumento ||' - '|| p.apellidos ||' '|| p.nombres as inspe_text, tf.codigo as tipfoco, m.localidad,
					m.totalviviendas, m.viviprogramadas,m.viviinspeccion,m.latitud,m.longitud ,m.direccion
					from aedes_muestra as m
					inner join tipo_zona as z on(z.idzona=m.idzona)
					inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
					inner join inspector as p ON (p.idinspector = m.idinspector)
					inner join tipo_foco as tf ON (tf.idfoco = m.idfoco)
					where m.idaedes=".$idcodigo." order by  m.idzona asc";
					
        $resultado = $objconfig->execute_select($consulta,1 );

		foreach ( $resultado[1] as $fila )
		{ 
            $n++;
			 
            //Se agregan los datos de los alumnos
		//	$this->Row(array($count,$this->FechaDMY2($prue[""]),$prue[""]$prue[""],),0);
            $objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $n)
				//->setCellValueExplicit('B'.$i, strtoupper($fila['totalviviendas']),PHPExcel_Cell_DataType::TYPE_STRING )
				->setCellValue('B'.$i, strtoupper($fila['totalviviendas']))
				->setCellValue('C'.$i, strtoupper($fila['viviprogramadas']))
				->setCellValue('D'.$i, strtoupper($fila['viviinspeccion']))
				->setCellValue('E'.$i, strtoupper($fila['tzona']))
				->setCellValue('F'.$i, $objconfig->FechaDMY2($fila['fechrecojo']))
				->setCellValue('G'.$i, strtoupper($fila['idmanzana']))
				->setCellValue('H'.$i, strtoupper($fila['familia']))
				->setCellValue('I'.$i, strtoupper($fila['direccion']))
				->setCellValue('J'.$i, strtoupper($fila['latitud']))
				->setCellValue('K'.$i, strtoupper($fila['longitud']))
				->setCellValue('L'.$i, strtoupper($fila['inspe_text']))
				->setCellValue('M'.$i, strtoupper($fila['tipfoco']))
				->setCellValue('N'.$i, strtoupper($fila['idlarva']))
				->setCellValue('O'.$i, strtoupper($fila['idpupa']))
				->setCellValue('P'.$i, strtoupper($fila['idadulto']))
				->setCellValue('Q'.$i, strtoupper($fila['idaedes_a']))
				->setCellValue('R'.$i, strtoupper($fila['idotros']))

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
		$objPHPExcel->getActiveSheet()->getStyle('A3:R3')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('B4:R4')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A11:R11')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, 'A12:R'.($i-1));
      //  $objPHPExcel->getActiveSheet()->getStyle('M7:M'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		      
       
		for($i = 'A'; $i <= 'R'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)
				->getColumnDimension($i)->setAutoSize(TRUE);
			//	->getColumnDimension($i)->setAutoSize(false)->setWidth("15");
			}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Muestras');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane("A4");
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,12);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		/* header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment; filename=millonarios_fc.doc");
		header("Pragma: no-cache");
		header("Expires: 0"); */

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
		$fecha = date("d/m/Y h:i:s a ");
		$hora = date("h_i_s");
	 
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=MuestrasProcesadas_$hora.xlsx");
        header("Cache-Control: max-age=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save("php://output");
		exit;
		//return true;
	
		echo "<script> alert('No hay Registro que Mostrar') 
		location.href='index.php' 
		 window.close()
		</script>  ";


?>