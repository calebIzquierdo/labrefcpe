var count=0;
var carpeta = "../gerencial/tablero/";

function mostrarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor  
}

function ocultarVentana()
{
	$('#userModal').modal('hide');
}
 
function ver_tablero(id)
{
	$.ajax({
            type: "POST",
            url:   carpeta+'ajax/tablero.php',
            data:  'idindicador='+id,
            success: function(response) {
            	mostrarVentana();
				$('#modal-body').html(response)
            }
       });
}

function actualizar_datos_indicador(id)
 {
 	//var idmes		= $("#mes").val()
 	var idanio		= $("#anio").val()
	var tipref = $("#idtiporeferencia").val()
	var limit = $("#limit").val()
	
	if (id==1 || id==2 || id==7 || id==8 || id==9 || id==10){
	var idestable2	= $("#idesta").val()
	limit = $("#limit").val()
	
	}
	if (id==4 || id==6 ){
	var idestable2	= $("#idestable").val()
	} 
	
	$.ajax({
        data:  'idindicador='+id+"&anio="+idanio+"&idestable="+idestable2+"&tref="+tipref+"&limit="+limit,
        url:   carpeta+'ajax/act-indicador.php',
        type:  'post',
        success:  function (response) {
	       	var r=response.split("|")
		   	$("#vActual").val(r[0])
        	$('#Tendencia').css('background-color',r[1]);
			$("#ValorMes").val(r[2])
        	actualizar_datos_grafico(id)
        	actualizar_datos_tabla(id)
        }});
 }
 function actualizar_datos_mes(id)
 {
 	var idmes		= $("#mes").val()
 	var idanio		= $("#anio").val()

	if (idmes!=0){
	
	$.ajax({
        data:  'idindicador='+id+"&anio="+idanio+"&mes="+idmes,
        url:   carpeta+'ajax/act-mes.php',
        type:  'post',
        success:  function (response) {
			var r=response.split("|")
			$('#Tendencia').css('background-color',r[1]);
			$("#ValorMes").val(r[2])
        }});
	}else {alert("Seleccionar el Mes")}
 }
 
 function actualizar_datos_grafico(id)
 {
 	var A		= $("#anio").val()
	var tipref	= $("#idtiporeferencia").val()
	var limit	= $("#limit").val()
	var idgrafico	= $("#idgrafico").val()
	
	if (id==1 || id==2 || id==7 || id==8 || id==9 || id==10){
	var idestable2	= $("#idesta").val()
	limit = $("#limit").val()
	
	}
	if (id==4 || id==6){
	var idestable2	= $("#idestable").val()
	} 
	
 	$.ajax({
            data:  'idindicador='+id+"&anio="+A+"&idestable="+idestable2+"&tref="+tipref+"&limit="+limit+"&grafico="+idgrafico,
            url:   carpeta+'ajax/grafico.php',
            type:  'post',
            success:  function (response) {
			$("#div-tablero-grafico").html(response)
            }	
    });
 }
 
 function actualizar_datos_tabla(id)
 {
 	var A			= $("#anio").val()
	var tipref = $("#idtiporeferencia").val()
	var limit = $("#limit").val()
	
	if (id==1 || id==2 || id==7 || id==8 || id==9 || id==10){
	var idestable2	= $("#idesta").val()
	limit = $("#limit").val()
	
	}
	if (id==4 || id==6){
	var tipref = $("#idtiporeferencia").val()
	var idestable2	= $("#idestable").val()
	}
 	
 	$.ajax({
            data:  'idindicador='+id+"&anio="+A+"&idestable="+idestable2+"&tref="+tipref+"&limit="+limit,
            url:   carpeta+'ajax/tabla.php',
            type:  'post',
            success:  function (response) {
            	$("#div-tabla-grafico").html(response)
            }	
    });
 }
 
 