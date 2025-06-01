/* Coeminza el script del Reloj */
 
function fechahora(){ 
 
 

var Hoy = new Date();
var Anio = Hoy.getFullYear();
var dia =Hoy.getDate();
var mes=Hoy.getMonth();

if(dia<=9)
dia='0'+dia;
if(mes<=9)
mes='0'+(mes+1);

//var Fecha =  Dia[Hoy.getDay()] + ", " + Hoy.getDate() + " de " + Mes[Hoy.getMonth()] + " de " + Anio + ", a las ";

var Fecha =  dia + "/" + mes + "/" + Anio ;
 
/* Capturamos una celda para mostrar el Reloj */
$('#fecha').val(Fecha);


/* Indicamos que nos refresque el Reloj cada 1 segundo */

}

function hora(){
	/* Capturamos la Hora, los minutos y los segundos */
marcacion = new Date() 
 
/* Capturamos la Hora */
Hora = marcacion.getHours() 
 
/* Capturamos los Minutos */
Minutos = marcacion.getMinutes() 
 
/* Capturamos los Segundos */
Segundos = marcacion.getSeconds() 
 
/* Si la Hora, los Minutos o los Segundos
Son Menores o igual a 9, le añadimos un 0 */
var AMPM='a.m.';
if(Hora>12){
Hora=Hora-12;
AMPM='p.m.';
}
 
if (Hora<=9)
Hora = "0" + Hora
 
if (Minutos<=9)
Minutos = "0" + Minutos
 
if (Segundos<=9)
Segundos = "0" + Segundos

$('#hora2').val(Hora+':'+Minutos+':'+Segundos+' '+AMPM);
	   
setTimeout("hora()",500);
}