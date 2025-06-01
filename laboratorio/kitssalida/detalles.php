<?php
$path = "http://".$_SERVER['HTTP_HOST']."/labrefcpe/";
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	
	$idkit = $_GET["idk"];
	$idun = $_GET["idun"];
	$idmt = $_GET["idmt"];
	$idmc = $_GET["idmc"];
	$idreg = $_GET["idrg"];
	$fila = $_GET["fil"];
	
	
	$objconfig = new conexion();
	
	$query = "SELECT * FROM vista_kitsalida_det  where idmaterial=".$idmt." and idmarca=".$idmc." and idkit=".$idkit;
	//echo $query;
	$row = $objconfig->execute_select($query);
	
	$CantMerc = $objconfig->execute_select("SELECT cantprueba FROM materiales where idmaterial=".$idmt);
	$totDet = $CantMerc[1]["cantprueba"]*$row[1]["cantidad"];
	$material = $row[1]["umedida"]." - ".$row[1]["materia"]." \n";
	$total = $objconfig->execute_select("SELECT sum(cantidad) as totales FROM kitsalida_fecha where idkitfecha='".$idreg."' ");
	
	
?>

   
<!DOCTYPE html>
<html>

	
	<head>
<!-- Bootstrap Core CSS -->
    <link href="<?=$path?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=$path?>bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=$path?>bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="<?=$path?>bootstrap/vendor/jquery/jquery.min.js"></script>
	
	
	</head>
	<body>
	<form id="frmguardar" name="frmguardar" action="guardar-ficha.php" method="post">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-heading">
			<div class="modal-header">
				<h3 class="modal-title text-primary" align="center"> <?php echo $material; ?> </h3>
				<h4 class="modal-title text-primary" align="center"> Total Determinaciones: <?php echo $totDet; ?> </h4>
				<h4 id="usado1" name="usado1" class="modal-title text-primary" align="center"> Total Utilizados: <?php echo $total[1]["totales"]; ?> </h4>
				<h4 name="saldo1" id="saldo1" class="modal-title text-primary" align="center"> Saldo: <?php echo $totDet-$total[1]["totales"]; ?> </h4>
			</div>
				<input type="hidden" name="idkit" id="idkit"  value="<?php echo $idkit; ?>"/>
				<input type="hidden" name="idunidad" id="idunidad"  value="<?php echo $idun; ?>"/>
			   <input type="hidden" name="idmaterial" id="idmaterial"  value="<?php echo $idmt; ?>"/>
			   <input type="hidden" name="idmarca" id="idmarca"  value="<?php echo $idmc; ?>"/>
			   <input type="hidden" name="idkitfecha" id="idkitfecha"  value="<?php echo $idreg; ?>"/>
			   <input type="hidden" name="nombproducto" id="nombproducto"  value="<?php echo $material; ?>"/>
			   <input type="hidden" name="fila" id="fila"  value="<?php echo $fila; ?>"/>
			   <input type="hidden" name="montokits" id="montokits"  value="<?php echo $totDet; ?>"/>
			   <input type="hidden" name="usado" id="usado"  value=""/>
			   <input type="hidden" name="saldo" id="saldo"  value=""/>
			   
			   
			</br>
		<div class="modal-content modal-lg">
		<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				
			<div class="col-md-1">
				<label>Fecha </label>
			</div>
			<div class="col-md-3">
				<input class="form-control" type="date" name="fecha" id="fecha" value="<?php echo date("d/m/Y");?>"  />
			</div>
			<div class="col-md-1">
				<label for="atencion" class="control-label">Uso:  </label>
			</div>
			<div class="col-md-3">
			<select id="uso" name="uso" class="form-control" >
              <option value="0">--Seleccionar --</option>
              <?php
                  $queryT = "select * from tipo_uso where estareg=1 order by descripcion asc ";
                  $itemsT = $objconfig->execute_select($queryT,1);
					foreach($itemsT[1] as $rowT)
					{
						echo "<option value='".$rowT["iduso"]."' >".strtoupper($rowT["descripcion"])."</option>";
					}
				  
							  
              ?>
           </select>
		   </div>
		   <div class="col-md-1">
				<label for="atencion" class="control-label">Resul.:  </label>
			</div>
			<div class="col-md-3">
			<select id="resul" name="resul" class="form-control" >
              <option value="0">--Seleccionar --</option>
              <?php
                  $queryT = "select * from tipo_resultado 
							where idresultado in (1,2,3,28,29,69,71,72,73,74) and estareg=1 
							order by descripcion asc ";
                  $itemsT = $objconfig->execute_select($queryT,1);
					foreach($itemsT[1] as $rowT)
					{
						echo "<option value='".$rowT["idresultado"]."' >".strtoupper($rowT["descripcion"])."</option>";
					}
				  
							  
              ?>
           </select>
		   </div>
		   
		</div>
	</div>
	</br>
	<div class="row">
			<div class="col-md-12">
				
			
		   
		   <div class="col-md-1">
				<label for="atencion" class="control-label">Cantidad:  </label>
			</div>
			<div class="col-md-2">
				<input class="form-control" type="text" name="cant" id="cant" value="" />
			</div>
			<div class="col-md-1">
				<input type="button" onclick="agregar_uso();" name="action" id="action" class="btn btn-info"  value="Agregar" />
			</div>
		</div>
	</div>
	</br>
	<div style="height:480px;  overflow-x:hidden;" >
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info ">
				<div class="panel-heading">Registro de consumo de Determinantes utilizados </div>
					<div class="panel-body">
						<table class="table table-striped table-bordered table-hover table-responsive" id="tbusodeterminante" name="tbusodeterminante" >
							<thead>
								<tr>
									<td >#</td>
									<td >Fecha  </td>
									<td >Tipo Uso  </td>
									<td >Resultado</td>
									<td >Cantidad</td>
									<td >Quitar</td>
									
								</tr>
							</thead>
							<tbody>
								<?php
									$count_enf=0;
									$sqlF = "SELECT f.idkit,f.idkitfecha,f.idunidad,f.idmaterial,f.idmarca,
										  f.fechauso,f.iduso,f.cantidad,tu.descripcion as tipuso, 
										  f.idresultado, tr.descripcion as tipreslt
										  FROM kitsalida_fecha f
										  JOIN tipo_uso tu ON tu.iduso = f.iduso 
										  JOIN tipo_resultado tr ON tr.idresultado = f.idresultado
										  
											where idkitfecha=".$idreg." ";
									$rowF = $objconfig->execute_select($sqlF,1);
									foreach($rowF[1] as $rF)
									{
										$count_enf++;

								?>
									<tr id='itemusodeterminante<?php echo $count_enf; ?>' name='itemusodeterminante<?php echo $count_enf; ?>' >
										<td >
											<p style="display:none" id="idkit<?php echo $count_enf; ?>"><?php echo $rF["idkit"]; ?></p>
											<p style="display:none" id="idkitfecha<?php echo $count_enf; ?>"><?php echo strtoupper($rF["idkitfecha"] ); ?></p>
											<p style="display:none" id="idunidad<?php echo $count_enf; ?>"><?php echo $rF["idunidad"]; ?></p>
											<p style="display:none" id="idmaterial<?php echo $count_enf; ?>"><?php echo strtoupper($rF["idmaterial"] ); ?></p>
											<p style="display:none" id="idmarca<?php echo $count_enf; ?>"><?php echo $rF["idmarca"]; ?></p>
											<?php echo $count_enf ; ?>
										</td>
										<td>
											<input type='hidden' name='fechauso<?php echo $count_enf; ?>' id='fechauso<?php echo $count_enf; ?>' value='<?php echo $rF["fechauso"]; ?>' />
											<?php echo $rF["fechauso"]; ?>
										</td>
										
										
										<td>
											<input type='hidden' name='iduso<?php echo $count_enf; ?>' id='iduso<?php echo $count_enf; ?>' value='<?php echo $rF["iduso"]; ?>' />
											<?php echo strtoupper($rF["tipuso"] ); ?>
										</td>
										<td>
											<input type='hidden' name='idresultado<?php echo $count_enf; ?>' id='idresultado<?php echo $count_enf; ?>' value='<?php echo $rF["idresultado"]; ?>' />
											<?php echo strtoupper($rF["tipreslt"] ); ?>
										</td>
										<td>
											<input type='hidden' name='cantidad<?php echo $count_enf; ?>' id='cantidad<?php echo $count_enf; ?>' value='<?php echo $rF["cantidad"]; ?>' />
											<?php echo strtoupper($rF["cantidad"] ); ?>
										</td>
								
										<td >
										<!--
											<img src='../../img/cancel.png' style='cursor:pointer' onclick='remover_ficha(<?php echo $count_enf; ?>)' title='Quitar Registro' />
										-->
										</td>
										
									</tr>
								<?php }?>
							</tbody>
						</table>
						<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_enf; ?>" />
						<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_enf; ?>" />
						<script> 
							var  count=<?php echo $count_enf; ?> 
							
						</script>
					</div>
				</div>
			</div>
		</div>
					</div>
	
		<div class="modal-footer">
					<!--		<input type="hidden" name="user_id" id="user_id" />
							<input type="hidden" name="operation" id="operation" /> -->
					<input type="submit" name="aceptar" id="aceptar" value="Guardar" class="btn btn-success"  />
					<button type="button" onclick="javascript:window.close();" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>
				</div>
	</div>
		  
	</form>	
            </div>
            </div>
        </div>
   
	</body>
