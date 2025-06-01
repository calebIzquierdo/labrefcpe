<?php
 $path = "http://".$_SERVER['HTTP_HOST']."/referencias/";
	include("../../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$idindicador 	= $_POST["idindicador"];
	$anio			= $_POST["anio"];
	$idestable		= $_POST["idestable"];
	$tipoRef		= $_POST["tref"];
	$limit			= $_POST["limit"];
	
	$n=0;
	$meses = array("1"=>"enero",
				 "2"=>"febrero",
				 "3"=>"marzo",
				 "4"=>"abril",
				 "5"=>"mayo",
				 "6"=>"junio",
				 "7"=>"julio",
				 "8"=>"agosto",
				 "9"=>"setiembre",
				 "10"=>"octubre",
				 "11"=>"noviembre",
				 "12"=>"diciembre");
	
?>

<script type="text/javascript"> 
		
	$(document).ready(function() {
    $('#dataTables-example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
			]
		} );
	} );

$(function() {
  $(".dataTables-example").each(function() {
    var nmtTable = $(this);
    var nmtHeadRow = nmtTable.find("thead tr");
    nmtTable.find("tbody tr").each(function() {
      var curRow = $(this);
      for (var i = 0; i < curRow.find("td").length; i++) {
        var rowSelector = "td:eq(" + i + ")";
        var headSelector = "th:eq(" + i + ")";
        curRow.find(rowSelector).attr('data-title', nmtHeadRow.find(headSelector).text());
      }
    });
  });
});

</script>

	<!-- Custom Fonts 	
    
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<script src = "https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"> </script>
	<script src = "https://code.jquery.com/jquery-3.3.1.js"> </script>
		
	-->
	
	<script src = "https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"> </script>
	<script src = "https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"> </script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
	<script src = "https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"> </script>
	<script src = "https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"> </script>
