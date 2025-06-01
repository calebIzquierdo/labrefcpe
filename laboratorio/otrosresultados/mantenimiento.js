
var carpeta = "../laboratorio/otrosresultados/";
var aja2 =  "../../ajax/";

var count_result = 0;

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
	var urlprint = "../laboratorio/otrosresultados/imprimir.php?nromovimiento="+nro+"&embedded=true";
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
			$('#modal-body').html(data);

            $("#text-muestra").prop('disabled', false);
            $("#btn-muestra").prop('disabled', false);
        }
    });
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

function validar_form()
{
    var idingresomuestra = $("#idingresomuestra_view").val();
    var idusuario = $("#idusuario_view").val();
    var nombreusuario = $("#nombre_usuario_view").val();
    var idestablecimiento = $("#idestablecimiento_view").val();
    var idcliente = $("#idcliente_view").val();
    var edad = $("#edad_view").val();
    var sexo = $("#sexo_view").val();
    var idpersonal = $("#idpersonal_view").val();
    var enfermedad = $("#enfermedad_view").val();
    var fechareg = $("#fechareg_view").val();
    var fecharecepcion = $("#fecha_recepcion_view").val();
    var observaciones = $("#observacion_examen_view").val();

    if($('#edad_view').val() == "")
    {
        alert("Debe ingesar la edad del paciente!!!")
        $("#edad_view").focus();
        return
    }
    
	if($('#sexo_view').val() == 0)
    {
        alert("Debe seleccionar el sexo del paciente!!!")
        $("#sexo_view").focus();
        return
    }
    
	if($('#enfermedad_view').val() == 0)
    {
        alert("Debe ingresar la enfermedad!!!")
        $("#enfermedad_view").focus();
        return
    }
    
	if($('#fechareg_view').val() == 0)
    {
        alert("Debe seleccionar le fecha de registro!!!")
        $("#fechareg_view").focus();
        return
    }
    
	if($('#fecha_recepcion_view').val() == 0)
    {
        alert("Debe seleccionar le fecha de recepcion!!!")
        $("#fecha_recepcion_view").focus();
        return
    }
	
	guardar_datos();
	return true
	
}

function guardar_datos()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: $("#user_form").serialize(),
		success: function(data) {
            $(".upload-msg").html('');

            ocultarVentana();
            regresar_index(carpeta)

            count_result = 0;
        }
    });
}

function validar_resultado() {
    var count = $('#idtipo_examen_view').val();
    var idexamen = $('#idtipo_examen_view').val();
    var fecharegistro = $('#fecharegistro_view').val();
    var valores = $('#valores_examen_view').val();
    var resultados = $('#resultado_examen_view').val();

    var id = $("#idotrosresultadosdet_view").val();
    var idotrosresultados = $('#idingresomuestra_view').val();

    var examen = $('select[id="idtipo_examen_view"] option:selected').text();

    if($('#idtipo_examen_view').val() == "")
    {
        alert("Debe seleccionar un examen!!!")
        $("#idtipo_examen_view").focus();
        return
    }

    if($('#fecharegistro_view').val() == "")
    {
        alert("Debe ingresar una fecha de registro!!!")
        $("#fecharegistro_view").focus();
        return
    }

    if($('#resultado_examen_view').val() == "")
    {
        alert("Debe ingresar los resultados!!!")
        $("#resultado_examen_view").focus();
        return
    }

    if($('#opcion').val() == "0"){
        $("#tablaresultados").append(
            "<tr id='examenresultado" + count + "'>"+
                "<td>"+
                    "<input type='hidden' name='resultados[" + count_result + "][idexamen]' value='" + idexamen + "' />"+
                    examen+
                "</td>" + "<td>"+
                    "<input type='hidden' name='resultados[" + count_result + "][fecharegistro]' value='" + fecharegistro + "' />"+
                    fecharegistro+
                "</td>" + "<td>"+
                    "<input type='hidden' name='resultados[" + count_result + "][valores]' value='" + valores + "' />"+
                    valores+
                "</td>" + "<td>"+
                    "<input type='hidden' name='resultados[" + count_result + "][resultados]' value='" + resultados + "' />"+
                    resultados+
                "</td>" +
                "<td align='center'>"+
                    "<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_resultado(" + count + ")' title='Quitar Registro' />"+
                "</td>"+
            "</tr>");

        $('#idtipo_examen_view').val("0");
        $('#fecharegistro_view').val("");
        $('#valores_examen_view').val("");
        $('#resultado_examen_view').val("");

        count_result++;
    } else {
        $.ajax({
            type: "POST",
            url: carpeta+"guardar_resultado.php",
            data: "id="+id+"&idotrosresultados="+idotrosresultados+"&idexamen="+idexamen+"&examen="+examen+"&fecharegistro="+fecharegistro+"&valores="+valores+"&resultados="+resultados,
            success: function(data) {
                Resultados(idotrosresultados);

                $("#idotrosresultadosdet_view").val("");
                $('#idtipo_examen_view').val("0");
                $('#fecharegistro_view').val("");
                $('#valores_examen_view').val("");
                $('#resultado_examen_view').val("");
            }
        });
    }

}

function quitar_resultado(id){
    $("#examenresultado"+id).remove();
}

function eliminar_resultado(id, examen, muestra) {

    $.ajax({
		type: "POST",
		url: carpeta+"delete_resultado.php",
		data: "idotrosresultadosdet="+id+"&descripcion="+examen,
		success: function(data) {
            Resultados(muestra);
        }
    });
}

function editar_resultado(id, fecha, examen, valor, result) {

    $("#idotrosresultadosdet_view").val(id);
    $("#idtipo_examen_view").val(examen);
    $("#fecharegistro_view").val(fecha);
    $("#valores_examen_view").val(valor);
    $("#resultado_examen_view").val(result);

    $("#idtipo_examen_view").prop('disabled', true);
    $("#add_resultado").prop('disabled', false);
    $("#cancel_edit").show();
}

function cancelar() {
    $("#idotrosresultadosdet_view").val('');
    $("#idtipo_examen_view").val(0)
    $("#fecharegistro_view").val('');
    $("#valores_examen_view").val('');
    $("#resultado_examen_view").val('');

    $("#add_resultado").prop('disabled', false);
    $("#idtipo_examen_view").prop('disabled', false);
    $("#cancel_edit").hide();
}

function edit_result_list(op, id) {
    $.ajax({
		type: "POST",
		url: carpeta+"form-mantenimiento.php",
		data: "op="+op+"&cod="+id,
		success: function(data) {
			mostrarVentana();
			$('#modal-body').html(data);

            $("#text-muestra").prop('disabled', true);
            $("#btn-muestra").prop('disabled', true);

            Muestra(id);
        }
    });
}

function buscar_medico(){
    objindex="Personal"
    var ventana=window.open("../lista/personal/", 'Personal', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function recibir(id,nombre,coddiad)
{
    if(objindex=="Personal"){
        $("#idpersonal_view").val(id);
        $("#medico_view").val(nombre);
    }
}
