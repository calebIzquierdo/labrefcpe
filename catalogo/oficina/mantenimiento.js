var carpeta = "../catalogo/oficina/";

function mostrarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}

function ocultarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor
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
		alert("La Descripcion no puede ser NULA")
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
	$.ajax({
            type: "POST",
            url: carpeta+"guardar.php",
            data: $("#user_form").serialize(),
            success: function(data) {
            regresar_index(carpeta)
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
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
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
