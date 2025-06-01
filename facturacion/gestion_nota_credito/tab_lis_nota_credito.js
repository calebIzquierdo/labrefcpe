var count=0;
var carpeta = "../facturacion/gestion_nota_credito/";
var aja2 = "../ajax/";

function mostrarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor
   //ventana.style.display = 'block'; // Y lo hacemos visible
}

function ocultarVentana()
{
	$('#userModal').modal('hide'); // Desactivamos el backdrop del contenedor
    //ventana.style.display = 'none'; // Y lo hacemos invisible
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
		alert("El campo Nombre no debe ser Vacio")
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

function cargar_datos_departamentoA(val,seleccion,opc)
{
		cargar_datos_provinciaA(2,0,2)
        cargar_datos_distritoA(0,0,2)
        cargar_datos_sectoresA(0,0,2)
        
	$.ajax({
            type: "POST",
            url: aja2+"departamento.php",
            data:"idpais="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=1",
            success: function(data) {
            	$("#div-departamentoB").html(data)
            }
       });
}
function cargar_datos_provinciaA(val,seleccion,opc)
{
	$.ajax({
            type: "POST",
            url: aja2+"provincia.php",
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
            url: aja2+"distrito.php",
            data:"idprovincia="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=1",
            success: function(data) {
            	$("#div-distritoB").html(data)
            }
       });
}
function cargar_datos_sectoresA(val,seleccion,opc)
{
	$.ajax({
            type: "POST",
            url: aja2+"sector.php",
            data:"idsector="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=3",
            success: function(data) {
            	$("#div-sectorB").html(data)
            }
       });
}