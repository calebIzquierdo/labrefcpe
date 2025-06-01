<?php

    include("../../objetos/class.conexion.php");
    $carpeta = "../../upload/referencia";

    $objconfig = new conexion();

    $sql = "SELECT idpago, fecharecepcion, procedencia, nombre_usuario, estareg, codbarra, nrodocumento, tip_comprob, fechaemision, idcliente, SUM(valor) AS total
            FROM vista_pagos
            WHERE idpago=
            GROUP BY idpago, fecharecepcion, procedencia, nombre_usuario, estareg, codbarra, nrodocumento, tip_comprob, fechaemision, idcliente";
    $cabecera = $objconfig->execute_select($sql);

    //     

?>