<?php
	$path = "http://".$_SERVER['HTTP_HOST']."/labref/";
	include("../../objetos/class.conexion.php");

	$objconfig = new conexion();

	$cod	= $_GET["idfoco"];
	$idmu	= $_GET["idm"];

	if($cod!=0)
	{
		$query = "select * from entomologia_foco where idfoco=".$cod;
		$row = $objconfig->execute_select($query);

	}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laboratorrio Referencial | Tipo de Focos</title>
  <link href="<?=$path?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<script type="text/javascript" language="javascript" >
	var carpeta = "../../laboratorio/entomologia/"
	//var carpeta_ajax = "../../ajax/"
	
	function agregar_recipiente()
	{
	
    var focos		=   $("#foco").val();
    var foco_text	=   $("#foco option:selected").html();
    var recinsp		=   $("#rinspec").val();
    var recposi		=   $("#rposit").val();
    var otros		=   $("#tips").val();
	
   
    if(focos==0)
    {
        alert("Seleccione el tipo de Recipiente !!!")
        $("#foco").focus();
        return
    }
	if(recinsp=="")
    {
        alert("Recipiente Inspeccionado no debe ser Nulo!!!")
        $("#rinspec").focus();
        return
    }
	if(recposi=="")
    {
        alert("Recipiente Positivos no debe ser Nulo!!!")
        $("#rposit").focus();
        return
    }
		
    contar_recip++;
    
	$("#tbfoco").append("<tr id='itemfoco"+contar_recip+"'>"+
      	"<td>"+contar_recip+"</td>"+
		"<td><input type='hidden' name='idtipofoco"+contar_recip+"' id='idtipofoco"+contar_recip+"' value='"+focos+"' />"+foco_text+"</td>"+
        "<td><input type='hidden' name='rinspeccionado"+contar_recip+"' id='rinspeccionado"+contar_recip+"' value='"+recinsp+"' />"+recinsp+"</td>"+
        "<td><input type='hidden' name='rpositiva"+contar_recip+"' id='rpositiva"+contar_recip+"' value='"+recposi+"' />"+recposi+"</td>"+
        "<td><input type='hidden' name='idtipo"+contar_recip+"' id='idtipo"+contar_recip+"' value='"+otros+"' />"+otros+"</td>"+
        "<td align='center'><img src='../../img/cancel.png' style='cursor:pointer' onclick='quitar_recip("+contar_recip+")' title='Borrar Registro' /></td>"+
        "</tr>")

    $("#rinspec").val("");
   	$("#foco").val(0);
	$("#rposit").val("");
	$("#tipos").val("");
	
    $("#contar_recip").val(contar_recip);
    $("#contar_recip2").val(contar_recip);
	alert(contar_recip)

    cuentaItemA2()
  
	}

	function quitar_recip(idx)
	{
		$("#itemfoco"+idx).remove();
		cuentaItemA2();
	}

	function cuentaItemA2(){
		var diag=0;
		$("#contar_recip2").val(diag);
		for( var i=1;i<=$("#contar_recip").val();i++)
		{
			if(typeof($("#idtipofoco"+i).val())!= 'undefined' )
			{
			   diag++;
			   $("#contar_recip2").val(diag);
			}
		}
	}

	 function esNumero(strNumber) {
        if (strNumber == null) return false;
        if (strNumber == undefined) return false;
        if (typeof strNumber === "number" && !isNaN(strNumber)) return true;
        if (strNumber == "") return false;
        if (strNumber === "") return false;
        var psInt, psFloat;
        psInt = parseInt(strNumber);
        psFloat = parseFloat(strNumber);
        return !isNaN(strNumber) && !isNaN(psFloat);
    }

	
	

