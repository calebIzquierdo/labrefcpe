var count=0;
var carpeta = "../admin/asigserie/";
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
function changeComprobante(){
    console.log("consulta serie");
    $.ajax({
        type: "POST",
        url: carpeta+"filter-serie.php",
        data: "idcomprobante="+$("#idcomprobante").val(),
        success: function(data) {
            $('#idserie').html(data)
            $('#idserie').val(0);
        }
   });
}
function cargar_form(op,cod)
{
    console.log(cod);
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
	var idusuario= $("#idusuario").val()
	if(idusuario==0)
	{
		alert("Seleccione el usuario");
        $("#idusuario").focus();
		return
	}
    var idcomprobante= $("#idcomprobante").val()
	if(idcomprobante==0)
	{
		alert("Seleccione el comprobante");
        $("#idcomprobante").focus();
		return
	}
    var idserie= $("#idserie").val()
	if(idserie==0)
	{
		alert("Seleccione el usuario");
        $("#idserie").focus();
		return
	}
    $.ajax({
            type: "POST",
            url: carpeta+"validate-data.php",
            data: $("#user_form").serialize(),
            success: function(data) {
                dataTem=JSON.parse(data);
                console.log(dataTem);
                if(!dataTem.status){
                    alert(dataTem.msg);
                }else{
                    guardar_datos()    
                }
	            //        
            }
       });
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
	        ocultarVentana()
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
