
var carpeta = "../laboratorio/psa/";
var aja2 =  "../../ajax/";

function mostrarVentana()
{
    var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}

function ocultarVentana()
{
    $('#userModal').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 
}

function mostrarImpre()
{
   var ventana = document.getElementById('impresiones'); // Accedemos al contenedor
}

function cerrarImpresion()
{
    $('#impresiones').modal('hide');
}

function imprimir(nro)
{
	var server = window.location.hostname;
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	var urlprint = carpeta+"imprimir.php?nromovimiento="+nro+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}

function cargar_form(op,cod)
{
	$.ajax({
		type: "POST",
		url: carpeta+"form-mantenimiento.php",
		data: "op="+op+"&cod="+cod,
		success: function(data) {
		mostrarVentana();
			$('#modal-body').html(data)
			
		}
	});	
}

function cargar_resltados(op,cod)
{
	$.ajax({
		type: "POST",
		url: carpeta+"resultados.php",
		data: "op="+op+"&cod="+cod,
		success: function(data) {
		mostrarVentana();
			$('#modal-body').html(data)
			
		}
	});	
}

function cambiarestado(obj,input)
{
	if(obj.checked)
	{
		$("#"+input).val(2)
		document.getElementById("boton01").className = "btn btn-success";
		document.getElementById('boton01').innerHTML="Examen Completo ";
	}else{
		$("#"+input).val(1)
		document.getElementById('boton01').innerHTML="Examen Pendientes";
		document.getElementById("boton01").className = "btn btn-danger";
	}
}

function validar_form()
{
    if($('#codbarra').val()=="")
    {
        alert("Debe Ingresar Codigo de Barra")
		$('[href="#home"]').tab('show');
        $("#codbarra").focusin();
        return
    }
	
	var idest = $('#idestablesolicita').val();
	var idestable = idest.replace(/ /g, "");
	
    if(idestable=="" || idestable==0)
    {
		alert("Debe Ingresar el codigo de Barra válido para tener Laboratorio Solicitante ")
		$('[href="#home"]').tab('show');
		
        $("#codbarra").focusin();
        return false
    }
	var idpac = $('#idpaciente').val();
	var idpaciente =idpac.replace(/ /g, "");
	if(idpaciente=="" || idpaciente==0 )
    {
        alert("Debe Seleccionar el Paciente ")
		$('[href="#home"]').tab('show');
        $("#idpaciente").focusin();
        return
    }
    if($('#idtipomuestra').val()=="")
    {
        alert("Debe Seleccionar tipo de Muestra entregada")
		$('[href="#home"]').tab('show');
        $("#idtipomuestra").focusin();
        return
    }
	if($('#idmedicosolicitante').val()=="0")
    {
        alert("Debe Seleccionar Medico solicita del Examen ")
        $('[href="#home"]').tab('show');
		$( "#idmedicosolicitante" ).focusin()  
				 
        return
    }
	if($('#idarea').val()=="0")
    {
        alert("Debe Seleccionar Medico solicita del Examen ")
        $('[href="#home"]').tab('show');
		$( "#idarea" ).focusin()  
				 
        return
    }
	
	
        guardar_datos()

	return true
}


function guardar_datos()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: $("#user_form").serialize(),
        success: function(data) {
      //  alert(data)
        regresar_index(carpeta)
        }
    });
    ocultarVentana()
}

function regresar_index(dir)
{
    var resultado = document.getElementById('page-wrapper');
    ajax = objetoAjax();
    ajax.open("GET", dir+"index.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            recarga2(dir)
        }
    }
    ajax.send(null);
}

function recarga2(dir){
    $(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "destroy":true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "ajax": dir+"registros.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		 if ( aData[10] == "PROCESADO")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[10] == "ANULADO")
			{
				$('td', nRow).css('color', 'red');
			}
		}
        } );
    } );
}

function anular_referencia(id,nref)
{
    var res=confirm("¿Desea Anular la referencia Nª "+nref+" ?")
    if(res==false)
    {
        return false
    }
	else {
   	    $.ajax({
            type:  "POST",
            url:   carpeta+"anular.php",
            data:  "anulado="+id+"&numero="+nref,
            success: function(data) {
			regresar_index(carpeta)
			}
		});
	}
}

