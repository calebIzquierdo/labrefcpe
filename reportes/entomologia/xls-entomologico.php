<?php

//    header("Content-Type: text/html;charset=utf-8");

    

    require_once "../../../resources/xls/Classes/PHPExcel.php";

    

    require_once "../../../resources/xls/Classes/PHPExcel/IOFactory.php";

    

    include "../../conexion.php";

    

//    $obj = new conexion();

    

    $codred 			= isset($_REQUEST["codred"])?$_REQUEST["codred"]:0;

    $codmicrored		= isset($_REQUEST["codmicrored"])?$_REQUEST["codmicrored"]:0;

    $codestablecimiento         = isset($_REQUEST["codestablecimiento"])?$_REQUEST["codestablecimiento"]:0;

    $fechainicial		= $_REQUEST["fechainicial"];

    $fechafinal			= $_REQUEST["fechafinal"];



    $objPHPExcel = new PHPExcel();

    

    $objPHPExcel->setActiveSheetIndex(0);

    

    $objPHPExcel->getActiveSheet()->getCell('A1')->setValue("Departamento");

    $objPHPExcel->getActiveSheet()->getCell('B1')->setValue("Provincia");

    $objPHPExcel->getActiveSheet()->getCell('C1')->setValue("Distrito");

    $objPHPExcel->getActiveSheet()->getCell('D1')->setValue("Establecimiento");

    $objPHPExcel->getActiveSheet()->getCell('E1')->setValue("Latitud");

    $objPHPExcel->getActiveSheet()->getCell('F1')->setValue("Longitud");

    $objPHPExcel->getActiveSheet()->getCell('G1')->setValue("Localidad");

    $objPHPExcel->getActiveSheet()->getCell('H1')->setValue("Fecha Trabajo");

    $objPHPExcel->getActiveSheet()->getCell('I1')->setValue("Fecha Recepcion");

    $objPHPExcel->getActiveSheet()->getCell('J1')->setValue("Vivienda Inspeccionado");

    $objPHPExcel->getActiveSheet()->getCell('K1')->setValue("Muestra Recibida");

    $objPHPExcel->getActiveSheet()->getCell('L1')->setValue("Vivienda Positiva");

    $objPHPExcel->getActiveSheet()->getCell('M1')->setValue("Recipiente Inspeccionado");

    $objPHPExcel->getActiveSheet()->getCell('N1')->setValue("Recipiente Positivo");

    $objPHPExcel->getActiveSheet()->getCell('O1')->setValue("Indice Vivienda");

    $objPHPExcel->getActiveSheet()->getCell('P1')->setValue("Indice Breteau");

    $objPHPExcel->getActiveSheet()->getCell('Q1')->setValue("Indice de Recipiente");

    $objPHPExcel->getActiveSheet()->getCell('R1')->setValue("Grado de Insfect.");

    $objPHPExcel->getActiveSheet()->getCell('S1')->setValue("Tipo de Interv.");

	

    $and="";

    if($codred!=0){$and .= " and f.codred=".$codred;}

    if($codmicrored!=0){$and .= " and f.codmicrored=".$codmicrored;}

    if($codestablecimiento!=0){$and .= " and f.codestablecimiento=".$codestablecimiento;}

			

    $count = 0;	 

    $fila  = 2;

    

    $queryG = "select coddep,

                    codprov,

                    coddist,

                    local

     from ficha_entomologica as f

     where tipo=2 and estado=1 and fechainitrabajo between '".$fechainicial."' and '".$fechafinal."' ".$and."

     group by coddep,codprov,coddist,local";
	 echo $queryG;

$resultado  = $mysqli->query($queryG);

                        $resultado->data_seek(0);

                        while($rowsG = $resultado->fetch_assoc()){

            $tvinspec1          = 0;

            $tmrecibida1        = 0;

            $tvpositiva1        = 0;

            $trinspeccionado1   = 0;

            $trpositiva1        = 0;

                     

            $mysqli->query("delete from tmp_ficha_entomologica");

                                

                                cargar_ficha_entomologica($fechainicial,$fechafinal,$rowsG["coddep"],$rowsG["codprov"],$rowsG["coddist"],$rowsG["local"],$and);

                                

                                $queryW = "select * from tmp_ficha_entomologica";

//                                echo $queryW;

                                $resultadow  = $mysqli->query($queryW);

                                $resultadow->data_seek(0);

                                while($rows = $resultadow->fetch_assoc()){

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



                $fitrabajo 	= explode("-",$rows["fechainitrabajo"]);

                $frecepcion     = explode("-",$rows["fecharecepcion"]);

                $ffin 		= explode("-",$rows["fechafintrabajo"]);

                

                $count++;

                

                $objPHPExcel->getActiveSheet()->getCell('A'.$fila)->setValue($rows["departamento"]);

		$objPHPExcel->getActiveSheet()->getCell('B'.$fila)->setValue($rows["provincia"]);

		$objPHPExcel->getActiveSheet()->getCell('C'.$fila)->setValue(substr(strtoupper($rows["local"]),0,13));

                $objPHPExcel->getActiveSheet()->getCell('D'.$fila)->setValue($rows["establecimiento"]);

                $objPHPExcel->getActiveSheet()->getCell('E'.$fila)->setValue($rows["latitud"]);

                $objPHPExcel->getActiveSheet()->getCell('F'.$fila)->setValue($rows["longitud"]);

		$objPHPExcel->getActiveSheet()->getCell('G'.$fila)->setValue($rows["zona"]);

		$objPHPExcel->getActiveSheet()->getCell('H'.$fila)->setValue($fitrabajo[2]."-".($ffin[2]."/".$ffin[1]."/".$ffin[0]));

		$objPHPExcel->getActiveSheet()->getCell('I'.$fila)->setValue($frecepcion[2]."/".$frecepcion[1]."/".$frecepcion[0]);

		$objPHPExcel->getActiveSheet()->getCell('J'.$fila)->setValue($rows["vinspec"]);

                $objPHPExcel->getActiveSheet()->getCell('K'.$fila)->setValue($rows["mrecibida"]);

		$objPHPExcel->getActiveSheet()->getCell('L'.$fila)->setValue($rows["vpositiva"]);

		$objPHPExcel->getActiveSheet()->getCell('M'.$fila)->setValue($rows["rinspeccionado"]);

		$objPHPExcel->getActiveSheet()->getCell('N'.$fila)->setValue($rows["rpositiva"]);

		$objPHPExcel->getActiveSheet()->getCell('O'.$fila)->setValue(number_format($indVivienda,2));

		$objPHPExcel->getActiveSheet()->getCell('P'.$fila)->setValue(number_format($indBreteau,2));

		$objPHPExcel->getActiveSheet()->getCell('Q'.$fila)->setValue(number_format($indRecipiente,2));

		$objPHPExcel->getActiveSheet()->getCell('R'.$fila)->setValue($grado);

		$objPHPExcel->getActiveSheet()->getCell('S'.$fila)->setValue(strtoupper($rows["tintervencion"]));

	

		$fila++;

                

                

            }

	}



    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

    $objWriter->save(str_replace('.php', '.xls', __FILE__));

?>