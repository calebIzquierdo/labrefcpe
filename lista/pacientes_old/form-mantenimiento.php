<?php
	include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();

	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	function base64_to_jpeg( $base64_string, $output_file ) {
    $ifp = fopen( $output_file, "wb" ); 
    fwrite( $ifp, base64_decode( $base64_string) ); 
    fclose( $ifp ); 
    return( $output_file ); 
}

	if($cod!=0)
	{
		$query = "select * from paciente where idpaciente=".$cod;
	//	echo $query;
		$row = $objconfig->execute_select($query);

        $queryEdad = "SELECT date_part('year',age(fnacimiento)) as edadactual, date_part('MONTH',age(fnacimiento)) as mess FROM paciente WHERE idpaciente=".$cod;
        $rowEdad = $objconfig->execute_select($queryEdad);
		
		//$foto = $row[1]["img_paciente"];
		$foto = base64_to_jpeg( $row[1]["img_paciente"], 'tmp.jpg' );;
		//echo base64_decode($foto);

	}
?> 
<script type="text/javascript" language="javascript" >
	//var carpeta = "../../lista/pacientes/"
	var carpeta = ""
	var carpeta_ajax = "../../ajax/"
	
	
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
	

function cargar_datos_departamentoA(val,seleccion,opc)
{
	if (val==2){
		
		$.ajax({
        type: "POST",
        url:  carpeta+"ubigeo.php",
            success: function(data) {
			$("#div-ubigeo2").html(data)
        }
    });
		
		cargar_datos_provinciaA(0,0,2)
		cargar_datos_distritoA(0,0,2)
		//cargar_datos_sectoresA(0,0,0)

		$.ajax({
			type: "POST",
			url:  carpeta_ajax+"departamento.php",
			data:"idpais="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=1",
			success: function(data) {
				$("#div-departamentoB").html(data)
			}
		});
	} else {
		$.ajax({
        type: "POST",
        url:  carpeta+"ubigeo2.php",
            success: function(data) {
            $("#div-ubigeo2").html(data)
        }
    });
	}
}

function cargar_datos_provinciaA(val,seleccion,opc)
{
    $.ajax({
        type: "POST",
        url:  carpeta_ajax+"provincia.php",
        data:"iddepartamento="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=1",
        success: function(data) {
            $("#div-provinciaB").html(data)
        }
    });
}

function cargar_datos_distritoA(val,seleccion,opc)
{
    $.ajax({
        type: "POST",
        url:  carpeta_ajax+"distrito.php",
        data:"idprovincia="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=1",
        success: function(data) {
            $("#div-distritoB").html(data)
        }
    });
}


function buscar_dni()
{
	//BTN search reniec
	
		var tipoDoc =$("#iddocumento").val();
		var nrodoc =$("#nrodocumento").val();
		
		if(tipoDoc==0 && nrodoc==""){
			alert("Tipo documento y número no debe ser nulo!!!")
        	$("#iddocumento").focus();
        	$("#nrodocumento").focus();
			return;
		}
		
		/*
		if($("#nrodocumento").val().length<5){
			alert("Numero DNI debe contener 8 Digitos")
        	$("#nrodocumento").focus();
			return;
		}
		if($('#iddocumento').val()!=1 ){
				alert("Solo esta Permitido Busqueda con DNI")
				$("#nrodocumento").focus();
				return;
		}
		*/
		
			var ajax = new XMLHttpRequest();
			ajax.open("GET", carpeta+"consultadni.php?id="+$("#nrodocumento").val()+"&tipo="+$("#iddocumento").val());
			ajax.onreadystatechange = function() {
				if (ajax.readyState == 4) {				
					var res=JSON.parse(ajax.responseText);
					console.log(res);
				//	alert(res.apellidoPaterno);
					if(!res.status){
						$('input.selectpicker').val('');
						$("input[name='0form_nombres'").val('');
						$("input[name='0form_apellidos'").val('');
						$("#imgpaciente").attr('src', 'https://static.vecteezy.com/system/resources/previews/005/228/939/original/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg');
						$("#nrodocumento").focus();
						alert(res.msm)
						return;
					}else {
							//	$('input.selectpicker').val(res.apellidoPaterno+" "+res.apelidoMaterno);
							$("input[name='0form_nombres'").val(res.nombres);
							$('#nombres').val(res.nombres);
							$("input[name='0form_apellidos'").val(res.apellidoPaterno+" "+res.apellidoMaterno);
							$('#apellidos').val(res.apellidoPaterno+" "+res.apellidoMaterno);
							$('#celular').val(res.direccion);
							if(res.foto){
								$("#imgpaciente").attr('src', 'data:image/png;base64,' + res.foto);
								$("input[name='0form_img_paciente'").val(res.foto);
								}else{
									$("#imgpaciente").attr('src', 'https://static.vecteezy.com/system/resources/previews/005/228/939/original/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg');
								}
						}
					}
					
				}
			
			ajax.send(null);
			
	$('#nrodocumento').on('input', function (e) {
		if (!/^[ a-z0-9áéíóúüñ]*$/i.test(this.value)) {
			this.value = this.value.replace(/[^ a-z0-9áéíóúüñ]+/ig,"");
		}
	});
}


    function CalcularEdad(fecha) {
    /*    fecha = new Date(fecha)
        hoy = new Date()
        ed = parseInt((hoy - fecha) / 365 / 24 / 60 / 60 / 1000)
        mes = parseInt((hoy - fecha) / 24 / 60 / 60 / 1000)
        document.getElementById('edadactual').value = ed+" A"+mes
     dd/mm/yyyy
     yyyy-mm-dd
*/
        // Si la fecha es correcta, calculamos la edad

        if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
            fecha = formatDate(fecha, "dd/mm/yyyy");
        }

        var values = fecha.split("/");
        var dia = values[0];
        var mes = values[1];
        var ano = values[2];

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth() + 1;
        var ahora_mes1 = fecha_hoy.getMonth() ;
        var ahora_dia = fecha_hoy.getDate();
	
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }

        // calculamos los meses
        var meses = 0;

        if (ahora_mes > mes && dia > ahora_dia)
            meses = ahora_mes - mes - 1;
        else if (ahora_mes > mes)
            meses = ahora_mes - mes
        if (ahora_mes < mes && dia < ahora_dia)
            meses = 12 - (mes - ahora_mes);
        else if (ahora_mes < mes)
            meses = 12 - (mes - ahora_mes + 1);
        if (ahora_mes == mes && dia > ahora_dia)
            meses = 11;

        // calculamos los dias
        var dias = 0;
        if (ahora_dia > dia)
            dias = ahora_dia - dia;
        if (ahora_dia < dia) {
            ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
        }
        document.getElementById('edadactual').value = edad + " Año(s), " + meses + " m"

     //   return edad + " años, " + meses + " meses y " + dias + " días";
    }