</script>


	</head>
	<body>


	<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form"  action="guardar_recipientes.php" >
	 <input type="hidden" name="op" id="op" value="1"  />
	 <input type="hidden" name="idfoco" id="idfoco" value="<?=$cod?>"   />
	 <input type="hidden" name="idingresomuestra" id="idingresomuestra" value="<?=$idmu?>"   />
	 <div class="card-body">
         <!-- /.panel-heading -->
		<div class=" modal-body">
			<div class="col-sm-12">
				<div class="row">
				<div class="col-md-1">
					<label for="atencion" class="control-label">Foco:  </label>
				</div>
				<div class="col-md-3">
					<select id="foco" name="foco" class=" form-control"   >
						<option value="0"></option>
						<?php
						
						$queryT = "select idtipofoco,descripcion, codigo 
									from tipofoco  where estareg=1
									order by codigo asc";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							echo "<option value='".$rowT["idtipofoco"]."' ".$selected." >".strtoupper($rowT["codigo"]." - ".$rowT["descripcion"])."</option>";
						}
						?>
					</select>
				</div>
								
                    <div class="col-sm-1">
                        <label for="atencion" class="control-label"> Recip. Inspec:  </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="number" id="rinspec" name="rinspec"  value="" class="form-control"  />
                    </div>
					<div class="col-sm-1">
                        <label for="atencion" class="control-label">Positivos:  </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="number" id="rposit" name="rposit"  value="" class="form-control"  />
                    </div>
                    <div class="col-sm-1">
                        <label>Tipo</label>
                    </div>
                    <div class="col-sm-1">
                     <input type="text" id="tips" name="tips"  value="" class="form-control"  />
                    </div>
					<div class="col-md-1">
						<input type="button" onclick="agregar_recipiente();" class="btn btn-info"  value="Agregar" />
					</div>
                </div>
			</div>
			<br/>
			<br/>
			<div class="row">
			<div class="col-sm-12">
				
				<div style="height:280px;  overflow-x:hidden;" >
				 <div class="panel panel-info ">
				 <div class="panel-heading ">Listado de Monitoreos Realizados </div>
					<div class="table-responsive">
				 	<div class="panel-body ">
						<table class="table table-striped table-bordered table-hover " width="100%" id="tbfoco" name="tbfoco"  >
							<thead >
							<tr >
								<td class="text-center">#</td>
								<td class="text-center" >Tipo Foco</td>
								<td  class="text-center">Inspeccionado</td>
								<td  class="text-center">Positivos</td>
								<td  class="text-center">Tipo</td>
								<td  ></td>
							</tr>
							
							</thead>
							<tbody>
							<?php
							$contar_recip=0;
							$totrecip=0;
							$totposit=0;
							
							$queryM = " select f.idfoco, f.idtipofoco, f.rinspeccionado,f.rpositiva,f.idtipo, z.descripcion as tipfoco
							from entomologia_foco as f
							inner join tipofoco as z on(z.idtipofoco=f.idtipofoco)
							where f.idfoco=".$cod." order by  f.idtipofoco";						
						
							$row = $objconfig->execute_select($queryM,1);
                         
							foreach($row[1] as $rRt)
							{
								$contar_recip++;
								$totrecip +=$rRt["rinspeccionado"];
								$totposit +=$rRt["rpositiva"];

								?>
								<tr id='itemfoco<?php echo $contar_recip; ?>' name='itemfoco<?php echo $contar_recip; ?>' >
									<td >
										<input type='hidden' name='idfoco<?php echo $contar_recip; ?>' id='idfoco<?php echo $contar_recip; ?>' value='<?php echo $rRt["idfoco"]; ?>' />
										<?php echo $contar_recip ; ?>
									</td>
									<td>
										<input type='hidden' name='idtipofoco<?php echo $contar_recip; ?>' id='idtipofoco<?php echo $contar_recip; ?>' value='<?php echo $rRt["idtipofoco"]; ?>' />
										<?php echo strtoupper($rRt["tipfoco"] ); ?>
									</td>
									<td>
									<input type='hidden' name='rinspeccionado<?php echo $contar_recip; ?>' id='rinspeccionado<?php echo $contar_recip; ?>' value='<?php echo $rRt["rinspeccionado"]; ?>' />
										<?php echo $rRt["rinspeccionado"] ; ?>
									</td>
									<td>
										<input type='hidden' name='rpositiva<?php echo $contar_recip; ?>' id='rpositiva<?php echo $contar_recip; ?>' value='<?php echo $rRt["rpositiva"]; ?>' />
										<?php echo strtoupper($rRt["rpositiva"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idtipo<?php echo $contar_recip; ?>' id='idtipo<?php echo $contar_recip; ?>' value='<?php echo $rRt["idtipo"]; ?>' />
										<?php echo strtoupper($rRt["idtipo"] ); ?>
									</td>
						
									<td >
									<!--
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_recip(<?php echo $contar_recip; ?>)' title='Borrar REgistro' />
									-->
									</td>
								</tr>
								
							<?php }?>
							</tbody>
						</table>
						<input type="hidden" id="contar_recip" name="contar_recip" value="<?php echo $contar_recip; ?>" />
						<input type="hidden" id="contar_recip2" name="contar_recip2" value="<?php echo $contar_recip; ?>" />
						
						<script> var  contar_recip=<?php echo $contar_recip; ?> </script>
						</div>
					</div>
						<input type="hidden" id="total_recip" name="total_recip" value="<?php echo $totrecip; ?>" />
						<input type="hidden" id="total_posit" name="total_posit" value="<?php echo $totposit; ?>" />

					</div>
				</div>
				</div>
			</div>
	
			</div>
			<div class="upload-msg col-sm-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
			<div class="modal-footer">
			<!--	<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Guardar" />	-->
				<input type="submit"  name="action" id="action" class="btn btn-success"  value="Guardar" />
				<input type="button" onclick="window.close();" name="cancelar" id="cancelar" class="btn btn-default"  value="Cancelar" />
			</div>
	
	
	</div>
	</form>
	
	<!-- jQuery -->
	<script src="<?=$path?>bootstrap/vendor/jquery/jquery.min.js"></script>
	

</body>
</html>

