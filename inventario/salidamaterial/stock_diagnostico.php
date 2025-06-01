<?php
    include("../../objetos/class.conexion.php");
    $objconfig  = new conexion();
    //var_dump($_POST);
    //exit;
    $idmaterial=$_POST["idmaterial"];
    $idmarca=$_POST["idmarca"];
    $sql="SELECT cantidad
	FROM stock_material where idmaterial='".$idmaterial."' AND idmarca='".$idmarca."';";
//	echo $sql;
    $itemsT = $objconfig->execute_select($sql,1);
    echo json_encode($itemsT);
    //var_dump($itemsT["1"][0]["cantidad"]);
    echo $itemsT["1"][0]["cantidad"];