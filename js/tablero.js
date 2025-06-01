$(document).ready(function(){
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 600,
		width: 1000,
		modal: true,
		resizable:false,
		buttons: {
			"Retornar": function() {
				$( this ).dialog( "close" );
				
				}
			}
		});
 })
 function ver_tablero(id)
 {
	ajax_tablero(id)
 	$( "#dialog-form" ).dialog( "open" );
 }
 function ajax_tablero(id)
 {
 	$.ajax({
            data:  'idindicador='+id,
            url:   'ajax/tablero.php',
            type:  'post',
            success:  function (response) {
            	$("#div-tablero").html(response)	
            }	
    });
 }
 function actualizar_datos_indicador(id)
 {
 	var idmes		= $("#mes").val()
 	var idanio		= $("#anio").val()
  	var idsector	= $("#sector").val()

 	/* if(idsector==0)
 	{
 		alert("Seleccione combo")
 		return
 	} */
 	 	
	$.ajax({
        data:  'idindicador='+id+"&anio="+idanio+"&mes="+idmes+"&idsector="+idsector,
        url:   'ajax/act-indicador.php',
        type:  'post',
        success:  function (response) {
        	var r=response.split("|")
        	$("#vActual").val(r[0])
        	$('#Tendencia').css('background-color',r[1]);
        	
        	actualizar_datos_grafico(id)
        	actualizar_datos_tabla(id)
        }});
 }
 function actualizar_datos_grafico(id)
 {
 	var A			= $("#anio").val()
 	var idsector	= $("#sector").val()
 	
 	$.ajax({
            data:  'idindicador='+id+"&anio="+A+"&idsector="+idsector,
            // url:   'ajax/grafico-ajax.php',
            url:   'ajax/grafico.php',
            type:  'post',
            success:  function (response) {
				// alert(response)
            	$("#div-tablero-grafico").html(response)
            }	
    });
 }
 function actualizar_datos_tabla(id)
 {
 	var A			= $("#anio").val()
 	var idsector	= $("#sector").val()
 	
 	$.ajax({
            data:  'idindicador='+id+"&anio="+A+"&idsector="+idsector,
            url:   'ajax/tabla.php',
            type:  'post',
            success:  function (response) {
            	$("#div-tabla-grafico").html(response)
            }	
    });
 }