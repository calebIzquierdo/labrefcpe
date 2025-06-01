var count=0;
var carpeta = "../catalogo/proveedor/";
var aja2 = "../ajax/";


function mostrarVentana()
{
    var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}

function ocultarVentana()
{
    $('#userModal').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 
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
		alert("El Nombre/Razon Social no puede ser NULO")
		return false
	}
	var idoc= $("#iddocumento").val()
	if(idoc=="")
	{
		alert("Seleccione el Tipo de Dcoumento")
		return false
	}
	var nrdoc= $("#nrodocumento").val()
	if(nrdoc=="")
	{
		alert("El Nro. Documento no puede ser NULO")
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
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: $("#user_form").serialize(),
        success: function(data) {
        // alert(data)
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