</script>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
    <div class="modal-content modal-lg">
        <div class="panel panel-default">
            <div class="panel-heading modal-header">
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<h4 class="modal-title">Mantenimiento de Pacientes</h4>
				<input type="text" name="op" id="op" value="<?php echo $op; ?>" readonly=readonly />
				<div class="col-md-2">
					<input type="hidden" name="1form_idpaciente" id="codigo" value="<?=$row[1]["idpaciente"]?>" class="form-control" readonly="readonly"   />
                    </div>
			</div>
			</div>
        <!-- /.panel-heading -->


			<div class="row modal-body">
			<div class="row col-md-12">
			<div class="col-md-2">
			<label>Tipo Documento:</label>
			</div>

			<div class="col-md-3" >
			<select id="iddocumento" name="0form_iddocumento"  class="form-control" onchange="buscar_dni();" >
			<option value="0">--Documento--</option>
			<?php
					   
				$queryT = "select iddocumento,descripcion from tipo_documento ";
				$itemsT = $objconfig->execute_select($queryT,1);
								
				foreach($itemsT[1] as $rowT)
				{
					$selected="";
					if($rowT["iddocumento"]==$row[1]["iddocumento"]){$selected="selected='selected'";}
					echo "<option value='".$rowT["iddocumento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
				}
			?>
			</select>
		</div>
			<div class="col-md-1">
			<label >Número Doc: </label>
			</div>
		<div class="col-md-2" >
		<input type="text"  name="0form_nrodocumento" id="nrodocumento" onchange="buscar_dni();" value="<?=$row[1]["nrodocumento"]?>"  class="form-control" />
		</div>
			<div class="col-md-1">
				<label >Tipo Seguro </label>
			</div>
			<div class="col-md-3" >
				<select id="idseguro" name="0form_idseguro"  class="form-control">
					<option value="0">--Seguro--</option>
					<?php

					$queryT = "select idseguro,descripcion from tipo_seguro where idseguro!=2 and estareg=1";
					$itemsT = $objconfig->execute_select($queryT,1);

					foreach($itemsT[1] as $rowT)
					{
						$selected="";
						if($rowT["idseguro"]==$row[1]["idseguro"]){$selected="selected='selected'";}
						echo "<option value='".$rowT["idseguro"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
		</div>
		</br>
		
		<div class="row col-md-12">
			<div class="col-md-2">
			<label>Nombre(s) </label>
			</div>
			<div class="col-md-3">
			<input type="text" name="0form_nombres" id="nombres" value="<?=$row[1]["nombres"]?>"  class="form-control" />
			</div>
			<div class="col-md-1">
				<label>Apellidos</label>
			</div>
			<div class="col-md-6">
			<input type="text" name="0form_apellidos" id="apellidos" value="<?=$row[1]["apellidos"]?>"  class="form-control" />
			</div>

		</div>
		</br>
		<div class="row col-md-12">
			 <div class="col-md-2">
				<label>Fecha Nacim.</label>
			</div>

			<div class="col-md-3">
				<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
					<input class="form-control" type="text" name="0form_fnacimiento" id="fnacimiento" value="<?php echo ($row[1]["fnacimiento"])?$objconfig->FechaDMY($row[1]["fnacimiento"]):date("d/m/Y");?>" onchange="CalcularEdad(this.value)" >
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
			<div class="col-md-1">
				<label>Edad Actual</label>
			</div>
			<div class="col-md-2">
			<input type="text" name="edadactual" id="edadactual" readonly value="<?=$rowEdad[1]["edadactual"]." A ".$rowEdad[1]["mess"]." M";?>" class="form-control" />
			</div>
			<div class="col-md-1">
				<label>Archivo Clínico</label>
			</div>
			<div class="col-md-2">
				<input type="text" name="0form_arclinico" id="arclinico" value="<?=$row[1]["arclinico"]?>" class="form-control" />
			</div>
		</div>
		</br>
		<div class="row col-md-12">
			<div class="col-md-2" >
				<label >Historia Clinica</label>
			</div>
			<div class="col-md-3" >
				<input type="text"  name="0form_hclinica" id="hclinica" value="<?=$row[1]["hclinica"]?>"  class="form-control" />
			</div>
			<div class="col-md-1" >
				<label >Sexo</label>
			</div>
			<div class="col-md-2" >
			<select id="idtiposexo" name="0form_idtiposexo"  class="form-control">
				<option value="0">--Sexo--</option>
				<?php

				$queryT = "select idtiposexo,descripcion from tipo_sexo where estareg =1 ";
				$itemsT = $objconfig->execute_select($queryT,1);

				foreach($itemsT[1] as $rowT)
				{
					$selected="";
					if($rowT["idtiposexo"]==$row[1]["idtiposexo"]){$selected="selected='selected'";}
					echo "<option value='".$rowT["idtiposexo"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
				}
				?>
			</select>
		 </div>
			<div class="col-md-1">
				<label>Pais</label>
			</div>
			<div class="col-md-3">
				<select id="pais2" name="0form_idpais" class="form-control" onchange="cargar_datos_departamentoA(this.value,0,2)" >
					<option value="0">--Seleccione el Pais--</option>
					<?php
					$queryT = "select idpais, descripcion from pais where estareg=1";
					$itemsT = $objconfig->execute_select($queryT,1);

					foreach($itemsT[1] as $rowT)
					{
						$selected="";
						if($rowT["idpais"]==$row[1]["idpais"]){$selected="selected='selected'";}
						echo "<option value='".$rowT["idpais"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
		</div>

		 <div id="div-ubigeo2"> </div>
		
		
		<div class="row col-md-12">
			<div class="col-md-2">
				<label>Contacto</label>
			</div>
			<div class="col-md-8">
				<input type="text" name="0form_celular" id="celular" value="<?=strtoupper($row[1]["celular"])?>" class="form-control" />
			</div>
		</br>
			<div class="col-md-2" >
				<?php
				$checked = "checked='checked'";
				$checked1 = "checked='checked'";
				$mensaje = "Activo";
				$class = "btn btn-primary";
				$estareg = 1;
				if(isset($row[1]["estareg"]))
				{
					$estareg = $row[1]["estareg"];
					if($estareg==0)
					{
						$checked = "";
						$mensaje = "Inactivo";
						$class = "btn btn-danger";
					}
				}

				?>
				<input type="checkbox" name="estado" id="estado" onclick="cambiarestado(this,'estareg');" class="checkbox-inline" <?php echo $checked;?> />
				<button type='button' class='<?php echo $class;?>' name="boton01" id="boton01" > <?php echo $mensaje;?> </button>
				<input type="hidden" name="0form_estareg" id="estareg" value="<?=$estareg?>"  />
			</div>
		</div>
		</br>
		<div class="row col-md-12">
			<div class="col-md-4" style="height:100% !important; display:flex; justify-content:center">
				<img id="imgpaciente" name="imgpaciente" style="background:blue; width:50%; height:300px; max-height:350px; object-fit:cover;object-position: center center;" src="https://static.vecteezy.com/system/resources/previews/005/228/939/original/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg" />
				<input type="hidden" name="0form_img_paciente" id="img_paciente" value=""  />
				
				<?='<img src="data:image/gif;base64,' . $data . '" />';;?>
			</div>	
		</div>
		 <br/>

            </div>
				
        <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
        <div class="modal-footer">
		<!--		<input type="hidden" name="user_id" id="user_id" />
				<input type="hidden" name="operation" id="operation" /> -->
                <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Guardar" />
				<button type="button" class="btn btn-default" onclick="regresar_index(carpeta)" data-dismiss="modal">Cerrar</button>
            </div>
		</div>
	</form>

<link rel="stylesheet" media="screen" href="<?=$path?>bootstrap/fecha/css/bootstrap-datetimepicker.min.css" >
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/date_es.js" charset="UTF-8"></script>

<script>

    cargar_datos_departamentoA("<?php $d=0;isset($row[1]["idpais"])?$d=$row[1]["idpais"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0; echo $d; ?>",2)
    cargar_datos_provinciaA("<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0; echo $d; ?>",2)
    cargar_datos_distritoA("<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>",2)
	var opci = $("#op").val(),
	if($opci ==2){
		buscar_dni()
	}
// $("#imgpaciente").attr('src', 'data:image/png;base64,' + <?=$row[1]["img_paciente"]?>);  
    // $( "#tabs" ).tabs();
</script>