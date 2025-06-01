var carpeta = "../backup/";

function ejecutar_backup(){
		$.ajax({
		type: 'POST',
		url: carpeta+"backup.php",
		//data: 'cadena=' + cadena,
		success: function(respuesta) {
			//Copiamos el resultado en #mostrar
			$('#mostrar').html(respuesta);
	   		}
		});
	} 

