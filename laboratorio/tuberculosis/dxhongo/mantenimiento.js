
var carpeta = "../laboratorio/tuberculosis/dxhongo/";
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
	var urlprint = "../laboratorio/tuberculosis/dxhongo/imprimir.php?nromovimiento="+nro+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}

function cargar_form(op,cod)
{
	if(op!=3)
	{
		$.ajax({
			type: "POST",
			url: carpeta+"form-mantenimiento.php",
			data: "op="+op+"&cod="+cod,
			success: function(data) {
				mostrarVentana();
				$('#modal-body').html(data)
					$('#pills-profile-tab').remove();
					$('#profile').remove();
			}
		});
	}
	else {
		$.ajax({
        type: "POST",
        url: carpeta+"form-resultado.php",
        data: "op="+op+"&cod="+cod,
        success: function(data) {
            mostrarVentana();
            $('#modal-body').html(data)
		}
    });
	}
}

/*
function showStuff(id){
	$('#tabs1').empty();
	$('#tab2').show();
}
*/

function validar_form()
{
    if($('#codlabref').val()=="")
    {
        alert("Debe Ingresar Codigo Laboratorio")
        $("#codlabref").focus();
        return
    }
    if($('#codbarra').val()=="")
    {
        alert("Debe Ingresar Codigo de Barra")
        $("#codbarra").focus();
        return
    }

    if($('#idestablesolicita').val()=="")
    {
        alert("Debe Seleccionar Laboratorio Solicitante ")
        $("#nombre_establecimiento").focus();
        return
    }
	if($('#idpaciente').val()=="")
    {
        alert("Debe Seleccionar el Paciente ")
        $("#idpaciente").focus();
        return
    }
    if($('#idtipomuestra').val()=="")
    {
        alert("Debe Seleccionar tipo de Muestra entregada")
        $("#idtipomuestra").focus();
        return
    }
	if($('#idmedicosolicitante').val()=="0")
    {
        alert("Debe Seleccionar Medico solicita del Examen ")
        $("#idpersonal").focus();
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
    var ventana=window.open("../lista/establecimiento/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function buscar_paciente()
{
	objindex="Pacientes"
	var ventana=window.open("../lista/pacientes/", 'Pacientes', 'width=1020,height=700,resizable=no, scrollbars=yes, status=yes,location=yes');
	ventana.focus();
}


function imprimir_detalles(idpc)
{
    var ventana=window.open(carpeta+"imprimir.php?idpc="+idpc, 'Imprimir Detalle del Equipo', 'width=800,height=600,resizable=no, scrollbars=yes, status=yes,location=yes'); 
    ventana.focus();
   
}

function recibir(id,nombre,coddiad)
{

    if(objindex=="Diagnostico")
    {
        $("#diagnostico").val(id)
        $("#nombre_diagnostico").val(coddiad+" - "+nombre)
        $("#codigo_diagnostico").val(coddiad)
        $("#only_diagnostico").val(nombre)
      //  agregar_diagnostico()
    }

   if(objindex=="Pacientes")
    {
        $("#idpaciente").val(id)
        $("#nombre_paciente").val(coddiad+" - "+nombre)
        CalcularEdad(id)
    }

    if(objindex=="Establecimiento")
    {
        $("#idestablesolicita").val(id)
        $("#nombre_establecimiento").val(nombre+" - "+coddiad)
    }

}



