	$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})

	/*
	Para usar un tooltip especifico hacer de la siguiente manera
	<input type="text" rel="txtTooltip" title="**Escribir el mensaje a mostrar**" data-toggle="tooltip" data-placement="bottom">
	*/
	$(document).ready(function() {
	$('input[rel="txtTooltip"]').tooltip();
	});
	