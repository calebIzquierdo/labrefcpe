<?php
$datos["status"]=false;
$datos["msm"]="Documento invalido";
$datos["dni"]=00000000;
$datos["nombres"]="";
$datos["apellidoPaterno"]="";
$datos["apellidoMaterno"]="";
$datosr["direccion"]="";
$datos["codVerifica"]=0;
if($_GET["tipo"]==1){
    if(strlen($_GET["id"])<8){
        
        echo json_encode($datos);
        return;
    }
//solo consulta por dni
   
        $url = "http://181.176.170.149:8021/ConsultaDNIRUC/".$_GET["id"];
        $json = file_get_contents($url);
        $res=json_decode($json,true);
        $datosr = [];
        $datosr["status"]=true;
        //var_dump($res);

        if($res["_resultado"]=="1000"||$res["_resultado"]=="0001"){
            $datosr["status"]=false;
            $datosr["resultado"]=(int)($res["_resultado"]);
            $datosr["msm"]=$res["_des_resultado"];
        }
        $datosr["apellidoPaterno"]=$res["_primerApellido"];
        $datosr["apellidoMaterno"]=$res["_segundoApellido"];
        $datosr["nombres"]=$res["_nombres"];
        $datosr["direccion"]=$res["_direccion"];
        $datosr["dni"]=$_GET["id"];
        $datosr["foto"]=$res["_foto"];
        $datosr["razonsocial"]= $datosr["nombres"].' '.$datosr["apellidoPaterno"].' '.$datosr["apellidoMaterno"];
        echo json_encode($datosr);
}
if($_GET["tipo"]==4){
   /*  $datos["msm"]="Falta implementar busqueda con ruc";
    echo json_encode($datos);
        return; */
        $url = "https://api.bomberosperu.gob.pe:8243/census/1.0/api/v1/GetTaxPayerByBusinessId/".$_GET["id"];
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Authorization: Bearer 70b27673-4e18-39f2-864d-739d173b2e1a"
            ]
        ];
        $context = stream_context_create($opts);
        $json = file_get_contents($url, false, $context);
        $res=json_decode($json);//20600306970
        $datosr["status"]=true;
        $datosr["msm"]=$res->message;
        $datosr["dni"]=$res->taxpayer->business_id;
        $datosr["nombres"]=$res->taxpayer->business_name;
        $datosr["razonsocial"]=$res->taxpayer->business_name;
        $datosr["resultado"]=1000;

        $datosr["apellidoPaterno"]="";
        $datosr["apellidoMaterno"]="";
        $datosr["direccion"]=$res->taxpayer->full_address;
        $datosr["codVerifica"]=0;
        echo json_encode($datosr);
}


/* echo $datos['nombres']; */

?>