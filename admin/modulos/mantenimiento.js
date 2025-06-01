var count=0;
var carpeta = "../admin/modulos/";

function mostrarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor
   //ventana.style.display = 'block'; // Y lo hacemos visible
}

function ocultarVentana()
{
	$('#userModal').modal('hide'); // Desactivamos el backdrop del contenedor
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

function validar_form()
{
	var descripcion= $("#descripcion").val()
	if(descripcion=="")
	{
		alert("La Descripcion del Modulo no puede ser NULO")
		return false
	}
	var ur= $("#url").val()
	if(ur=="")
	{
		alert("La Url no puede ser NULO")
		return false
	}
	var ur= $("#idpadre_primario").val()
	if(ur=="")
	{
		alert("Seleccione el Menu Primario")
		return false
	}
        var ur= $("#orden").val()
	if(ur=="")
	{
		alert("Establesca el Orden del Menu")
		return false
	}
	guardar_datos()
	return true
}

function cambiarestado(obj,input)
{
	if(obj.checked)
	{
		$("#"+input).val(1)
		document.getElementById("boton01").className = "btn btn-primary";
		document.getElementById('boton01').innerHTML="Activo";
	}else{
		$("#"+input).val(0)
		document.getElementById('boton01').innerHTML="Inactivo";
		document.getElementById("boton01").className = "btn btn-danger";
	}
}

function guardar_datos()
{
    // $( "#action" ).prop( "disabled", true );
    $('#action').hide();
    $(".upload-msg").html("Guardando... Por favor espere, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");

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

function cambiar_modulos(id,sel)
{
	$.ajax({
            type: "POST",
            url: "../ajax/modulos.php",
            data: "idpadre="+id+"&seleccion="+sel,
            success: function(data) {
            	$("#div-padre").html(data)
            }
       });
}

//funciones de Listar los registros 
function regresar_index(dir) {
	
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
    	"responsive":true, // enable responsive
        "destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": dir+"registros.php"
    	} );
	} );
}
