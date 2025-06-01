var count=0;
var carpeta = "../catalogo/cliente/";
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
	$.ajax({
            type: "POST",
            url: carpeta+"guardar.php",
            data: $("#user_form").serialize(),
            success: function(data) {
		//		alert(data)
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

	// Agregado buscar DNI RENIEC -14/06/2021 --> 
function buscar_dni(cadena){
		// cadena = 01023455
		
		$.ajax({
		type: 'POST',
	//	url: carpeta+ "consultarDNI.php",
		url: "http://181.176.170.149/referencias/catalogo/paciente/consultarDNI.php",
		data: 'cadena=' + cadena,
	    beforeSend: function () {
			$("#resultado").html('<img src="/referencias/images/loader.gif" border="1" width="50" height="50"> Procesando, espere por favor.');
			},
			success: function(respuesta) {
			object = JSON.parse(respuesta);
						
	     if (object.resultado == 'Consulta realizada correctamente') {
				$("#iddocumento option[value=1]").attr('selected', true);
				$('#nrodocumento').val(object.dni);
				$('#p_dni').val(object.dni);
				$('#p_foto').attr("src",object.foto);
				$('#p_nombres').text(object.nombres);
				$('#p_apellidos').text(object.apellidos);
				$('#p_direccion').text(object.direccion);
				$('#nombres').val(object.nombres);
				$('#apellidos').val(object.apellidos);
				$('#direccion').val(object.direccion);
				$('#hclinica').val(object.dni);	
				$('#p_estadoconsultareniec').text("CONEXION EXITOSA CON RENIEC");
			}
			else{
				$('#nrodocumento').val(object.dni2);
				$('#p_estadoconsultareniec').text(object.resultado + '-' + "REGISTRA MANUALMENTE");
			}

	if (object.errorresultado == '0000') 
	{
		if (object.estado_sis == 'ACTIVO') 
		{
			var id = 1;
			$("#idseguro option[value=1]").attr('selected', true);
			$('#modalidadsis').val(object.TipoSeguroPaciente);
			$('#nsis').val(object.ContratoNumero);
			
			var id = object.codRenaesmostrar;	
			estalecimientorefrencia(id); 
			$('#p_estadoseguro').text('SIS-ACTIVO');	
		  
			if (object.Sexo == 'VARON') {
				$("#idtiposexo option[value=1]").attr('selected', true);
			}
			if (object.Sexo == 'MUJER') {
				$("#idtiposexo option[value=2]").attr('selected', true);
			}
		}else 
			{
			$('#p_estadoseguro').text('PACIENTE SIN SIS');	
			$('#modalidadsis').val("");
			$("#idorigen_establecimiento").val("21");
		    $("#nombre_establecimiento").val("00006918 - HOSPITAL II-2 TARAPOTO / NO APLICA / NO APLICA");
			$('#nsis').val("");
			}
	}else
		{  
		   if (object.errorresultado == '1001') {
			$('#p_estadoseguro').text('NO SE ENCONTRO AFILIACION PARA EL DNI CONSULTADO ');	
			$('#modalidadsis').val("");
			$('#lugarreferencia').val("");
			$("#idorigen_establecimiento").val("21");
		     $("#nombre_establecimiento").val("00006918 - HOSPITAL II-2 TARAPOTO / NO APLICA / NO APLICA");
			$('#nsis').val("");	  
			
		   }else
			   {
				$('#p_estadoseguro').text('HAY UN ERROR EN LA CONEXION SIS-MINSA, REGISTRA MANUALMENTE');	
				$('#modalidadsis').val("");
				
				 $("#idorigen_establecimiento").val("21");
				 $("#nombre_establecimiento").val("00006918 - HOSPITAL II-2 TARAPOTO / NO APLICA / NO APLICA");
				 
				$('#nsis').val("");	    
			   }
		}
	},
	complete:function(){
	   $("#resultado").html("");
	}
	 
	});
}
// ---------------
