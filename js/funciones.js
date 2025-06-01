
$(document).ready(function(){
    verlistado()
	
    //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO


})
function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
 $("#contenido").empty().append('<h3 class="">Preparando Consulta, Por favor espere... &nbsp;&nbsp;&nbsp;&nbsp;'+
	'<img src="../../img/ajax-loader2.gif" width="40px" height="40px" /> </h3>');
              var randomnumber=Math.random()*11;
            $.post("registros.php", {
                randomnumber:randomnumber
            }, function(data){
				$("#contenido").html(data);
            });
}
function permite(elEvento, permitidos) {
	var numeros = "0123456789.,";
	var caracteres = " abcdefghijklmn�opqrstuvwxyzABCDEFGHIJKLMN�OPQRSTUVWXYZ-/";
	var numeros_caracteres = numeros + caracteres;
	var teclas_especiales = [8, 37, 39, 46, 13, 9];
	
	  switch(permitidos) {
	    case 'num':
	    permitidos = numeros;
	    break;
	    case 'car':
	    permitidos = caracteres;
	    break;
	    case 'num_car':
	    permitidos = numeros_caracteres;
		alert(permitidos)
	    break;
	}
	var evento = elEvento || window.event;
	var codigoCaracter = evento.charCode || evento.keyCode;
	//alert(codigoCaracter)
	var caracter = String.fromCharCode(codigoCaracter);
	var tecla_especial = false;
	for(var i in teclas_especiales) {
	    if(codigoCaracter == teclas_especiales[i]) {
	    tecla_especial = true;
	    break;
	  }
	}
	
	return permitidos.indexOf(caracter) != -1 || tecla_especial;
}