var count=0;
var carpeta = "../catalogo/materiales/";

function mostrarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor
   //ventana.style.display = 'block'; // Y lo hacemos visible
}
function imprimir(nro)
{
	var server = window.location.hostname;
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	//var urlprint = "../laboratorio/aedes/imprimir.php?fechainicial=2020-03-06&fechafinal=2020-03-06&embedded=true";
	var urlprint = carpeta+"imprimir.php?idpc="+nro+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
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

function validar_form()
{
	var descripcion= $("#descripcion").val()
	if(descripcion=="")
	{
		alert("La Descripcion no puede ser NULA")
		return false
	}
	var ciiu= $("#ciiu").val()
	if(ciiu=="")
	{
		alert("El Codigo CIIU no puede ser NULA")
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
		//	alert(data)
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
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
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

 function tipserv(id)
 {
    var cod= $("#codigo").val()
	$.ajax({
         type: "POST",
         url: carpeta+"tipserv.php",
         data: "idtipse="+id+"&cod="+cod,
         success: function(data) {
             $("#div-estable").html(data)
         }
     });
 }
 
 
function agregar_metod()
{
    var descripciones	=   $("#metodos").val()
		
	if(descripciones=="")
    {
        alert("Descripción de la Metodología no debe ser Nulo!!!")
        $("#metodos").focus();
        return
    }
	
	
    count_metodo++;
    $("#tbmetodologia").append("<tr id='itemmetodologia"+count_metodo+"'>"+
      	"<td>"+count_metodo+"</td>"+
		"<td><input type='hidden' name='descripcion"+count_metodo+"' id='descripcion"+count_metodo+"' value='"+descripciones+"' />"+descripciones+"</td>"+
        "<td  align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_metodo("+count_metodo+")' title='Borrar Registro' /></td>"+
        "</tr>")

	$("#metodos").val("")
	$("#contar_metodo").val(count_metodo);
}

function quitar_metodo(idx)
{
	$("#itemmetodologia"+idx).remove();
	
}


function agregar_mbio()
{
    var descripciones	=   $("#mbiolog").val()
		
	if(descripciones=="")
    {
        alert("Descripción de la Metodología no debe ser Nulo!!!")
        $("#mbiolog").focus();
        return
    }
	
		
    count_muestra++;
    $("#tbmuestras").append("<tr id='itemmuestra"+count_muestra+"'>"+
      	"<td>"+count_muestra+"</td>"+
		"<td><input type='hidden' name='descripcion"+count_muestra+"' id='descripcion"+count_muestra+"' value='"+descripciones+"' />"+descripciones+"</td>"+
        "<td  align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_muestra("+count_muestra+")' title='Borrar Registro' /></td>"+
        "</tr>")

	$("#mbiolog").val("")
	$("#contar_muestra").val(count_muestra);
  
}

function quitar_muestra(idx)
{
	$("#itemmuestra"+idx).remove();
	
}


function agregar_caracter()
{
    var descripciones	=   $("#caracteres").val()
		
	if(descripciones=="")
    {
        alert("Descripción de la Metodología no debe ser Nulo!!!")
        $("#caracteres").focus();
        return
    }
	
	
	
    count_caracter++;
    $("#tbcaracteristicas").append("<tr id='itemcaracteristica"+count_caracter+"'>"+
      	"<td>"+count_caracter+"</td>"+
		"<td><input type='hidden' name='descripcion"+count_caracter+"' id='descripcion"+count_caracter+"' value='"+descripciones+"' />"+descripciones+"</td>"+
        "<td  align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_caracter("+count_caracter+")' title='Borrar Registro' /></td>"+
        "</tr>")

	$("#caracteres").val("")
	$("#contar_caracteres").val(count_caracter);
  
}

function quitar_caracter(idx)
{
	$("#itemcaracteristica"+idx).remove();
}
