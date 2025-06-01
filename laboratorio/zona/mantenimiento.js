var count=0;
var carpeta = "../laboratorio/zona/";
var aja2 = "../ajax/";

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
	ocultarVentana();
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
    	"responsive":true,
    	"destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": dir+"registros.php"
    	} );
	} );
}


function cargar_red(cod,idred)
{
	$.ajax({
		type: "POST",
		url: aja2+"red.php",
		data: "codi="+cod+"&red="+idred,
		success: function(data) {
			$("#div-red").html(data)
		}
	});
}

function cargar_microred(cod,idmicro)
{
    $.ajax({
            type: "POST",
            url: aja2+"microred.php",
            data: "codi="+cod+"&microred="+idmicro,
            success: function(data) {
            $("#div-microred").html(data)
            }
       });
	 //  cargar_estable()

}

function cargar_estable(cod,estable)
{
	$.ajax({
            type: "POST",
            url: aja2+"establecimiento.php",
            data: "microred="+cod+"&estable="+estable,
            success: function(data) {
            $("#div-establecimiento").html(data)
            }
       });
}
