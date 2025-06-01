var carpeta = "../admin/usuarios/";
var aja2 = "../ajax/";

function mostrarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}

function ocultarVentana()
{
	$('#userModal').modal('hide'); // Desactivamos el backdrop del contenedor
}

function cargar_form(op,cod)
{

	if (op==3){
		$.ajax({
            type: "POST",
            url: carpeta+"form-clave.php",
            data: "op="+op+"&cod="+cod,
            success: function(data) {
            	mostrarVentana();
				$('#modal-body').html(data)
		    }
       });
	} 
		else { 
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

}
	
function validar_form()
{

	var descripcion= $("#nombres").val()
	if(descripcion=="")

	{
		alert("El Nombre del Usuario no puede ser NULO")
		return false
	}
	var log= $("#login").val()
	if(log=="")
	{
		alert("El Login del Usuario no puede ser NULO")
		return false
	}

	var pas= $("#contra").val()
	if(pas=="")
	{
		alert("La Contraseña del Usuario no puede ser NULO")
		return false
	}

	var perf= $("#idperfil").val()
	if(perf==0)
	{
		alert("Seleccione el Perfil")
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
    $(".upload-msg").html("Guardando... Por favor espere, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");

    $.ajax({
            type: "POST",
            url: carpeta+"guardar.php",
            data: $("#user_form").serialize(),
				success: function(data) {
			//	alert(data)
            	regresar_index(carpeta)
            }
       });
	ocultarVentana();
}

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

/*
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
*/


function recarga2(dir){
    $(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "destroy":true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [[ 1, "desc" ]],
        "ajax": dir+"registros.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			 if ( aData[7] == "INACTIVO")
				{
					$('td', nRow).css('color', 'red');
				}
			}
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