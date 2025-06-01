$(document).ready(function() {
$(".Contenido").hide(); //Para ocultar los DIV's con contenido
$("ul.tabs li:first").addClass("active").show(); //Activamos el primer TAB
$(".Contenido:first").show(); //Muestra el contenido respectivo al primer TAB
 
//Al clickar sobre los Tabs
$("ul.tabs li").click(function() {
$("ul.tabs li").removeClass("active"); //Anula todas las selecciones
$(this).addClass("active"); //Asigna la clase Active al TAB Seleccionado
$(".Contenido").hide(); //Esconde todo el contenido de la tab
var activeTab = $(this).find("a").attr("href"); //Ubica los valores HREF y A para enlazarlos y activarlos
$(activeTab).fadeIn(); //Habilita efecto Fade en la transición de contenidos
return false;
});
});