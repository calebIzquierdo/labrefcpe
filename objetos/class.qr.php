<?php
		
		require ("qrcode/qrlib.php");
		
			  //set it to writable location, a place for temp generated PNG files
			$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;
			echo $PNG_TEMP_DIR;
    
			//html PNG location prefix
			$PNG_WEB_DIR = 'img/';
			
					//ofcourse we need rights to create temp dir
			if (!file_exists($PNG_TEMP_DIR))
				mkdir($PNG_TEMP_DIR);
    
			$filename = $PNG_TEMP_DIR.'codigoqr.png';
   
   			$errorCorrectionLevel = 'L';
			if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
			$errorCorrectionLevel = $_REQUEST['level'];    

			$matrixPointSize = 4;
			if (isset($_REQUEST['size']))
				$matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

			if (isset($_REQUEST['data'])) { 
			//it's very important!
			if (trim($texto_qr) == '')

			die('data cannot be empty! <a href="?">back</a>');

			$filename = $PNG_TEMP_DIR.'codigoqr'.md5($texto_qr.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			QRcode::png($texto_qr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
			} else {    
			QRcode::png($texto_qr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
			}   
				
				
?>