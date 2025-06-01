<?php

    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $muestra =  $_POST["muestra"];

    $queryT = "SELECT idotrosresultadosdet, idotrosresultados, fecharegistro, idtipo_examen, descripcion, valores, resultado, estadoreg
                        FROM view_otrosresultadosdet
                        WHERE idotrosresultados = ".$muestra." AND estadoreg = 1 ORDER BY idtipo_examen ASC";
    $itemsT = $objconfig->execute_select($queryT, 1);

    if($itemsT[2] != '0'){
        echo json_encode($itemsT[2]);

        $count = 0;
        foreach($itemsT[1] as $item) {
            $count++;
            $id = $item["idotrosresultadosdet"];
            $idotrosresultados = $item["idotrosresultados"];
            $idtipo = $item["idtipo_examen"];
            $examen = $item["descripcion"];
            $fecha = $item["fecharegistro"];
            $valor = $item["valores"];
            $result = $item["resultado"]
?>
            <tr class="remove_view_resultado">
                <td><?php echo $count ?></td>
                <td><?php echo $item["descripcion"] ?></td>
                <td><?php echo $item["fecharegistro"] ?></td>
                <td><?php echo $item["resultado"] ?></td>
                <td alin="enter">
                    <img src='../img/edit.png' style='cursor:pointer' onclick='editar_resultado(<?php echo $id ?>, "<?php echo $fecha ?>", <?php echo $idtipo ?>, "<?php echo $valor ?>", "<?php echo $result ?>", <?php echo $idotrosresultados ?>)' title='Editar Registro' />
                    &nbsp;&nbsp;
                    <img src='../img/cancel.png' style='cursor:pointer' onclick='eliminar_resultado(<?php echo $id ?>, "<?php echo $examen ?>", <?php echo $idotrosresultados ?>)' title='Borrar Registro' />
                </td>
            </tr>
<?php 
        } 
    } else {
        echo json_encode($itemsT[2]);
?>
        <tr class="remove_view_resultado">
            <td colspan="4">No hay resultados</td>
        </tr>
<?php
    }
?>

