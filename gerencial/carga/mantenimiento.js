var carpeta = "../gerencial/carga/";

function procesar(){
		var periodo = $("#aniomes").val()
		var periodo_texto = $("#aniomes option:selected").html();
		if(periodo==0)
		{
			alert("Seleccione el Periodo")
			return false
		}
		$(".upload-msg").fadeIn("slow");
		$(".upload-msg").html("<h2>Procesando indicadores mes de "+periodo_texto+"; Por favor espere... "+"<img src='../img/avance.gif' /></h2>");
		
		$.ajax({
                data:  "periodo="+periodo,
                url:   carpeta+'procesar.php',
                type:  'post',
                success:  function (response) {
					$(".upload-msg").fadeOut("slow");
				alert("Indicadores "+periodo_texto+" actualizados Correctamente")
            }

        });
		
	}
		
	function limpiardata(){

		$.ajax({
              //  data:  "periodo2="+periodo2,
                url:   carpeta+'limpiar_data.php',
                type:  'post',
                success:  function (response) {
					//alert(periodo)
                	alert("Se Limpio las Tablas de Indicadores Correctamente")
                }

        });
	}
	