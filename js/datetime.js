function startTime(){
		var LaFecha=new Date();
		var Mes=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		var diasem=new Array('Dom','Lun','Mar','Mie.','Jue','Vie','Sab');
		var diasemana=LaFecha.getDay();
		var FechaCompleta="";
		var NumeroDeMes="";
		var AMPM='A.M.';
		NumeroDeMes=LaFecha.getMonth();

		today=new Date();
		h=today.getHours();
		m=today.getMinutes();
		s=today.getSeconds();
		m=checkTime(m);
		s=checkTime(s);
	
	
		if(h>12){
		h=h-12;
		AMPM='P.M.';
		}
		 
		if (h<=9)
		h = "0" + h
		 
		/* if (m<=9)
		m = "0" + m */
		 
		/* if (s<=9)
		s = "0" + s */

		FechaCompleta=""+diasem[diasemana]+" "+LaFecha.getDate()+" de "+Mes[NumeroDeMes]+" del "+LaFecha.getFullYear()+"&nbsp;&nbsp;&nbsp; </br>"+h+':'+m+':'+s+"&nbsp;"+AMPM+"&nbsp;&nbsp;&nbsp;&nbsp;";
		// document.write(FechaCompleta);
		document.getElementById('reloj').innerHTML=FechaCompleta;
		t=setTimeout('startTime()',500);}
		
		function checkTime(i)
		{if (i<10) {i="0" + i;}return i;}
		window.onload=function(){startTime();}	