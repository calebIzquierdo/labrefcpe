<?php	
	include_once("../../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$idindicador 	= $_POST["idindicador"];
	$anio			= $_POST["anio"];
	$idestable		= $_POST["idestable"];
	$tipoRef		= $_POST["tref"];
	$limit			= $_POST["limit"];
	$tp_graf		= $_POST["grafico"];
	
	if ($limit !=0)
		{
			$limite = " limit ".$limit;
		} else {$limite="";}
	
	if($idindicador == 1 )
	{
		
		if ($tipoRef!=0 && $idestable!=0 ){
									
		$queryT = "select * from tablero 
				   where idindicador='".$idindicador."' and anio='".$anio."' and idcondreferencia= ".$tipoRef." and idpoblacion=".$idestable;		

		$query1 = "select count (idcondreferencia) as trow from tablero 
				   where idindicador='".$idindicador ."' and anio='".$anio."' and idcondreferencia= ".$tipoRef." and idpoblacion=".$idestable;
				   
		$tsect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
				 from tablero where idindicador='".$idindicador."' and anio='".$anio."' and idcondreferencia= ".$tipoRef." 
				 and idpoblacion=".$idestable;
	   
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		} 
		
		if ($tipoRef==0 && $idestable!=0 ){
		
		$queryT = "select * from tablero 
				   where idindicador='".$idindicador."' and anio='".$anio."' and idpoblacion=".$idestable;

		$query1 = "select count (idcondreferencia) as trow from tablero 
				   where idindicador='".$idindicador ."' and anio='".$anio."' and idpoblacion=".$idestable;
				   
		$tsect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
				 from tablero where idindicador='".$idindicador."' and anio='".$anio."' and idpoblacion=".$idestable;	
	   
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		}
		if ($tipoRef!=0 && $idestable==0 ){
		
			$queryT = "select * from tablero 
				   where idindicador='".$idindicador."' and anio='".$anio."' and idcondreferencia=".$tipoRef." and idpoblacion=0";

		$query1 = "select count (idcondreferencia) as trow from tablero 
				   where idindicador='".$idindicador ."' and anio='".$anio."' and idcondreferencia=".$tipoRef." and idpoblacion=0";
				   
		$tsect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
				 from tablero where idindicador='".$idindicador."' and anio='".$anio."' and idcondreferencia=".$tipoRef." and idpoblacion=0";	
	   
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		}
		
		if ($tipoRef==0 && $idestable==0 ){
		$queryT = "select * from tablero 
				   where idindicador='".$idindicador."' and anio='".$anio."' and idpoblacion=0";

		$query1 = "select count (idcondreferencia) as trow from tablero 
				   where idindicador='".$idindicador ."' and anio='".$anio."' and idpoblacion=0";
				   
		$tsect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
				 from tablero where idindicador='".$idindicador."' and anio='".$anio."'  and idpoblacion=0";	
	   
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		}
		
	}
	if($idindicador==2 )
	{
				
		if ($idestable!=0){
		$queryT = "select * from tablero_origen 
			   	   where idindicador='".$idindicador."' and anio='".$anio."' and idorigen_establecimiento='".$idestable."' 
				   and idtiporeferencia=".$tipoRef;
		
		$query1 = ("select count (idindicador) as trow from tablero 
				   where idindicador='".$idindicador."' and idorigen_establecimiento='".$idestable."' and anio='".$anio."'");
		
		$sec = ("select descripcion from hospitales where idhospital=".$idestable."");
		
		}
		
		else {
			$ttsect=0;
			if ($limit !=0)
				{
					$limite = " limit ".$limit;
				} else {$limite="";}
				
			$queryT = "select * from tablero_origen where idindicador=".$idindicador."  and anio='".$anio."' 
					and idtiporeferencia=".$tipoRef."  order by sumanio desc ".$limite;
					
			$SumT = "select sumanio from tablero_origen where idindicador=".$idindicador."  and anio='".$anio."' 
					and idtiporeferencia=".$tipoRef." order by sumanio desc ".$limite;
			$rSm = $objconfig->execute_select($SumT,1);	

			foreach($rSm[1] as $rowSma)
			{
				$ttsect += $rowSma["sumanio"];
			}					

		$total = " Total del Año ".$anio." => ".$ttsect;
		
		$query1 = ("select count (idindicador) as trow from tablero_origen where idindicador='".$idindicador."' 
					and anio='".$anio."' and idtiporeferencia=".$tipoRef);

		$query2 = $objconfig->execute_select($query1); 
	
		
		}
	}
	if( $idindicador==3 || $idindicador==5)
	{
		$queryT = "select * from tablero 
				   where idindicador='".$idindicador."' and anio='".$anio."' ";		

		$query1 = ("select count (idindicador) as trow from tablero 
				   where idindicador='".$idindicador ."' and anio='".$anio."'");
				   
		$tsect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
				 from tablero where idindicador='".$idindicador."' and anio='".$anio."'";
	   
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		
	}
	
	
	if($idindicador==4 )
	{
		if ($idestable!=0){
		$queryT = "select * from tablero_destino 
			   	   where idindicador='".$idindicador."' and anio='".$anio."' and codemp='".$idestable."' and idtiporeferencia=".$tipoRef;
		
		$query1 = ("select count (idindicador) as trow from tablero_destino 
				   where idindicador='".$idindicador."' and codemp='".$idestable."' and anio='".$anio."'");
		
		$sec = ("select descripcion from hospitales where idhospital=".$idestable."");
		
		}
		else {
		$queryT = "select * from tablero_destino where idindicador=".$idindicador."  and anio='".$anio."' 
					and idtiporeferencia=".$tipoRef." order by codemp ";
				
		$tsect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
		from tablero_destino where idindicador=".$idindicador." and anio='".$anio."' and idtiporeferencia=".$tipoRef;
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		
		$query1 = ("select count (idindicador) as trow from tablero_destino where idindicador='".$idindicador."' 
					and anio='".$anio."' and idtiporeferencia=".$tipoRef);
		$query2 = $objconfig->execute_select($query1); 
	
		}	
		
		$desc = "select descripcion from tipo_referencia where idtiporeferencia=".$tipoRef;
		$tipRef =  $objconfig->execute_select($desc);
		
		if ($tipoRef!=0 && $idestable==0){
		$tsect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
		from tablero_destino where idindicador=".$idindicador." and anio='".$anio."'  and idtiporeferencia=".$tipoRef;
		
		$ttsect = $objconfig->execute_select($tsect);
		}
		$des_ref = " - ".$tipRef[1]["descripcion"];
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"]."".$des_ref ;
	}
	
	if($idindicador==6 )
	{
		if ($idestable!=0){
		$queryT = "select * from tablero_rechazado 
			   	   where idindicador='".$idindicador."' and anio='".$anio."' and idnoacepta='".$idestable."' order by sumanio desc";
		
		$query1 = ("select count (idindicador) as trow from tablero 
				   where idindicador='".$idindicador."' and idnoacepta='".$idestable."' and anio='".$anio."'");
		
		$sec = ("select descripcion from tipo_suspendido where idsuspendido=".$idestable);
		
		} 
		else {
		$queryT = "select * from tablero_rechazado where idindicador=".$idindicador."  and anio='".$anio."' order by sumanio desc ";
		
		$tsect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
		from tablero_rechazado where idindicador=".$idindicador." and anio='".$anio."' ";
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		
		$query1 = ("select count (idindicador) as trow from tablero_rechazado where idindicador='".$idindicador."' 
					and anio='".$anio."' ");
		$query2 = $objconfig->execute_select($query1); 
		
		}
	}
	if($idindicador==7 )
	{
		
		$queryT = "select * from tablero_ups 
			   	   where idindicador=".$idindicador." and anio='".$anio."' and idestado=".$idestable." 
				   and idtiporeferencia=".$tipoRef. " order by sumanio desc ";
		
		$query1 = "select count (idindicador) as trow from tablero_ups 
				   where idindicador='".$idindicador."' and anio='".$anio."' and idestado=".$idestable."  
				   and idtiporeferencia=".$tipoRef;
		
		$tsect = "select sum(sumanio)::int as total 
					from tablero_ups 
				where idindicador=".$idindicador." and anio='".$anio."' and idestado=".$idestable." and idtiporeferencia=".$tipoRef;
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		
	}
	if($idindicador==8 )
	{
		
		$queryT = "select * from tablero_diagnostico 
			   	   where idindicador=".$idindicador." and anio='".$anio."' and idestado=1  
				   and idtiporeferencia=2 and idespecialidad=".$idestable." order by sumanio desc ";
		
		$query1 = "select count (idindicador) as trow from tablero_diagnostico 
				   where idindicador='".$idindicador."' and anio='".$anio."' and idestado=1  
				   and idtiporeferencia=2 and idespecialidad=".$idestable." ";
		
		$tsect = "select sum(sumanio)::int as total 
					from tablero_diagnostico 
				where idindicador=".$idindicador." and anio='".$anio."' and idestado=1  
				   and idtiporeferencia=2 and idespecialidad=".$idestable."";
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		
	}
	if($idindicador==9 )
	{
		
		$queryT = "select * from tablero_seguro 
			   	   where idindicador=".$idindicador." and anio='".$anio."' and idestado=1  
				   and idtiporeferencia=".$idestable." and  idpoblacion=".$tipoRef." order by sumanio desc ";
		
		$query1 = "select count (idindicador) as trow from tablero_seguro 
				   where idindicador='".$idindicador."' and anio='".$anio."' and idestado=1  and idpoblacion=".$tipoRef."
				   and idtiporeferencia=".$idestable." ";
		
		$tsect = "select sum(sumanio)::int as total 
					from tablero_seguro 
				where idindicador=".$idindicador." and anio='".$anio."' and idestado=1  and idpoblacion=".$tipoRef."
				   and idtiporeferencia=".$idestable."";
		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		
	}
	if($idindicador==10 )
	{
		if ($idestable==0){
			$and = " ";
		} else {
			$and = " and idespecialidad=".$idestable."  ";
		}
		$queryT = "select * from tablero_diagnostico_envio 
			   	   where idindicador=".$idindicador." and anio='".$anio."' and idestado=2  ".$and."
				     and idtiporeferencia=".$tipoRef." order by sumanio desc ";
		
		$query1 = "select count (idindicador) as trow from tablero_diagnostico_envio 
				   where idindicador='".$idindicador."' and anio='".$anio."' and idestado=2  ".$and."
				   and idtiporeferencia=".$tipoRef." ";
		
		$tsect = "select sum(sumanio)::int as total 
					from tablero_diagnostico_envio 
				where idindicador=".$idindicador." and anio='".$anio."' and idestado=2   ".$and."
				     and idtiporeferencia=".$tipoRef."";

		$ttsect = $objconfig->execute_select($tsect);
		$total = " Total del Año ".$anio." => ".$ttsect[1]["total"];
		
	}
	
	$query2 = $objconfig->execute_select($query1);
	
	$r2ulo = "select * from indicadores where idindicador=".$idindicador;
	$rTit = $objconfig->execute_select($r2ulo);
	
	$rdatos = "select * from institucion where codemp=11";
	$rDatos = $objconfig->execute_select($rdatos);
	
	$sector = $objconfig->execute_select($sec);
	
	$Titulo = $rTit[1]["descripcion"].$total;
	
	if ($idindicador==7){
		if ($idestable==2){
			$Titulo = "ORIGEN DE UPS CORDINADAS - TOTAL AÑO ".$anio." = ".$ttsect[1]["total"];
		}else {
			$Titulo = "DESTINO DE UPS CORDINADAS - TOTAL AÑO ".$anio." = ".$ttsect[1]["total"];
		}
	}

	?>

	
<script type="text/javascript">
	var tp_graf = '<?php echo $_POST["grafico"]; ?>';

	$(function () {
    Highcharts.chart('div-tablero-grafico', {
		  chart: {
        type: tp_graf,
		
    },
        title: {
            text: '<?php echo $Titulo; ?>',
            x: -20 //center
        },
        subtitle: {
            text: 'Fuente: <?php echo $rDatos[1]["razonsocial"]; ?>',
            x: -20
        },
        xAxis: {
            categories: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        },		 
		yAxis: {
            title: {
                text: 'Cantidad'
            },
        plotLines: [{
                value: 0,
				width: 1,
                color: '#808080'
			}]
        },
		plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                // enableMouseTracking: false
                enableMouseTracking: true
            }
        },
        /* tooltip: {
            valueSuffix: ' - <?php echo $sector[1]["descripcion"]; ?>'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        }, */ 
	
        series: 
	[{
		<?php 
		
		$r2Tit = $objconfig->execute_select($queryT,1);	
		
			foreach($r2Tit[1] as $r2)
			{
				$n++;
				$tsuma=0;
				$tsuma2=0;
				
				if ($idindicador==1 )
				{
					if ($tipoRef!=0 && $idestable==0 ){
						
						$sect = "select idcondreferencia, descripcion from condicion_referencia where 
						idcondreferencia=".$tipoRef." order by descripcion asc ";
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero where idindicador='".$idindicador."' and idcondreferencia=".$r2["idcondreferencia"]." 
						and idpoblacion=".$r2["idcondreferencia"]  ;
						$stot = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
							$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma2 ;
					}
				
					if ($tipoRef==0 && $idestable!=0 )
					{
								
						$tipob = "select idpoblacion, descripcion from tipo_poblacion where 
						idpoblacion=".$idestable." order by descripcion asc ";
						$nomb_Pobla = $objconfig->execute_select($tipob);
						
						$sect = "select idcondreferencia, descripcion from condicion_referencia where 
						idcondreferencia=".$r2["idcondreferencia"]." order by descripcion asc ";
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero where idindicador='".$idindicador."' and idcondreferencia=".$r2["idcondreferencia"]."  
						and idpoblacion=".$idestable  ;
						
						$stot = $objconfig->execute_select($total_sect,1);	
						
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
							//$nombre = $nomb_Pobla[1]["descripcion"]." = ".$tsuma2 ;
							$nombre = $nomb_Pobla[1]["descripcion"]." - ".$nomb_sector[1]["descripcion"]." = ".$tsuma2 ;
						
						
					}
					if ($tipoRef!=0 && $idestable!=0 ){
						
						$sect = "select idcondreferencia, descripcion from condicion_referencia where 
						idcondreferencia=".$tipoRef." order by descripcion asc ";
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$tipob = "select idpoblacion, descripcion from tipo_poblacion where 
						idpoblacion=".$idestable." order by descripcion asc ";
						$nomb_Pobla = $objconfig->execute_select($tipob);
						
						
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero where idindicador='".$idindicador."' and idcondreferencia=".$tipoRef." 
						and idpoblacion=".$idestable  ;
						$stot = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
							$nombre = $nomb_Pobla[1]["descripcion"]." - ".$nomb_sector[1]["descripcion"]." = ".$tsuma2 ;
					}
					
					if ($tipoRef==0 && $idestable==0 ){
						$sect = "select idcondreferencia, descripcion from condicion_referencia where 
						idcondreferencia=".$r2["idcondreferencia"]." ";
											
						$nomb_sector = $objconfig->execute_select($sect);	
						$nombre = $nomb_sector[1]["descripcion"];
						
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero where idindicador=".$idindicador." and idcondreferencia=".$r2["idcondreferencia"]." and idpoblacion=0";	
						$stot = $objconfig->execute_select($total_sect,1);	
					
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
							
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma;
						
					
					} 
				}
				
				if ($idindicador==2 )
				{
					if ($idestable!=0)
					{
						$sect = ("select descripcion from establecimiento where idestablecimiento=".$idestable);
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero_origen where idindicador='".$idindicador."' and idtiporeferencia=0 and
						idorigen_establecimiento=".$r2["idorigen_establecimiento"];
						$stot = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
							$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma2 ;
					}
					
					else 
					{	
					
						$sect = "select idestablecimiento, descripcion from establecimiento where 
						idestablecimiento=".$r2["idorigen_establecimiento"];
						$nomb_sector = $objconfig->execute_select($sect);	
						
					//	$nombre = $nomb_sector[1]["descripcion"];
						$total_sect = "select sumanio::int as total 
						from tablero_origen where idindicador='".$idindicador."' and anio='".$anio."' and
						idorigen_establecimiento=".$r2["idorigen_establecimiento"]." and idtiporeferencia=".$tipoRef." 
						order by sumanio desc ".$limite;
						$stot = $objconfig->execute_select($total_sect,1);	
					
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma;
			  
					}  
				}
				if ($idindicador==4){
					if ($idestable==0)
					{
						$sect = ("select idhospital, descripcion from hospitales where idhospital=".$r2["codemp"]);
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero_destino where idindicador='".$idindicador."' and codemp=".$r2["codemp"]." and idtiporeferencia=".$tipoRef;
						$stot = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
					
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma ;
						//$nombre = $nomb_sector[1]["descripcion"]." = ".$stot[1]["total"] ;
					}
					else 
					{
						$sect = ("select idhospital, descripcion from hospitales where idhospital=".$idestable);
						$nomb_sector = $objconfig->execute_select($sect);	
						$nombre = $nomb_sector[1]["descripcion"];
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero_destino where idindicador='".$idindicador."' and codemp=".$idestable." and idtiporeferencia=".$tipoRef;
						$stot = $objconfig->execute_select($total_sect,1);	
					
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
							
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma ;
						//$nombre = $nomb_sector[1]["descripcion"]." = ".$stot[1]["total"] ;
					
					}  
				}
				
				if ($idindicador==6){
					
					if ($idestable==0)
					{
						$sect = "select descripcion from tipo_suspendido where idsuspendido=".$r2["idnoacepta"];
						
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero_rechazado where idindicador=".$idindicador." and idnoacepta=".$r2["idnoacepta"];
						$stot = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
					
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma ;
						// $nombre = $nomb_sector[1]["descripcion"]." = ".$stot[1]["total"] ;
					}
					else 
					{
						$sect = "select descripcion from tipo_suspendido where idsuspendido=".$idestable;
						$nomb_sector = $objconfig->execute_select($sect);	
						$nombre = $nomb_sector[1]["descripcion"];
						$total_sect = "select sum(enero+febrero+marzo+abril+mayo+junio+julio+agosto+setiembre+octubre+noviembre+diciembre)::int as total 
						from tablero_rechazado where idindicador='".$idindicador."' and idnoacepta=".$idestable;
						$stot = $objconfig->execute_select($total_sect,1);	
					
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
							
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma ;
					}  
				}
				if ($idindicador==7){
					
						$sect = "select idups, descripcion from ups where idups=".$r2["idespecialidad"];
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$total_sect = "select sumanio::int as total 
						from tablero_ups 
						where idindicador=".$idindicador." and anio='".$anio."' and idestado=".$idestable." 
						and idtiporeferencia=".$tipoRef." and idespecialidad=".$r2["idespecialidad"];
						$stot = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
					
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma ;
					
				}
				
				if ($idindicador==8){
						$sect = "select iddiagnostico, codigo, descripcion from diagnostico where iddiagnostico=".$r2["iddiagnostico"];
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$total_sect = "select sumanio::int as total 
						from tablero_diagnostico 
						where idindicador=".$idindicador." and anio='".$anio."' and idestado=1  
						and idtiporeferencia=2 and iddiagnostico=".$r2["iddiagnostico"]."  and idespecialidad=".$r2["idespecialidad"]."";
						$stot = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
					
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma ;
					
				}
				
				if ($idindicador==9){
					
					$tipob = "select idpoblacion, descripcion from tipo_poblacion where 
						idpoblacion=".$tipoRef." ";
						$nomb_Pobla = $objconfig->execute_select($tipob);
						
						$sect = "select idseguro, descripcion from tipo_seguro where idseguro=".$r2["idseguro"];
						$nomb_sector = $objconfig->execute_select($sect);	
				
						$total_sect = "select sumanio::int as total from tablero_seguro 
						where idindicador=".$idindicador." and anio='".$anio."' and idestado=1 and idpoblacion=".$tipoRef."
						and idtiporeferencia=".$idestable." and idseguro= ".$nomb_sector[1]["idseguro"];
						$stot1 = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot1[1] as $suma1)
							{
								$tsuma = $suma1["total"] ;
								$tsuma1 += $suma1["total"] ;
							}
							
						$nombre = $nomb_Pobla[1]["descripcion"]." CON SEGURO ". $nomb_sector[1]["descripcion"]." = ".$tsuma ;
					
				}
				
				if ($idindicador==10){
					
					if ($idestable==0){
						$and = " ";
					} else {
						$and = " and idespecialidad=".$idestable."  ";
					}
						$sect = "select iddiagnostico, codigo, descripcion from diagnostico where iddiagnostico=".$r2["iddiagnostico"];
						$nomb_sector = $objconfig->execute_select($sect);	
						
						
						$total_sect = "select sumanio::int as total 
						from tablero_diagnostico_envio 
						where idindicador=".$idindicador." and anio='".$anio."' and idestado=2  ".$and ."
						 and iddiagnostico=".$r2["iddiagnostico"]."  and idtiporeferencia=".$r2["idtiporeferencia"]." order by sumanio asc ";
						$stot = $objconfig->execute_select($total_sect,1);	
				
							foreach($stot[1] as $rsuma)
							{
								$tsuma = $rsuma["total"] ;
								$tsuma2 += $rsuma["total"] ;
							}
					
						$nombre = $nomb_sector[1]["descripcion"]." = ".$tsuma ;
					
				}
				
				
				
						
		?>		
					name: '<?php echo $nombre; ?>',
					data: [ <?php echo $r2["enero"]; ?>, <?php echo $r2["febrero"]; ?>,
					<?php echo $r2["marzo"]; ?>, <?php echo $r2["abril"]; ?>, <?php echo $r2["mayo"]; ?>,
					<?php echo $r2["junio"]; ?>, <?php echo $r2["julio"]; ?>, <?php echo $r2["agosto"]; ?>, 
					<?php echo $r2["setiembre"]; ?>, <?php echo $r2["octubre"]; ?>, <?php echo $r2["noviembre"]; ?>,
					<?php echo $r2["diciembre"] ;?> 
					]  
					<?php 
					$fila = $query2[1]["trow"];
					
					if ($idindicador==2){
						if ($limit !=0)
						{ $fila = $_POST["limit"]; }
					}else {$fila = $query2[1]["trow"];}
					
					 if ($n < $fila )
					{ echo " } , { ";  }
						else { echo ""; }  
				} 
	
			 ?>
			}] 
 
    });
	
});
</script>

