<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from red where idred=".$cod;
		$row = $objconfig->execute_select($query);
	}

		
?>
 <meta charset="UTF-8">
 <meta http-equiv="content-type" content="text/html; utf-8">
<link rel="stylesheet" media="screen" href="<?=$path?>bootstrap/fecha/css/bootstrap-datetimepicker.min.css" >
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>js/tooltip.js" charset="UTF-8"></script>

<script type="text/javascript">

 var count=0;

    $('.form_datetime').datetimepicker({
       // language:  'fr',
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1
    });
	$('.form_time').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });

 
 function sub_alimentos(id,idsb)
 {
	$.ajax({
		type: "POST",
		url: carpeta+"subalimentos.php",
		data: "id="+id+"&idsub="+idsb,
		success: function(data) {
		$("#div-alimentos").html(data)
	 }
	});
 }

 function Estalecimiento(id,est)
 {
	$.ajax({
	 type: "POST",
	 url: carpeta+"establecimiento.php",
	 data: "idpa="+id+"&esta="+est,
	 success: function(data) {
		 $("#div-estable").html(data)
	 }
	});
 }
 
 function ValidaLongitud(campo, longitudMaxima) {
            try {
                if (campo.value.length > (longitudMaxima - 1))
                    return false;
                else
                    return true;             
            } catch (e) {
                return false;
            }
        }

</script>


<style>
	/* 
	table, th, td {
        border: 0px solid black;
        font-family: "Times New Roman", serif;
        font-size: 11px;
    }
	*/
	@media (min-width: 768px) {
        .container {
            width: 750px;
        }
    }
    @media (min-width: 992px) {
        .modal-lg {
            width: 1200px; /* control width here */
            height: auto; /* control height here */
            margin-left: -300px;
            padding-top: 10px;

        }
    }