<div class="row">
<div class="col-md-12">
<table id="dataTables-example" class="table table-hover"   >
 <thead>
	<tr >
	<th >#</th>
		<th >Periodos</th>
		<?php
		if ($idindicador==1){
			echo "<th width='5%'>Referencias</th>";
		}
		if ($idindicador==2){
			echo "<th width='5%'>RED</th>";
			echo "<th width='5%'>EE.SS.</th>";
		}
		if ($idindicador==7){
			echo "<th width='5%'>U.P.S</th>";
		}
		if ($idindicador==8){
			echo "<th width='5%'>Cie10 - Diagnostico</th>";
		}
		if ($idindicador==9){
			echo "<th width='5%'>Seguro</th>";
		}
		if ($idindicador==10){
			echo "<th width='5%'>Cie10 - Diagnostico</th>";
		}
		?>
		<th >Ene.</th>
		<th >Feb.</th>
		<th >Mar.</th>
		<th >Abr.</th>
		<th >May.</th>
		<th >Jun.</th>
		<th >Jul.</th>
		<th >Ago.</th>
		<th >Set.</th>
		<th >Oct.</th>
		<th >Nov.</th>
		<th >Dic.</th>
		<th >Total.</th>
		
	</tr>
	  </thead>
        <tbody>
	<?php
		
		if($idindicador==1 )
		{
			$n=0;
			if ($idestable==0 && $tipoRef==0 )
			{
				
				$r["anio"]= $anio;
				
				$qT =  "select * from tablero
			   		   where idindicador=".$idindicador." and anio='".$anio."' and idpoblacion=0";
								   
				$rowEst = $objconfig->execute_select($qT,1);
				foreach($rowEst[1] as $r)
				{
					$n++;
					$sect = "select descripcion from condicion_referencia where idcondreferencia=".$r["idcondreferencia"];
						
						$nomb_sector = $objconfig->execute_select($sect);	
						$nombre = $nomb_sector[1]["descripcion"];
				
				?>
				<tr align="center">
				<th ><?=$n?></th>
				<th ><?=$r["anio"]?></th>
						<th ><?=$nomb_sector[1]["descripcion"]?></th>
						<th ><?=number_format($r["enero"],2)?></th>
						<th ><?=number_format($r["febrero"],2)?></th>
						<th ><?=number_format($r["marzo"],2)?></th>
						<th ><?=number_format($r["abril"],2)?></th>
						<th ><?=number_format($r["mayo"],2)?></th>
						<th ><?=number_format($r["junio"],2)?></th>
						<th ><?=number_format($r["julio"],2)?></th>
						<th ><?=number_format($r["agosto"],2)?></th>
						<th ><?=number_format($r["setiembre"],2)?></th>
						<th ><?=number_format($r["octubre"],2)?></th>
						<th ><?=number_format($r["noviembre"],2)?></th>
						<th ><?=number_format($r["diciembre"],2)?></th>
				<?php
				$tmes = $r["enero"]+$r["febrero"]+$r["marzo"]+$r["abril"]+$r["mayo"]+$r["junio"]+$r["julio"]+$r["agosto"]+$r["setiembre"]+$r["octubre"]+
					$r["noviembre"]+$r["diciembre"];
				
					$total = $tmes;
					
					echo "<th width='5%'>".number_format($total,2)."</th>";
					echo "</tr>";


				}
			}
			if ($idestable!=0 && $tipoRef==0 )
			{
				$n=0;
				$que =  "select * from tablero
			   		   where idindicador=".$idindicador." and anio='".$anio."' and idpoblacion=".$idestable;
					   
				$roT = $objconfig->execute_select($que,1);
				
					foreach($roT[1] as $rw)
					{
						$n++;
						if ($rw["idcondreferencia"]==0){$nombre = "???";} else {
						$sect = "select descripcion from condicion_referencia where idcondreferencia=".$rw["idcondreferencia"];
						$nomb_sector = $objconfig->execute_select($sect);	
						$nombre = $nomb_sector[1]["descripcion"];
						}
				
					?>
					<tr align="center">
						<th ><?=$n?></th>
						<th ><?=$rw["anio"]?></th>
						<th ><?=$nombre?></th>
						<th ><?=number_format($rw["enero"],2)?></th>
						<th ><?=number_format($rw["febrero"],2)?></th>
						<th ><?=number_format($rw["marzo"],2)?></th>
						<th ><?=number_format($rw["abril"],2)?></th>
						<th ><?=number_format($rw["mayo"],2)?></th>
						<th ><?=number_format($rw["junio"],2)?></th>
						<th ><?=number_format($rw["julio"],2)?></th>
						<th ><?=number_format($rw["agosto"],2)?></th>
						<th ><?=number_format($rw["setiembre"],2)?></th>
						<th ><?=number_format($rw["octubre"],2)?></th>
						<th ><?=number_format($rw["noviembre"],2)?></th>
						<th ><?=number_format($rw["diciembre"],2)?></th>
						<?php
						$tmes = $rw["enero"]+$rw["febrero"]+$rw["marzo"]+$rw["abril"]+$rw["mayo"]+$rw["junio"]+$rw["julio"]+$rw["agosto"]+$rw["setiembre"]+$rw["octubre"]+
							$rw["noviembre"]+$rw["diciembre"];
				
						$total = $tmes;
					
						echo "<th width='5%'>".number_format($total,2)."</th>";
						?>
						
					</tr>

					<?php
				}
			} 
		}
		
			
		if($idindicador==2 )
		{
 
			if ($idestable!=0)
			{
				$n++;
				$queryT =  "select * from tablero_origen
			   		   where idindicador=".$idindicador." and anio='".$anio."' and idtiporeferencia=".$tipoRef." 
					   and idorigen_establecimiento=".$idestable;
					   
				$rowT = $objconfig->execute_select($queryT,1);
				
					foreach($rowT[1] as $r)
					{
						$sect = ("select descripcion,idred from establecimiento where idestablecimiento=".$idestable);
						$nomb_sector = $objconfig->execute_select($sect);	
						
						$red = ("select descripcion from red where idred=".$nomb_sector[1]["idred"]);
						$nomb_red = $objconfig->execute_select($red);	
				
					?>
					<tr align="center">
						<th ><?=$n?></th>
						<th ><?=$r["anio"]?></th>
						<th ><?=$nomb_red[1]["descripcion"]?></th>
						<th ><?=$nomb_sector[1]["descripcion"]?></th>
						<th ><?=number_format($r["enero"],2)?></th>
						<th ><?=number_format($r["febrero"],2)?></th>
						<th ><?=number_format($r["marzo"],2)?></th>
						<th ><?=number_format($r["abril"],2)?></th>
						<th ><?=number_format($r["mayo"],2)?></th>
						<th ><?=number_format($r["junio"],2)?></th>
						<th ><?=number_format($r["julio"],2)?></th>
						<th ><?=number_format($r["agosto"],2)?></th>
						<th ><?=number_format($r["setiembre"],2)?></th>
						<th ><?=number_format($r["octubre"],2)?></th>
						<th ><?=number_format($r["noviembre"],2)?></th>
						<th ><?=number_format($r["diciembre"],2)?></th>
						<th ><?=number_format($r["sumanio"],2)?></th>
					</tr>

					<?php
					}
			} 
			else 
				{
				
				if ($limit !=0)
				{
					$limite = " limit ".$limit;
				} else {$limite="";}
		
				$r["anio"]= $anio;
				
				$qT =  "select * from tablero_origen
			   		   where idindicador=".$idindicador." and anio='".$anio."' and idtiporeferencia=".$tipoRef." 
					   order by sumanio desc ".$limite;
					   
				$rowEst = $objconfig->execute_select($qT,1);
				foreach($rowEst[1] as $r)
				{
					$n++;
					$sect = ("select idestablecimiento,idred, descripcion from establecimiento where 
						idestablecimiento=".$r["idorigen_establecimiento"]);
						$nomb_sector = $objconfig->execute_select($sect);	
						$nombre = $nomb_sector[1]["descripcion"];
						
						$red = ("select descripcion from red where idred=".$nomb_sector[1]["idred"]);
						$nomb_red = $objconfig->execute_select($red);	
				
					?>
					
				<tr align="center">
				<th ><?=$n?></th>
				<th ><?=$r["anio"]?></th>
				<th ><?=$nomb_red[1]["descripcion"]?></th>
						<th ><?=$nomb_sector[1]["descripcion"]?></th>
						<th ><?=number_format($r["enero"],2)?></th>
						<th ><?=number_format($r["febrero"],2)?></th>
						<th ><?=number_format($r["marzo"],2)?></th>
						<th ><?=number_format($r["abril"],2)?></th>
						<th ><?=number_format($r["mayo"],2)?></th>
						<th ><?=number_format($r["junio"],2)?></th>
						<th ><?=number_format($r["julio"],2)?></th>
						<th ><?=number_format($r["agosto"],2)?></th>
						<th ><?=number_format($r["setiembre"],2)?></th>
						<th ><?=number_format($r["octubre"],2)?></th>
						<th ><?=number_format($r["noviembre"],2)?></th>
						<th ><?=number_format($r["diciembre"],2)?></th>
						<th ><?=number_format($r["sumanio"],2)?></th>
						</tr>
				<?php
	
				}
				}
		}
		
		if($idindicador==7 )
		{
				$n=0;
				$queryT =  "select * from tablero_ups
			   		   where idindicador=".$idindicador." and anio='".$anio."' and idtiporeferencia=".$tipoRef." 
					   and idestado=".$idestable." ORDER BY sumanio desc"  ;
					   
				$rowT = $objconfig->execute_select($queryT,1);
				
					foreach($rowT[1] as $r)
					{
						$n++;
						$sect = "select descripcion from ups where idups=".$r["idespecialidad"];
						$nomb_sector = $objconfig->execute_select($sect);	
				
					?>
					<tr align="center">
						<th ><?=$n?></th>
						<th ><?=$r["anio"]?></th>
						<th ><?=$nomb_sector[1]["descripcion"]?></th>
						<th ><?=number_format($r["enero"],2)?></th>
						<th ><?=number_format($r["febrero"],2)?></th>
						<th ><?=number_format($r["marzo"],2)?></th>
						<th ><?=number_format($r["abril"],2)?></th>
						<th ><?=number_format($r["mayo"],2)?></th>
						<th ><?=number_format($r["junio"],2)?></th>
						<th ><?=number_format($r["julio"],2)?></th>
						<th ><?=number_format($r["agosto"],2)?></th>
						<th ><?=number_format($r["setiembre"],2)?></th>
						<th ><?=number_format($r["octubre"],2)?></th>
						<th ><?=number_format($r["noviembre"],2)?></th>
						<th ><?=number_format($r["diciembre"],2)?></th>
						<th ><?=number_format($r["sumanio"],2)?></th>
					</tr>

					<?php
					}
		}
		
		if($idindicador==8 )
		{
				$n=0;
				$queryT =  "select * from tablero_diagnostico
			   		   where idindicador=".$idindicador." and anio='".$anio."' and idestado=1  
				   and idtiporeferencia=2 and idespecialidad=".$idestable." order by sumanio desc "; 
					   
				$rowT = $objconfig->execute_select($queryT,1);
				
					foreach($rowT[1] as $r)
					{
						$n++;
						$sect = "select iddiagnostico, codigo, descripcion from diagnostico where iddiagnostico=".$r["iddiagnostico"];
						$nomb_sector = $objconfig->execute_select($sect);	
						$diag = $nomb_sector[1]["codigo"]." - ".$nomb_sector[1]["descripcion"]
						
					?>
					<tr align="center">
						<th ><?=$n?></th>
						<th ><?=$r["anio"]?></th>
						<th ><?=$diag ?></th>
						<th ><?=number_format($r["enero"],2)?></th>
						<th ><?=number_format($r["febrero"],2)?></th>
						<th ><?=number_format($r["marzo"],2)?></th>
						<th ><?=number_format($r["abril"],2)?></th>
						<th ><?=number_format($r["mayo"],2)?></th>
						<th ><?=number_format($r["junio"],2)?></th>
						<th ><?=number_format($r["julio"],2)?></th>
						<th ><?=number_format($r["agosto"],2)?></th>
						<th ><?=number_format($r["setiembre"],2)?></th>
						<th ><?=number_format($r["octubre"],2)?></th>
						<th ><?=number_format($r["noviembre"],2)?></th>
						<th ><?=number_format($r["diciembre"],2)?></th>
						<th ><?=number_format($r["sumanio"],2)?></th>
					</tr>

					<?php
					}
		}
		if($idindicador==9 )
		{
				$n=0;
				$queryT = "select * from tablero_seguro 
			   	   where idindicador=".$idindicador." and anio='".$anio."' and idestado=1  
				   and idtiporeferencia=".$idestable." and  idpoblacion=".$tipoRef." order by sumanio desc ";
					   
				$rowT = $objconfig->execute_select($queryT,1);
				
					foreach($rowT[1] as $r)
					{
						$n++;
						$sect = "select idseguro, descripcion from tipo_seguro where idseguro=".$r["idseguro"];
						$nomb_sector = $objconfig->execute_select($sect);
						
						$tipob = "select idpoblacion, descripcion from tipo_poblacion where 
						idpoblacion=".$tipoRef." ";
						$nomb_Pobla = $objconfig->execute_select($tipob);
						
						$nombre = $nomb_Pobla[1]["descripcion"]." - ".$nomb_sector[1]["descripcion"];
						
					?>
					<tr align="center">
						<th ><?=$n?></th>
						<th ><?=$r["anio"]?></th>
						<th ><?=$nombre?></th>
						<th ><?=number_format($r["enero"],2)?></th>
						<th ><?=number_format($r["febrero"],2)?></th>
						<th ><?=number_format($r["marzo"],2)?></th>
						<th ><?=number_format($r["abril"],2)?></th>
						<th ><?=number_format($r["mayo"],2)?></th>
						<th ><?=number_format($r["junio"],2)?></th>
						<th ><?=number_format($r["julio"],2)?></th>
						<th ><?=number_format($r["agosto"],2)?></th>
						<th ><?=number_format($r["setiembre"],2)?></th>
						<th ><?=number_format($r["octubre"],2)?></th>
						<th ><?=number_format($r["noviembre"],2)?></th>
						<th ><?=number_format($r["diciembre"],2)?></th>
						<th ><?=number_format($r["sumanio"],2)?></th>
					</tr>

					<?php
					}
		}
		if($idindicador==10 )
		{
			if ($idestable==0){
				
				$and = " ";
				} else {
					$and = " and idespecialidad=".$idestable."  ";
				}
					
				$n=0;
				$queryT =  "select * from tablero_diagnostico_envio
			   		   where idindicador=".$idindicador." and anio='".$anio."' and idestado=2  ".$and."
				   and idtiporeferencia=".$tipoRef."  order by sumanio desc "; 
					   
				$rowT = $objconfig->execute_select($queryT,1);
				
					foreach($rowT[1] as $r)
					{
						$n++;
						$sect = "select iddiagnostico, codigo, descripcion from diagnostico where iddiagnostico=".$r["iddiagnostico"];
						$nomb_sector = $objconfig->execute_select($sect);	
						$diag = $nomb_sector[1]["codigo"]." - ".$nomb_sector[1]["descripcion"]
						
					?>
					<tr align="center">
						<th ><?=$n?></th>
						<th ><?=$r["anio"]?></th>
						<th ><?=$diag ?></th>
						<th ><?=number_format($r["enero"],2)?></th>
						<th ><?=number_format($r["febrero"],2)?></th>
						<th ><?=number_format($r["marzo"],2)?></th>
						<th ><?=number_format($r["abril"],2)?></th>
						<th ><?=number_format($r["mayo"],2)?></th>
						<th ><?=number_format($r["junio"],2)?></th>
						<th ><?=number_format($r["julio"],2)?></th>
						<th ><?=number_format($r["agosto"],2)?></th>
						<th ><?=number_format($r["setiembre"],2)?></th>
						<th ><?=number_format($r["octubre"],2)?></th>
						<th ><?=number_format($r["noviembre"],2)?></th>
						<th ><?=number_format($r["diciembre"],2)?></th>
						<th ><?=number_format($r["sumanio"],2)?></th>
					</tr>

					<?php
					}
		}
		else if($idindicador!=1 && $idindicador!=7 )
		{

			$queryT = "select * from tablero
			   		   where idindicador=".$idindicador." and anio='".$anio."' and idpoblacion=0 "; 
			$rowT = $objconfig->execute_select($queryT,1);
		
			foreach($rowT[1] as $r)
			{
				$n++;
				if ($idindicador!=2){
					
				?>
				<tr align="center">
				<th ><?=$n?></th>
				<th ><?=$r["anio"]?></th>
				<?php
				if ($idindicador==1){
					echo "<th width='5%'>".$nomb_cond[1]["descripcion"]."</th>";
				}
				?>
				<th ><?=number_format($r["enero"],2)?></th>
				<th ><?=number_format($r["febrero"],2)?></th>
				<th ><?=number_format($r["marzo"],2)?></th>
				<th ><?=number_format($r["abril"],2)?></th>
				<th ><?=number_format($r["mayo"],2)?></th>
				<th ><?=number_format($r["junio"],2)?></th>
				<th ><?=number_format($r["julio"],2)?></th>
				<th ><?=number_format($r["agosto"],2)?></th>
				<th ><?=number_format($r["setiembre"],2)?></th>
				<th ><?=number_format($r["octubre"],2)?></th>
				<th ><?=number_format($r["noviembre"],2)?></th>
				<th ><?=number_format($r["diciembre"],2)?></th>
					<?php
				//	if ($idindicador==1 || $idindicador==3 || $idindicador==4 || $idindicador==5 ){
					$tmes = $r["enero"]+$r["febrero"]+$r["marzo"]+$r["abril"]+$r["mayo"]+$r["junio"]+$r["julio"]+$r["agosto"]+$r["setiembre"]+$r["octubre"]+
						$r["noviembre"]+$r["diciembre"];
					
						$total = $tmes;
						
						echo "<th width='5%'>".number_format($total,2)."</th>";
				//	}
					?>
				</tr>
				
				<?php
				}
			}
		}
	?>
	</thead>
<tbody>
</table>
</div >
</div >