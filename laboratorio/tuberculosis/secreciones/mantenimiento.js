
var carpeta = "../laboratorio/tuberculosis/secreciones/";
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
	var urlprint = "../laboratorio/tuberculosis/secreciones/imprimir.php?nromovimiento="+nro+"&embedded=true";
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

    if($('#idestablesolicita').val()=="")
    {
        alert("Debe Seleccionar Laboratorio Solicitante ")
		$('[href="#home"]').tab('show');
        $("#nombre_establecimiento").focusin();
        return
    }
	if($('#idpaciente').val()=="")
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
    //    alert(data)
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
		 if ( aData[12] == "PROCESADO")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[12] == "ANULADO")
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


function agregar_antigrama()
{
    var antigrama	=   $("#antibiograma").val()
    var nombantig	=	$("#antibiograma option:selected").html();
    var tipoantig	=   $("#tipo_antigrama").val()
	var nombtpant   = 	$("#tipo_antigrama option:selected").html();
  
    if(antigrama==0)
    {
        alert("Seleccionar Antigrama")
        $("#antibiograma").focus();
        return
    }
    if(tipoantig==0)
    {

        alert("Seleccionar Tipo Antigrama")
        $("#tipo_antigrama").focus();
        return
    }
   
    for( var i=1;i<=$("#contar_diagnostico").val();i++)
    {
        if(antigrama == $("#idantibiograma"+i).val() && tipoantig == $("#idtipoantibiograma"+i).val())
        {
            alert("El Tipo de antigrama ya Fue Agregado")
            $("#antibiograma").val(0)
            $("#tipo_antigrama").val(0)
            return
        }
    }

    count_diagn++;
    $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_diagn+"'>"+
        "<td>"+count_diagn+" </td>"+
        "<td><input type='hidden' name='idantibiograma"+count_diagn+"' id='idantibiograma"+count_diagn+"' value='"+antigrama+"' />"+nombantig+"</td>"+
        "<td><input type='hidden' name='idtipoantibiograma"+count_diagn+"' id='idtipoantibiograma"+count_diagn+"' value='"+tipoantig+"' />"+nombtpant+"</td>"+
        "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_diagn+")' title='Borrar Registro' /></td>"+
        "</tr>")


    $("#antibiograma").val(0)
    $("#tipo_antigrama").val(0)
    $("#contar_diagnostico").val(count_diagn)
	cuentaItem()
  
}

function quitar_diagnostico(idx)
{
	$("#itemdiagnostico"+idx).remove();
	cuentaItem();
}

function cuentaItem(){
	var diag=0;
	$("#contar_diagnostico2").val(diag);
	for( var i=1;i<=$("#contar_diagnostico").val();i++)
    {
        if(typeof($("#idantibiograma"+i).val())!= 'undefined' )
        {
           diag++;
		   $("#contar_diagnostico2").val(diag);
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
	
		$("#idestablesolicita").val(idestab)
        $("#nombre_establecimiento").val(nombre)
        $("#idingresomuestra").val(tip)
		tipo_atencion(tip)
	 	tipo_exam(tip)
		}
	});	
}


function tipo_resultado(id)
{
	
	var idres = $("#idresulta").val();
	var idsecre = $("#codigo").val();
	var rcuento = $("#rcuento").val();
	
	if (id==2){
		$('#div-antibiograma').show();
		$.ajax({
         type: "POST",
         url: carpeta+"urologia_antibiograma.php",
		 data: "cod="+idres+"&idsecre="+idsecre+"&rcuent="+rcuento,
         success: function(data) {
             $("#div-antibiograma").html(data)
			}
		});
	} else {
		$('#div-antibiograma').empty();
	}
     
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
 
function mayuscula(e) 
{
	e.value = e.value.toUpperCase();
}