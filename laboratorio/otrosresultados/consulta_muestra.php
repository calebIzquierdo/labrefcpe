<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $cod =  $_POST["cod_barras"];

    if($_POST["type"] == '0'){

        $queryT = " SELECT m.idingresomuestra, m.codbarra, m.fecharecepcion, m.fechareg, m.idestablecimiento, 
			e.descripcion, m.idcliente, c.razonsocial, c.ruc, m.nombre_usuario, 
			m.idusuario from muestra as m
		inner join establecimiento as e on m.idestablecimiento = e.idestablecimiento 
		inner join cliente as c on m.idcliente = c.idcliente 
		where m.estareg=1 and m.codbarra LIKE '%".$cod."%' ORDER BY m.codbarra";
        $itemsT = $objconfig->execute_select($queryT);

        $data = array();

        $queryDet = "SELECT md.idmuestradetalle, md.idingresomuestra, md.idarea, md.idareatrabajo, md.idtipo_examen, te.descripcion, md.idusuario, md.nombre_usuario, md.fechahora, md.estareg, md.codbarra, md.cantidad
                        FROM muestra_det as md
                        INNER JOIN tipo_examen as te ON md.idtipo_examen = te.idtipo_examen
                        WHERE md.idingresomuestra = ".$itemsT[1]['idingresomuestra'];
        $detalle = $objconfig->execute_select($queryDet, 1);

        $data["op"] = "0";
        $data["opcion"] = "0";
        $data["idingresomuestra"] = $itemsT[1]["idingresomuestra"];
        $data["codbarra"] = $itemsT[1]["codbarra"];
        $data["idestablecimiento"] = $itemsT[1]["idestablecimiento"];
        $data["descripcion"] = $itemsT[1]["descripcion"];
        $data["fecharecepcion"] = $itemsT[1]["fecharecepcion"];
        $data["fechareg"] = $itemsT[1]["fechareg"];
        $data["idcliente"] = $itemsT[1]["idcliente"];
        $data["razonsocial"] = $itemsT[1]["razonsocial"];
        $data["ruc"] = $itemsT[1]["ruc"];
        $data["sexo"] = "";
        $data["edad"] = "";
        $data["enfermedad"] = "";
        $data["idpersonal"] = "";
        $data["medico"] = "";
        $data["observaciones"] = "";
        $data["nombre_usuario"] = $itemsT[1]["nombre_usuario"];
        $data["idusuario"] = $itemsT[1]["idusuario"];

        $detalleMuestra = array();
        foreach($detalle[1] as $detail){
            $det[] = array();

            $det["idmuestradetalle"] = $detail["idmuestradetalle"];
            $det["idtipo_examen"] = $detail["idtipo_examen"];
            $det["examen"] = $detail["descripcion"];
            $det["estareg"] = $detail["estareg"];

            $detalleMuestra[] = $det;
        }
        $data["examenes"] = $detalleMuestra;

        echo json_encode($data);

    } else {
        $queryT = "SELECT idotrosresultados, idingresomuestra, codbarra, fecharecepcion, fechareg, idestablecimiento, establecimiento, idcliente, razonsocial, ruc, edad, sexo, enfermedad, idpersonal, medico, observaciones, nombre_usuario, idusuario 
                        FROM view_otrosresultados
                        WHERE estadoreg = 1 AND codbarra LIKE '%".$cod."%' 
                        ORDER BY codbarra asc";
        $itemsT = $objconfig->execute_select($queryT);

        $data = array();

        $queryDet = "SELECT md.idmuestradetalle, md.idtipo_examen, te.descripcion, md.estareg
                        FROM muestra_det as md
                        INNER JOIN tipo_examen as te ON md.idtipo_examen = te.idtipo_examen
                        WHERE md.idingresomuestra = ".$itemsT[1]["idingresomuestra"];
        $detalle = $objconfig->execute_select($queryDet, 1);

        $data["op"] = "1";
        $data["opcion"] = "1";
        $data["idingresomuestra"] = $itemsT[1]["idotrosresultados"];
        $data["codbarra"] = $itemsT[1]["codbarra"];
        $data["idestablecimiento"] = $itemsT[1]["idestablecimiento"];
        $data["descripcion"] = $itemsT[1]["establecimiento"];
        $data["fecharecepcion"] = $itemsT[1]["fecharecepcion"];
        $data["fechareg"] = $itemsT[1]["fechareg"];
        $data["idcliente"] = $itemsT[1]["idcliente"];
        $data["razonsocial"] = $itemsT[1]["razonsocial"];
        $data["ruc"] = $itemsT[1]["ruc"];
        $data["sexo"] = $itemsT[1]["sexo"];
        $data["edad"] = $itemsT[1]["edad"];
        $data["enfermedad"] = $itemsT[1]["enfermedad"];
        $data["idpersonal"] = $itemsT[1]["idpersonal"];
        $data["medico"] = $itemsT[1]["medico"];
        $data["observaciones"] = $itemsT[1]["observaciones"];
        $data["nombre_usuario"] = $itemsT[1]["nombre_usuario"];
        $data["idusuario"] = $itemsT[1]["idusuario"];

        $detalleMuestra = array();
        foreach($detalle[1] as $detail){
            $det[] = array();

            $det["idmuestradetalle"] = $detail["idmuestradetalle"];
            $det["idtipo_examen"] = $detail["idtipo_examen"];
            $det["examen"] = $detail["descripcion"];
            $det["estareg"] = $detail["estareg"];

            $detalleMuestra[] = $det;
        }
        $data["examenes"] = $detalleMuestra;

        echo json_encode($data);
    }

?>
