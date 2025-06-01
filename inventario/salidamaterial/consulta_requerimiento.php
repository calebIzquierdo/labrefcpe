<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $cod =  $_POST["requerimiento"]; //000030

    $data = array();

    $val = "SELECT idrequerimiento, estareg FROM requerimiento WHERE correlativo = '".$cod."'"; // "AND estareg = ANY('{4, 5}'::int[])";
    $valid = $objconfig->execute_select($val);

    if($valid[1]["estareg"] != 4 || $valid[1]["estareg"] == null){
        $data["exist"] = $valid[1]["estareg"];
        echo json_encode($data);
        exit();
    }
	
	$idmarca = $objconfig->execute_select("SELECT idmarca,idmaterial FROM requerimiento_validar WHERE idrequerimiento=".$valid[1]["idrequerimiento"]." ",1) ;
   /* $sql = "SELECT rd.idrequerimiento, rd.cant_aprobada, rd.idmaterial, 
                   vm.mate, vm.idunidad, vm.umedida, vm.idtipomaterial, vm.tipmaterial, 
                   rd.idmodelo, md.des.model, vs.idmarca, vs.marc
            FROM requerimiento_detalle AS rd
            JOIN vista_materiales AS vm ON rd.idmaterial = vm.idmaterial
            LEFT JOIN vista_stock AS vs ON rd.idmaterial = vs.idmaterial
            WHERE idrequerimiento = ".$valid[1]["idrequerimiento"];
    $detalle = $objconfig->execute_select($sql, 1);
	
	*/
    ///1,7  1,4
	$datos = array();
	
  foreach($idmarca[1] as $idm){
	$sql = "SELECT rd.idrequerimiento, rd.cant_aprobada, rd.idmaterial, 
				vm.mate, vm.idunidad, vm.umedida, vm.idtipomaterial, vm.tipmaterial, 
				rd.idmarca, rd.fvencimiento, rd.idmodelo 
				FROM requerimiento_validar AS rd
				JOIN vista_materiales AS vm ON rd.idmaterial = vm.idmaterial
				WHERE rd.idrequerimiento =".$valid[1]["idrequerimiento"]." and rd.idmaterial=".$idm["idmaterial"]."";
  //  echo $sql;    
    $detalle = $objconfig->execute_select($sql, 1);

    
    $count = 1;
    $data["exist"] = $valid[1]["estareg"];
    $data["idrequerimiento"] = $valid[1]["idrequerimiento"];
    foreach($detalle[1] as $detail){

        $fvence = "";
       /* if($detail["idmodelo"] != null){
            $fvence = $objconfig->execute_select("SELECT fvencimiento FROM ingreso_det WHERE idmaterial=".$detail["idmaterial"]." AND idmodelo=".$detail["idmodelo"]." GROUP BY fvencimiento") ;
        }
		*/

        $dat["count_enf"] = $count;
        $dat["idrequerimiento"] = $detail["idrequerimiento"];
        $dat["cant_aprobada"] = $detail["cant_aprobada"];
        $dat["idmaterial"] = $detail["idmaterial"];
        $dat["material"] = $detail["mate"];
        $dat["idunidad"] = $detail["idunidad"];
        $dat["u_medida"] = $detail["umedida"];
        $dat["idtipomaterial"] = $detail["idtipomaterial"];
        $dat["tip_material"] = $detail["tipmaterial"];
        $dat["idmodelo"] = $detail["idmodelo"];
        $dat["modelo"] = $detail["model"];
        $dat["idmarca"] = $detail["idmarca"];
        $dat["marca"] = $detail["marc"];
        //$dat["fvence"] = $fvence[1]["fvencimiento"];
        $dat["fvence"] = $detail["fvencimiento"];
        $dat["series"] = "";
        $dat["patri"] = "";
        $dat["patlab"] = "";
        
        $datos[] = $dat;
        $count++;
    }
  }
    $data["detalle"] = $datos;  ///[detalle] [1] , [detalle] [2]

    echo json_encode($data);

?>