</html>
<script type="text/javascript" language="javascript" >
	/*
	function enviar(id,index)
	{
		window.opener.recibir(id,$("#nombres"+index).val(),$("#ruc"+index).val())
		window.close()
	}
*/
Calcular()

count = <?php echo $count_enf; ?>;
	
	function agregar_uso()
    {
		var fechauso	= $("#fecha").val();
        var iduso		= $("#uso").val();
        var uso_text	= $("#uso option:selected").html();
        var reslt	    = $("#resul").val();
		var reslt_text	= $("#resul option:selected").html();
        var cantidad    = $("#cant").val();
		
		
        if (fechauso == 0){
            alert("Campo fecha no debe ser vacio o nulo!!!")
			$("#fecha").focus();
            return
        }
		
		if (iduso == 0){
            alert("Seleccione el tipo de uso que se dio al determinante!!!")
			$("#uso").focus();
            return
        }
		if (reslt == 0){
            alert("Seleccione el tipo de resultado de la Determinante!!!")
			$("#resul").focus();
            return
        }
		if(cantidad=="" || cantidad==0)
        {
			$("#cant").focus();
            alert(" Cantidad no debe ser nulo o Cero !!!")
            return false
        }

	    count++;
		
		
		$("#tbusodeterminante").append("<tr id='itemusodeterminante"+count+"' class='texto' >"+
							"<td align='center'><input type='hidden' name='idkit"+count+"' id='idkit"+count+"' value='"+fechauso+"' />"+count+"</td>"+
							"<td align='center'><input type='hidden' name='fechauso"+count+"' id='fechauso"+count+"' value='"+fechauso+"' />"+fechauso+"</td>"+
							"<td align='center'><input type='hidden' name='iduso"+count+"' id='iduso"+count+"' value='"+iduso+"' />"+uso_text+"</td>"+
							"<td align='center'><input type='hidden' name='idresultado"+count+"' id='idresultado"+count+"' value='"+reslt+"' />"+reslt_text+"</td>"+
							"<td align='center'><input type='hidden' name='cantidad"+count+"' id='cantidad"+count+"' value='"+cantidad+"' />"+cantidad+"</td>"+
							"<td align='center'><img src='../../img/cancel.png' style='cursor:pointer' onclick='remover_ficha("+count+")' title='Borrar Registro' /></td>"+
							"</tr>")		
			
		 $("#contar_diagnostico").val(count)
		 $("#contar_diagnostico2").val(count)
		$("#fecha").val("");
		$("#uso").val(0);
		$("#cant").val(0);
		Calcular()
		
    }
	
	function Calcular(){
		var tDeterminaciones	= $("#contar_diagnostico").val();
		var mkits	= $("#montokits").val();
		var tdet	= 0;
		var saldos	= 0;
		
		//alert(tDeterminaciones)
		
		for( var y=1;y<=tDeterminaciones;y++)
		{
			if(typeof($("#cantidad"+y).val())!= 'undefined' )
			{
			tdet += parseFloat($("#cantidad"+y).val());
			saldos = parseFloat(mkits)-parseFloat(tdet)
			}
		}

			   
		$("#usado1").html("Total Utilizados: "+tdet);
		$("#saldo1").html("Total Saldo: "+saldos)
		
		$("#usado").val(tdet)
		$("#saldo").val(saldos)
		
	}
	
	function cuentaItem(){
	var diag=0;
	$("#contar_diagnostico2").val(diag);
	for( var i=1;i<=$("#contar_diagnostico").val();i++)
		{
			if(typeof($("#iduso"+i).val())!= 'undefined' )
			{
			   diag++;
			   $("#contar_diagnostico2").val(diag);
			}
		}
		Calcular()
	}
	
	function remover_ficha(idx)
	{
		$("#itemusodeterminante"+idx).remove();
		cuentaItem();
	}
	</script>





