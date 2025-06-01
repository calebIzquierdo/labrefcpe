<?php
    $mensual = array("01"=>"ENERO","02"=>"FEBRERO","03"=>"MARZO","04"=>"ABRIL","05"=>"MAYO","06"=>"JUNIO","07"=>"JULIO","08"=>"AGOSTO",
                     "09"=>"SETIEMBRE","10"=>"OCTUBRE","11"=>"NOVIEMBRE","12"=>"DICIEMBRE");
	
	$mens_num   = array("1"=>"ENERO","2"=>"FEBRERO","3"=>"MARZO","4"=>"ABRIL","5"=>"MAYO","6"=>"JUNIO","7"=>"JULIO","8"=>"AGOSTO",
                        "9"=>"SETIEMBRE","10"=>"OCTUBRE","11"=>"NOVIEMBRE","12"=>"DICIEMBRE");
	
	function NomMes($mens_num)
	{
		$mens_num   = array("1"=>"Enero","2"=>"Febrero","3"=>"Marzo","4"=>"Abril","5"=>"Mayo","6"=>"Junio","7"=>"Julio","8"=>"Agosto",
                        "9"=>"Setiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
		return $mens_num[1];
    }
	
	function soloNumeros($texto)
    {
	$resultado = ereg_replace("[^0-9]", "", $texto); 
	return $resultado;
    } 
	function DecFecha($Fec)
    {
	 $cad = preg_split("/ /",$Fec);
     $sub_cad = preg_split("/-/",$cad[0]);
     $Fecha = $sub_cad[2]."/".$sub_cad[1]."/".$sub_cad[0]." ".$cad[1];
    return $Fecha;
    }
	function FechaNombre($Fec2)
    {
		$cad = preg_split("/ /",$Fec2);
		$sub_cad = preg_split("/-/",$cad[0]);
		$Fecha_nombre = $sub_cad[2]." de ".NomMes($sub_cad[1])." del ".$sub_cad[0]." ".$cad[1];
		return $Fecha_nombre;
    }	
   	function sinredondeo($numero,$decimales)
	{
		$factor = pow(10, $decimales); 
		// return (round($numero*$factor)/$factor); 
		return (Floor($numero*$factor)/$factor); 
	}
	function FechaDMY($fec)
	{
	$fecha_format =  date("d-m-Y",strtotime($fec) );
	return $fecha_format ;
	}

    function UltimoDiaMes($anio,$mes){

    if (((fmod($anio,4)==0) and (fmod($anio,100)!=0)) or (fmod($anio,400)==0)) {
        $dias_febrero = 29;
    } else {
        $dias_febrero = 28;
    }
    $dias=31;
    switch($mes) {
        case 1: $dias = 31; break;
        case 2: $dias = $dias_febrero; break;
        case 3: $dias = 31; break;
        case 4: $dias = 30; break;
        case 5: $dias = 31; break;
        case 6: $dias = 30; break;
        case 7: $dias = 31; break;
        case 8: $dias = 31; break;
        case 9: $dias = 30; break;
        case 10: $dias = 31; break;
        case 11: $dias = 30; break;
        case 12: $dias = 31; break;
    }
    return $dias;
    }


?>