function buscar_establecimiento()
{
    objindex="Establecimiento"
    var ventana=window.open("../lista/muestras/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function agregar_prueba()
{
    var fresult		=   $("#fecharesultado").val()
    var tip_prueb	=   $("#tipoprueba").val()
    var text_tiprueba	=	$("#tipoprueba option:selected").html();
	var valor		=   $("#valor").val()
    var tptor		=   $("#tipotorch").val()
	var text_tptor  = 	$("#tipotorch option:selected").html();
  
    if(tip_prueb==0)
    {
        alert("Seleccionar Prueba")
        $("#tipoprueba").focus();
        return
    }
    if(valor=="")
    {

        alert("valor no debe ser Nulo!!! ")
        $("#tipo_antigrama").focus();
        return
    }
	if(tptor==0)
    {
        alert("Debe seleccionar el Resultado!!! ")
        $("#tipotorch").focus();
        return
    }
   
    for( var i=1;i<=$("#contar_prueba").val();i++)
    {
        if(tip_prueb == $("#idtipoprueba"+i).val() )
        {
            alert("El Tipo de Prueba ya Fue Agregado")
            $("#tipoprueba").val(0)
            return
        }
    }

    count_prue++;
    $("#tbprueba").append("<tr id='itemprueba"+count_prue+"'>"+
        "<td>"+count_prue+" </td>"+
        "<td><input type='hidden' name='fecharesultado"+count_prue+"' id='fecharesultado"+count_prue+"' value='"+fresult+"' />"+fresult+"</td>"+
        "<td><input type='hidden' name='idtipoprueba"+count_prue+"' id='idtipoprueba"+count_prue+"' value='"+tip_prueb+"' />"+text_tiprueba+"</td>"+
        "<td><input type='hidden' name='valor"+count_prue+"' id='valor"+count_prue+"' value='"+valor+"' />"+valor+"</td>"+
        "<td><input type='hidden' name='idtipotorch"+count_prue+"' id='idtipotorch"+count_prue+"' value='"+tptor+"' />"+text_tptor+"</td>"+
        "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_prue+")' title='Borrar Registro' /></td>"+
        "</tr>")


    $("#tipoprueba").val(0)
    $("#valor").val("")
    $("#tipotorch").val("")
    $("#contar_prueba").val(count_prue)
	cuentaItem()
  
}

function quitar_diagnostico(idx)
{
	$("#itemprueba"+idx).remove();
	cuentaItem();
}

function cuentaItem(){
	var diag1=0;
	$("#contar_prueba2").val(diag1);
	for( var i=1;i<=$("#contar_prueba").val();i++)
    {
        if(typeof($("#idtipoprueba"+i).val())!= 'undefined' )
        {
           diag1++;
		   $("#contar_prueba2").val(diag1);
        }
    }
}

function buscar_paciente()
{
	objindex="Pacientes"
	var ventana=window.open("../lista/pacientes/", 'Pacientes', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
	ventana.focus();
}


function imprimir_detalles(idpc)
{
    var ventana=window.open(carpeta+"imprimir.php?idpc="+idpc, 'Imprimir Detalle del Equipo', 'width=800,height=600,resizable=no, scrollbars=yes, status=yes,location=yes'); 
    ventana.focus();
   
}

function recibir(id,nombre,coddiad)
{
    if(objindex=="Pacientes")
    {
        $("#idpaciente").val(id)
        $("#nombre_paciente").val(coddiad+" - "+nombre)
        CalcularEdad(id)
    }

    if(objindex=="Establecimiento")
    {
		var fechas = nombre
		res = fechas.split("-");
		var nfecha = res[0]+"/"+res[1]+"/"+res[2]
		
        $("#idestablesolicita").val(id)
        $("#nombre_establecimiento").val(coddiad)
        $("#fecharecepcion").val(nfecha)
	
    }
}

function buscar_renaes()
{
	var idbarra = $("#codbarra").val()
		
	$.ajax({
		type: "POST",
		url: carpeta+"procedencia.php",
		data: "idipres="+idbarra,
		success: function(data) {
		
		var	res = data.split("|");
		var idestab = res[0];
		var nombre = res[1];
		var frec = res[2];
		var tip = res[3];
		var idejec = res[4];
		var idred = res[5];
		var idmcr = res[6];
		if (idestab ==0){
			alert("Codigo ya se encuentra Registrado o Anulado, Por favor intente con otro Codigo")
			$("#codbarra").val("");
			$("#idestablesolicita").val(0)
			$("#nombre_establecimiento").val(nombre)
			return false
			}else {
	//	var resp = frec.split("-");
	//	var nfecha = resp[2]+"-"+resp[1]+"-"+resp[0];
	
		$("#idejecutorasolicita").val(idejec)
		$("#idredsolicita").val(idred)
		$("#idmicroredsolicita").val(idmcr)
		$("#idestablesolicita").val(idestab)
        $("#nombre_establecimiento").val(nombre)
	     //  $("#fecharecepcion").val(nfecha)
        $("#idingresomuestra").val(tip)
		tipo_atencion(tip)
		tipo_exam(tip)
		tipo_prueba(tip)
			}
		}
	});
	
}
function tipo_prueba(id)
 {
	var opa = $("#op").val();
	var tor = $("#idingresomuestra").val();
	 
	$.ajax({
         type: "POST",
         url: carpeta+"tipoprueba.php",
		 data: "idtpate="+id+"&op="+opa+"&idtor="+tor,
         success: function(data) {
		//	 alert(data)
		 $("#div-tipprueba").html(data)
		 }
     });
 }
 

function tipo_atencion(id)
 {
	var opa = $("#op").val();
	var tor = $("#codigo").val();
	 
	$.ajax({
         type: "POST",
         url: carpeta+"tipoatencion.php",
		 data: "idtpate="+id+"&op="+opa+"&idtor="+tor,
         success: function(data) {
		 $("#div-seguro").html(data)
		 }
     });
 }
 
 function tipo_exam(id)
 {
	var opa = $("#op").val();
	 
	$.ajax({
         type: "POST",
         url: carpeta+"examenes.php",
		 data: "idtpate="+id+"&op="+opa,
         success: function(data) {
		 $("#div-datos").html(data)
		 }
     });
 }
 
 function mayuscula(e) {
	e.value = e.value.toUpperCase();
}