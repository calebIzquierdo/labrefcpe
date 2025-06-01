$(document).ready(function() {	
	$('.paginate').live('click', function(){
		
		$('#content').html('<div class="loading"><img src="../../img/avance.gif" /></div>');

		var page = $(this).attr('data');		
		var dataString = 'page='+page;
		
		$.ajax({
            type: "GET",
            url: "paginacion.php",
            data: dataString,
            success: function(data) {
				$('#content').fadeIn(1000).html(data);
            }
        });
    });              
});
function BuscarG(Op)
{
	var Valor = document.getElementById('valor').value
	var Op2 = ''
	if (Op!=0)
	{
		Op2 = '&Op=' + Op;
	}
	location.href='index.php?valor=' + Valor + '&pagina=' + Pagina + Op2;
}
function Buscar(Op)
{
	BuscarG(Op);
}
function mostrarVentana()
{
	document.getElementById("blokea").style.display = "block";
    var ventana = document.getElementById('miVentana'); // Accedemos al contenedor
    ventana.style.marginTop = "100px"; // Definimos su posici�n vertical. La ponemos fija para simplificar el c�digo
    ventana.style.marginLeft = ((document.body.clientWidth-390) / 2) +  "px"; // Definimos su posici�n horizontal
    ventana.style.display = 'block'; // Y lo hacemos visible
}

function ocultarVentana()
{
	document.getElementById("blokea").style.display = "none";
    var ventana = document.getElementById('miVentana'); // Accedemos al contenedor
    ventana.style.display = 'none'; // Y lo hacemos invisible
}
function cargar_form(op,cod)
{
	$.ajax({
            type: "POST",
            url: "form-mantenimiento.php",
            data: "op="+op+"&cod="+cod,
            success: function(data) {
            	mostrarVentana();
				$('#formM').html(data)
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
	}else{
		$("#"+input).val(0)
	}
}
function guardar_datos()
{
	$.ajax({
            type: "POST",
            url: "guardar.php",
            data: $("#frmmantenimiento").serialize(),
            success: function(data) {
            	location.href='index.php'
            }
       });
}