</style>
<form method="POST" id="registrar_nota" onsubmit="registrar_nota(); return false">
<div class="modal-content modal-lg">
	<div class="modal-header">
			        
		<div class="row">
			<div class="col-lg-12">
		<button type="button" onclick="ocultarModalNotaCredito();" class="close" data-dismiss="modal">&times; </button>
				
				<h1 class="page-header">Registrar nota de credito</h1>
				<div class="row">
					<div class="col-lg-7">
						<h3>Datos Comprobante</h3>
					</div>
					<div class="col-lg-1">
						<label for="">Tipo:</label>
					</div>
					<div class="col-lg-4">
						<select class="form-control" name="tipo_anula" id="">
							<option value="" disabled></option>
							<?php
								$sql="select codigo, descripcioncompleta from tipodiscrepancias where estado=1 and Codigo='01' and idtipocomprobante='07' order by DescripcionCompleta desc;";
								$ress=$objconfig->execute_select($sql,1) ;
								foreach($ress[1] as $tipoDisc){
									echo '<option value="'.$tipoDisc['codigo'].'" '.(($tipoDisc['codigo']=="01")?"selected":"").'>'.$tipoDisc['descripcioncompleta'].'</option>';
								}
							?>
						</select>
					
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="modal-body">
		
		<div class="row" style="margin-top:1.5rem; display:flex; justify-content:space-between">
		
			
			<div class="col-lg-7">
				<div class="row">
				
					<div class="col-lg-3">
						<label for="">Comprobante</label>
						<select class="form-control combobox" name="" id="comprobantes" style="width: 100%">
                                    <option value="" disabled selected></option>

                                    <?php
										$itemsPago=[];
                                        $sql="select P.nrodocumento, P.idpago, P.itempago, TC.descripcion, P.fecharecepcion, C.ruc, C.razonsocial, C.direccion 
										from pago P inner join tipo_comprobante TC on (P.idcomprobante=TC.idcomprobante) inner join cliente C on 
										(P.idcliente=C.idcliente) where P.esta_ncredito=0 and P.esta_envio=1 order by P.fechareg desc;";
                                        $res=$objconfig->execute_select($sql,1) ;
                                        foreach($res[1] as $pago){
											$ccount=0;
											foreach($itemsPago as $iitem){
												if($iitem==$pago["itempago"]){
													$ccount++;
												}
											}
											if($ccount==0){
												array_push($itemsPago,$pago["itempago"]);
												echo '<option value="'.$pago['itempago'].'" nrodoc="'.$pago['nrodocumento'].'" tpcomprobante="'.$pago['descripcion'].'" fecha="'.$pago['fecharecepcion'].'" ruc="'.$pago['ruc'].'" rz="'.$pago['razonsocial'].'" direccion="'.$pago['direccion'].'">'.$pago['nrodocumento'].'</option>';
											}
                                        }
                                    ?>
                            </select>
					</div>
					<div class="col-lg-3">
						<label for="">Documento:</label>
						<input class="form-control" type="text" id="comprobante" placeholder="0000-000000" readonly/>
					</div>
					<div class="col-lg-3">
						<label for="">Fecha Emision:</label>
						<input class="form-control" type="date" id="fecha_emision" readonly/>
					</div>
					<div class="col-lg-3">
						<label for="">RUC/DNI:</label>
						<input class="form-control" type="text" id="ruc_cliente" placeholder="0000000" readonly/>
					</div>
				</div>
				<div class="row" style="margin-top:1.5rem">
					<div class="col-lg-2">
						<label for="">Cliente:</label>    
					</div>
					<div class="col-lg-10">
						<input class="form-control" id="cliente" type="text" readonly/>
						<!-- <select id="idclientes" class="form-control">
							<option value="" disabled selected></option>;
							<?php
								/* $sql="select idcliente, razonsocial, direccion from cliente where estareg=1;";
								$res=$objconfig->execute_select($sql,1) ;
								foreach($res[1] as $pago){
									echo '<option value="'.$pago['idcliente'].'" direc="'.$pago['direccion'].'">'.$pago['razonsocial'].'</option>';
								} */
							?>
						</select> -->
					</div>
				</div>
				<div class="row" style="margin-top:1.5rem">
					<div class="col-lg-2">
						<label for="">Dirección:</label>    
					</div>
					<div class="col-lg-10">
						<input class="form-control" type="text" id="direccion_cliente" placeholder="" readonly/>
						<input style="display:none" type="text" name="comprobante_select" id="comprobante_select" readonly value="0"/>
					</div>
				</div>
			</div>
			<div class="col-lg-4" style="border-color: #343a40; border: 1px solid #000; margin: 2rem 2rem;padding: 1rem .5rem; border-radius: 0.5rem;">
				
				<label class="my-2" style="margin-top:.3rem">Observación:</label>
				<div class="row" style="display:flex; align-items:center">
					<div class="col-lg-8" >
						<div class="row" style="padding: .2rem 1.3rem">
							<textarea class="form-control" name="observacion" rows="4" cols="50" required></textarea>
						</div>
						
					</div>
					<div class="col-lg-4">
						<div class="row">
							<!-- <button type="button" class="btn btn-primary" onclick="modalShow1()">Buscar<br/>Comprobante</Button>
 -->						<button type="submit" class="btn btn-success" >GENERAR</Button>
 							
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12" style="display: flex; justify-content:end">
						
					</div>
				</div>
			</div>
			</form>
		</div>
		<!-- <div class="row">
			<div class="col-lg-12">
				<br/>
				<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%">
					<thead class="thead-inverse">
						<tr>
							<th> # </th>
							<th>Descripcion</th>
							<th>U.M</th>
							<th>Cantidad</th>
							<th>Prec. Unitario</th>
							<th>Descuento</th>
							<th>Igv</th>
							<th>S. Total</th>
						</tr>
					</thead>
					
				</table> 
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2">
				<label for="">Importe Bruto:</label>
				<input class="form-control" id="imp_bruto" type="number" placeholder="0.00" value="0" readonly/>
			</div>
			<div class="col-lg-2">
				<label for="">Descuento:</label>
				<input class="form-control" id="id_desc" type="number" placeholder="0.00" value="0" readonly/>
			</div>
			<div class="col-lg-2">
				<label for="">Sub Total:</label>
				<input class="form-control" id="imp_bruto1" type="number" placeholder="0.00" value="0" readonly/>
			</div>
			<div class="col-lg-2">
				<label for="">Importe Total</label>
				<input class="form-control" id="imp_bruto2" type="number" placeholder="0.00" value="0" readonly/>
			</div>
		</div> -->
	</div>
</div>
</form>
<script>
$('#comprobantes').select();
$('#idclientes').select();

   $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>


/* recarga2(carpeta); */
console.log('Test nota credito');
/* $("#idclientes").on('change',function (){
    console.log($(this).val());
    $("#direccion_cliente").val($('option:selected',this).attr("direc"));
}) */
/* tipo_comprobante
comprobante
fecha_emision
ruc_cliente
cliente
direccion_cliente
echo '<option value="'.$pago['idpago'].'" nrodoc="'.$pago['nrodocumento'].'" tpcomprobante="'.$pago['descripcion'].'" fecha="'.$pago['fecharecepcion'].'" ruc="'.$pago['ruc'].'" rz="'.$pago['razonsocial'].'" direccion="'.$pago['direccion'].'">'.$pago['nrodocumento'].'</option>';
 */
$("#comprobantes").on('change', function() {
    console.log(this.value);
    $("#comprobante_select").val(this.value);
    $("#tipo_comprobante").val($('option:selected',this).attr("tpcomprobante"));
    $("#comprobante").val($('option:selected',this).attr("nrodoc"));
    $("#fecha_emision").val($('option:selected',this).attr("fecha"));
    $("#ruc_cliente").val($('option:selected',this).attr("ruc"));
    $("#cliente").val($('option:selected',this).attr("rz"));
    $("#direccion_cliente").val($('option:selected',this).attr("direccion"));
    /* modalHidden();
    recarga2(carpeta); */
  });
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
	})
</script>
