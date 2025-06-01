<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    /* var_dump($_POST); */
    $queryT = "SELECT idcliente from cliente where estareg=1 order by idcliente desc limit 1;";
    $itemsT = $objconfig->execute_select($queryT,1);
    $nIdcliente=$itemsT[1][0]["idcliente"];
    $nIdcliente=intval($nIdcliente);
    $nIdcliente=$nIdcliente+1;
    if(!isset($_POST["razonsocial"])){
        
        $queryT = "insert into cliente (idcliente, razonsocial, direccion,ruc, iddocumento, estareg) values (".$nIdcliente.",'".$_POST["apellidoPaterno"]." ".$_POST["apellidoMaterno"]." ".$_POST["nombres"]."','".$_POST["direccion"]."','".$_POST["dni"]."',".$_POST["tipoDoc"].",1);";
    }else{
        $queryT = "insert into cliente (idcliente, razonsocial, direccion,ruc, iddocumento, estareg) values (".$nIdcliente.",'".$_POST["razonsocial"]."','".$_POST["direccion"]."','".$_POST["dni"]."',".$_POST["tipodoc"].",1);";
    }
    
    $objconfig->execute($queryT);

    $queryT = "SELECT idcliente, razonsocial,ruc from cliente where estareg=1 and ruc='".$_POST["dni"]."'";
    $itemsT = $objconfig->execute_select($queryT,1);
    echo json_encode($itemsT["1"][0]);