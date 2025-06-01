<?php
 if(!session_start()){session_start();}
        
 include("../../objetos/class.conexion.php");	
    
 $objconfig = new conexion();
 $sql="select idpersonal from seriedoc_personal where idpersonal='".$_POST["0form_idusuario"]."' and idseriedoc='".$_POST["0form_idserie"]."'";
//echo $sql;
 $can=$objconfig->CantidadFilas($sql);
 if($_POST["op"]==1){
    //REGISTRO
    if($can>0){

        echo '{"status":false,"msg":"Este usuario ya tiene asignada la serie"}';
        return;
    }else{
        echo '{"status":true,"msg":"registrar"}';
    }
 }else{
    //UPDATE
    if($can>0){
        //echo $_POST["0form_idserie"]."!==".$_POST["ult_idserie"]." && ".$_POST["0form_idusuario"]."!=".$_POST["ult_idusuario"];
        if($_POST["0form_idserie"]!==$_POST["ult_idserie"] || $_POST["0form_idusuario"]!=$_POST["ult_idusuario"]){
            echo '{"status":false,"msg":"Este usuario ya tiene asignada la serie"}';
            return;
        }else{

            echo '{"status":true,"msg":"registrar"}';
        }
        
    }else{
        echo '{"status":true,"msg":"registrar"}';
    }
    
 }
?>