var count=0;
var carpeta = "../admin/accesos/";

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
	var ciiu= $("#ciiu").val()
	if(ciiu=="")
	{
		alert("El codigo no debe ser NULA")
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
	ocultarVentana();
}

function buscar_modulos()
{
	var ventana=window.open("../lista/modulos/", 'Buscar_Productor', 'width=600,height=700,resizable=no, scrollbars=yes, status=yes,location=yes');
	ventana.focus();
}

function recibir(id,nombre){
	$("#idmodulos").val(id);
	$("#modulos").val(nombre);
	agregar_modulos();
}
function agregar_modulos()
{
	var idm = $("#idmodulos").val()
    var mod = $("#modulos").val()

	if(idm =="")
	{
		alert("Por favor seleccione un modulos para continuar... ")
        return
	}

	for( var i=1;i<=$("#contador_mod").val();i++)
        {
            if(idm == $("#idmodulo"+i).val() )
            {
               alert("El Tipo de Modulo ya Fue Agregado")
			   var idm = $("#idmodulos").val("")
				var mod = $("#modulos").val("")
               return
            }
        }

	 count++;
        $("#tbmodulos").append("<tr id='itemM"+count+"' >"+
				           
				           "<td><input type='hidden' id='idmodulo"+count+"' name='idmodulo"+count+"' value='"+idm+"' />"+idm+"</td>"+
						   "<td><input type='hidden' id='modulo"+count+"' name='modulo"+count+"' value='"+mod+"' />"+mod+"</td>"+
                           "<td align='center' ><img src='../img/cancel.png' onclick='eliminar_row("+count+")' title='Eliminar Registro' style='cursor:pointer' /></td>"+
                           "</tr>")
                       
      $("#contador_mod").val(count)
	  $("#modulos").val("")
    $("#idmodulos").val("")
  
  
}

function eliminar_row(idx)
{
    $("#itemM"+idx).remove()
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
        "destroy":true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": dir+"registros.php"
    	} );
	} );
}
