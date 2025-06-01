var carpeta = "../catalogo/provincia/";
var aja2 =  "../ajax/";

function mostrarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}

function ocultarVentana()
{
	$('#userModal').modal('hide');
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
function guardar_datos()
{
	$( "#action" ).prop( "disabled", true );
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

function validar_form()
{
	if($("#codubigeo").val()=="")
	{
		alert("El Codigo de Ubigeo no puede ser NULO")
		return false
	}
	var categoria= $("#tipoproducto").val()
	if(categoria==0)
	{
		alert("La Categoria del Producto no puede ser NULO")
		return false
	}
	var pais= $("#pais").val()
        if(pais=="0")
	{
		alert("Seleccione el Pais")
		return false
	}
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

function cargar_datos_departamento(val,seleccion,opc)
{
    cargar_datos_provincia(0,0,1)
	$.ajax({
            type: "POST",
            url: aja2+"departamento.php",
            data:"idpais="+val+"&seleccion="+seleccion+"&opcion="+opc,
            success: function(data) {
            	$("#div-departamento").html(data)
            }
       });
}
function cargar_datos_provincia(val,seleccion,opc)
{
	$.ajax({
            type: "POST",
            url: aja2+"provincia.php",
            data:"iddepartamento="+val+"&seleccion="+seleccion+"&opcion="+opc,
            success: function(data) {
            	$("#div-distrito").html(data)
            }
       });
}
/* function cargar_datos_provincia(val,seleccion,opc)
{
	$.ajax({
            type: "POST",
            url: "../../ajax/departamento.php",
            data:"idpais="+val+"&seleccion="+seleccion+"&opcion="+opc,
            success: function(data) {
            	$("#div-departamento").html(data)
            }
       });
} */