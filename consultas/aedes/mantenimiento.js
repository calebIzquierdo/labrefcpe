
var carpeta = "../consultas/aedes/";
var aja2 =  "../../ajax/";

function mostrarVentana()
{
    var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}

function ocultarVentana()
{
    $('#userModal').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 
}

function mostrarImpre()
{
   var ventana = document.getElementById('impresiones'); // Accedemos al contenedor
}

function cerrarImpresion()
{
    $('#impresiones').modal('hide');
}

function imprimir(nro)
{
	var server = window.location.hostname;
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	//var urlprint = "../laboratorio/aedes/imprimir.php?fechainicial=2020-03-06&fechafinal=2020-03-06&embedded=true";
	var urlprint = carpeta+"imprimir.php?idpc="+nro+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}
function muestras(nro)
{
	var server = window.location.hostname;
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	//var urlprint = "../laboratorio/aedes/imprimir.php?fechainicial=2020-03-06&fechafinal=2020-03-06&embedded=true";
	var urlprint = carpeta+"muestras.php?idaed="+nro+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
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


function cambiarestado(obj,input)
{
	if(obj.checked)
	{
		$("#"+input).val(2)
		document.getElementById("boton01").className = "btn btn-success";
		document.getElementById('boton01').innerHTML="Examen Completo ";
	}else{
		$("#"+input).val(1)
		document.getElementById('boton01').innerHTML="Examen Pendientes";
		document.getElementById("boton01").className = "btn btn-danger";
	}
}

function validar_form()
{
    if($('#codbarra').val()=="")
    {
        alert("Debe Ingresar Codigo de Barra")
	//	$('[href="#home"]').tab('show');
        $("#codbarra").focusin();
        return
    }

    if($('#idestablesolicita').val()=="")
    {
        alert("Debe Seleccionar Laboratorio Solicitante ")
		$('[href="#home"]').tab('show');
        $("#nombre_establecimiento").focusin();
        return
    }
	if($('#iddistrito').val()=="")
    {
        alert("Debe Seleccionar el Distrito ")
		$("#iddistrito").focusin();
        buscar_distrito()
        return
    }
    
    if($('#idtipointervencion').val()==0)
    {
        alert("Tipo de Intervencion no debe ser Null!!")
		$("#idtipointervencion").focusin();
        return
    }
	/*
	if($('#local').val()=="")
    {
        alert("Local no debe ser Null")
     	$( "#local" ).focusin()  
				 
        return
    }
	
	var summ =0;
	var sihay =0;
		for( var y=1;y<=$("#contar_diagnostico").val();y++)
		{
			var idzona		=   $("#idzona"+y).val()
		
			for( var j=1;j<=$("#contar_recipiente").val();j++)
			{
				var zona_text		=   $("#idzonainsp"+y).html()
				if(idzona != $("#idzonainsp"+j).val()  )
				{
					 console.log("Muestras: "+$("#contar_diagnostico").val() )
					 console.log("Recipientes: "+$("#contar_recipiente").val() )
					 console.log(idzona+" = "+$("#idzonainsp"+j).val() )
					summ++
					 console.log(summ)
					
				}else {
					sihay++
					 console.log("Si registrado: "+sihay)
					 
				}
			}
			
		}
		
		if (summ==sihay){
			alert("La Zona: "+summ+" no se encuentra Registrada en la lista de Muestras")
			return false
		}
		
	*/
        guardar_datos()

	return true
}


function guardar_datos()
{
	//	alert($("#user_form").serialize())
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: $("#user_form").serialize(),
        success: function(data) {
     // alert(data)
        regresar_index(carpeta)
        }
    });
    ocultarVentana()
}

function regresar_index(dir)
{
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
        "destroy":true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "ajax": dir+"registros.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		 if ( aData[12] == "PROCESADO")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[12] == "ANULADO")
			{
				$('td', nRow).css('color', 'red');
			}
		}
        } );
    } );
}

function anular_referencia(id,nref)
{
    var res=confirm("¿Desea Anular la Ficha de Anófeles Nª "+nref+" ?")
    if(res==false)
    {
        return false
    }
	else {
   	    $.ajax({
            type:  "POST",
            url:   carpeta+"anular.php",
            data:  "anulado="+id+"&numero="+nref,
            success: function(data) {
			regresar_index(carpeta)
			}
		});
	}
}

function buscar_establecimiento()
{
    objindex="Establecimiento"
    var ventana=window.open("../lista/muestras/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function buscar_inspector()
{
    objindex="Inspector"
    var ventana=window.open("../lista/inspector/", 'Inspector', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function buscar_distrito()
{
    objindex="Distrito"
    var ventana=window.open("../lista/distrito/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}


function agregar_aedes()
{
    var tipinte		=   $("#idtipointervencion").val()
    var localid		=   $("#local").val()
    var totvivi		=   $("#tvivi").val()
    var vivprog		=   $("#viviprog").val()
    var vivinsp		=   $("#vivinsp").val()
    var zona		=   $("#zona").val()
	var zona_text	=   $("#zona option:selected").html()
	var fecharecoj	=   $("#fecharecojo").val()
	var manza		=   $("#manz").val()
    var family		=   $("#fami").val()
    var direc		=   $("#direcc").val()
    var latit		=   $("#lati").val()
    var longit		=   $("#longi").val()
    var insp		=   $("#inspector").val()
	var insp_text	=   $("#nombre_inspector").val()
	var focos		=   $("#foco").val()
	var focos_text	=   $("#foco option:selected").html()
	var larvas		=   $("#larva").val()
	var pupas		=   $("#pupa").val()
	var adultos		=   $("#adulto").val()
	var aedes		=   $("#aedes").val()
	var otros		=   $("#otros").val()
	 
	if(tipinte==0)
	{
		alert("Tipo de Intervencion no debe ser Null!!")
		$("#idtipointervencion").focus();
		return
	}
	
	if(localid=="")
    {
        alert("Localidad no debe ser Nulo!!!")
        $("#local").focus();
        return
    }
	if(totvivi==0)
    {
        alert("Total Viviendas no debe ser Nulo!!!")
        $("#tvivi").focus();
        return
    }
	/*
	if(vivprog==0)
    {
        alert("Viviendas Programadas no debe ser Nulo!!!")
        $("#viviprog").focus();
        return
    }
	*/
	if(vivinsp==0)
    {
        alert("Viviendas Inspeccionadas no debe ser Nulo!!!")
        $("#vivinsp").focus();
        return
    }
	if(zona==0)
    {
        alert("Zona no debe ser Nulo!!!")
        $("#zona").focus();
        return
    }
	if(manza=="")
    {
        alert("Manzana no debe ser Nulo!!!")
        $("#manz").focus();
        return
    }
	if(family=="")
    {
        alert("Familia no debe ser Nulo!!!")
        $("#fami").focus();
        return
    }
	
	if(insp==0)
    {
        alert("Inspector no debe ser Nulo!!!")
        $("#nombre_inspector").focus();
        return
    }
	
	if(focos==0)
    {
        alert("Tipo de Foco no debe ser Nulo!!!")
        $("#foco").focus();
        return
    }
	
	for( var i=1;i<=$("#contar_muestra").val();i++)
    {
        if(zona == $("#idzona"+i).val() &&  manza== $("#idmanzana"+i).val() && family==$("#familia"+i).val() )
        {
          var res=confirm("La Zona: "+zona_text+", Manzana: "+manza+" y Familia: "+family+", ya se encuentran ingresados, Desea Agregar nuevamente ?")
			if(res==false)
			{
				return false
			}
		}
    }
	
	
	
    count_enf++;
    $("#tbmuestras").append("<tr id='itemmuestra"+count_enf+"'>"+
      	"<td>"+count_enf+"</td>"+
		"<td><input type='hidden' name='localidad"+count_enf+"' id='localidad"+count_enf+"' value='"+localid+"' />"+localid+"</td>"+
		"<td><input type='hidden' name='totalviviendas"+count_enf+"' id='totalviviendas"+count_enf+"' value='"+totvivi+"' />"+totvivi+"</td>"+
		"<td><input type='hidden' name='viviprogramadas"+count_enf+"' id='viviprogramadas"+count_enf+"' value='"+vivprog+"' />"+vivprog+"</td>"+
		"<td><input type='hidden' name='viviinspeccion"+count_enf+"' id='viviinspeccion"+count_enf+"' value='"+vivinsp+"' />"+vivinsp+"</td>"+
		"<td><input type='hidden' name='idzona"+count_enf+"' id='idzona"+count_enf+"' value='"+zona+"' />"+zona_text+"</td>"+
        "<td><input type='hidden' name='fechrecojo"+count_enf+"' id='fechrecojo"+count_enf+"' value='"+fecharecoj+"' />"+fecharecoj+"</td>"+
		"<td><input type='hidden' name='idmanzana"+count_enf+"' id='idmanzana"+count_enf+"' value='"+manza+"' />"+manza+"</td>"+
		"<td><input type='hidden' name='familia"+count_enf+"' id='familia"+count_enf+"' value='"+family+"' />"+family+"</td>"+
		"<td><input type='hidden' name='direccion"+count_enf+"' id='direccion"+count_enf+"' value='"+direc+"' />"+direc+"</td>"+
		"<td><input type='hidden' name='latitud"+count_enf+"' id='latitud"+count_enf+"' value='"+latit+"' />"+latit+"</td>"+
		"<td><input type='hidden' name='longitud"+count_enf+"' id='longitud"+count_enf+"' value='"+longit+"' />"+longit+"</td>"+
        "<td ><input type='hidden' name='idinspector"+count_enf+"' id='idinspector"+count_enf+"' value='"+insp+"' />"+insp_text+"</td>"+
		"<td class='bg-success'><input type='hidden' name='idfoco"+count_enf+"' id='idfoco"+count_enf+"' value='"+focos+"' />"+focos_text+"</td>"+
        "<td class='bg-info'><input type='hidden' name='idlarva"+count_enf+"' id='idlarva"+count_enf+"' value='"+larvas+"' />"+larvas+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='idpupa"+count_enf+"' id='idpupa"+count_enf+"' value='"+pupas+"' />"+pupas+"</td>"+
		"<td class='bg-info'><input type='hidden' name='idadulto"+count_enf+"' id='idadulto"+count_enf+"' value='"+adultos+"' />"+adultos+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='idaedes_a"+count_enf+"' id='idaedes_a"+count_enf+"' value='"+aedes+"' />"+aedes+"</td>"+
		"<td class='bg-info'><input type='hidden' name='idotros"+count_enf+"' id='idotros"+count_enf+"' value='"+otros+"' />"+otros+"</td>"+
       
	   "<td class='bg-success align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_aedes("+count_enf+")' title='Borrar Registro' /></td>"+
        "</tr>")

	//$("#zona").val(0)
	//$("#inspector").val(0)
    //$("#nombre_inspector").val("")
    $("#familia").val("")
	$("#larva").val(0)
	$("#pupa").val(0)
	$("#adulto").val(0)
	$("#aedes").val(0)
	$("#otros").val(0)
	$("#lati").val(0)
	$("#longi").val(0)
		
    $("#contar_muestra").val(count_enf);

    cuentaItem()
  
}

function quitar_aedes(idx)
{
	$("#itemmuestra"+idx).remove();
	cuentaItem();
}

function cuentaItem(){
	var diag=0;
	$("#contar_muestra2").val(diag);
	for( var i=1;i<=$("#contar_muestra").val();i++)
    {
        if(typeof($("#idzona"+i).val())!= 'undefined' )
        {
           diag++;
		   $("#contar_muestra2").val(diag);
        }
    }
}



function agregar_recipientes()
{
    var zona		=   $("#zonains").val()
	var zona_text	=   $("#zonains option:selected").html()
	var insp1		=   $("#c1ins").val()
	var insp2		=   $("#c2ins").val()
	var insp3		=   $("#c3ins").val()
	var insp4		=   $("#c4ins").val()
	var insp5		=   $("#c5ins").val()
	var insp6		=   $("#c6ins").val()
	var insp7		=   $("#c7ins").val()
	var insp8		=   $("#c8ins").val()
	
	
	if(zona==0)
    {
        alert("Zona no debe ser Nulo!!!")
        $("#zonains").focus();
        return
    }
	
	
	for( var i=1;i<=$("#contar_recipiente").val();i++)
    {
        if(zona == $("#idzonainsp"+i).val()  )
        {
          alert("La Zona: "+zona_text+" ya se encuentra Registrada")
		  return
		}
		
    }
	/*
	for( var y=1;y<=$("#contar_diagnostico").val();y++)
		{
			if(zona != $("#idzona"+y).val()  )
			{
				alert($("#contar_diagnostico").val()+": "+zona+" id "+$("#idzona"+y).val())
				alert("La Zona: "+zona_text+" no se encuentra Registrada en la lista de Muestras")
				return
			}
		}
	*/
	
    count_resip++;
    $("#tbresipientes").append("<tr id='itemresipientes"+count_resip+"'>"+
      	"<td>"+count_resip+"</td>"+
		"<td><input type='hidden' name='idzonainsp"+count_resip+"' id='idzonainsp"+count_resip+"' value='"+zona+"' />"+zona_text+"</td>"+
        "<td><input type='hidden' name='c1insp"+count_resip+"' id='c1insp"+count_resip+"' value='"+insp1+"' />"+insp1+"</td>"+
		"<td><input type='hidden' name='c2insp"+count_resip+"' id='c2insp"+count_resip+"' value='"+insp2+"' />"+insp2+"</td>"+
		"<td><input type='hidden' name='c3insp"+count_resip+"' id='c3insp"+count_resip+"' value='"+insp3+"' />"+insp3+"</td>"+
		"<td><input type='hidden' name='c4insp"+count_resip+"' id='c4insp"+count_resip+"' value='"+insp4+"' />"+insp4+"</td>"+
		"<td><input type='hidden' name='c5insp"+count_resip+"' id='c5insp"+count_resip+"' value='"+insp5+"' />"+insp5+"</td>"+
		"<td><input type='hidden' name='c6insp"+count_resip+"' id='c6insp"+count_resip+"' value='"+insp6+"' />"+insp6+"</td>"+
		"<td><input type='hidden' name='c7insp"+count_resip+"' id='c7insp"+count_resip+"' value='"+insp7+"' />"+insp7+"</td>"+
		"<td><input type='hidden' name='c8insp"+count_resip+"' id='c8insp"+count_resip+"' value='"+insp8+"' />"+insp8+"</td>"+
        "<td class='bg-success align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_recipiente("+count_resip+")' title='Borrar Registro' /></td>"+
        "</tr>")

	$("#zonains").val(0)
	$("#c1ins").val(0)
	$("#c2ins").val(0)
	$("#c3ins").val(0)
	$("#c4ins").val(0)
	$("#c5ins").val(0)
	$("#c6ins").val(0)
	$("#c7ins").val(0)
	$("#c8ins").val(0)
		
    $("#contar_recipiente").val(count_resip);

    cuentaRecipiente()
  
}

function quitar_recipiente(idx)
{
	$("#itemresipientes"+idx).remove();
	cuentaRecipiente();
}

function cuentaRecipiente(){
	var diag=0;
	$("#contar_recipiente2").val(diag);
	for( var i=1;i<=$("#contar_recipiente").val();i++)
    {
        if(typeof($("#idzonainsp"+i).val())!= 'undefined' )
        {
           diag++;
		   $("#contar_recipiente2").val(diag);
        }
    }
}

function imprimir_detalles(idpc)
{
    var ventana=window.open(carpeta+"imprimir.php?idpc="+idpc, 'Imprimir Detalle del Equipo', 'width=800,height=600,resizable=no, scrollbars=yes, status=yes,location=yes'); 
    ventana.focus();
   
}

function recibir(id,nombre,coddiad)
{
    if(objindex=="Distrito")
    {
        $("#iddistrito").val(id)
        $("#nombre_distrito").val(nombre)
		var depd = 	coddiad;
		var res = depd.split("|");
		var prov = res[0];
		var dep = res[1];
		
        $("#iddepartamento").val(dep)
        $("#idprovincia").val(prov)
    }

    if(objindex=="Establecimiento")
    {
		var fechas = nombre
		res = fechas.split("-");
		var nfecha = res[0]+"/"+res[1]+"/"+res[2]
		
        $("#idestablesolicita").val(id)
        $("#nombre_establecimiento").val(coddiad)
        $("#fecharecepcion").val(nfecha)
	
    }
	if(objindex=="Inspector")
    {
        $("#inspector").val(id)
        $("#nombre_inspector").val(coddiad+" "+nombre)	
    }
}

function buscar_renaes()
{
	var idbarra = $("#codbarra").val()
		
	$.ajax({
		type: "POST",
		url: carpeta+"procedencia.php",
		data: "idipres="+idbarra,
		success: function(data) {
		
		var	res = data.split("|");
		var idestab = res[0];
		var nombre = res[1];
		var codred = res[2];
		var tip = res[3];
		var codmred = res[4];
		
		if (idestab==0){
			alert("Codigo de Barra no Registrado, Vuelva Ingresar otro Codigo")
			$("#codbarra").val("")
			return
		}
		
		$("#idestablesolicita").val(idestab)
        $("#nombre_establecimiento").val(nombre)
        $("#codred").val(codred)
        $("#codmred").val(codmred)
        $("#idingresomuestra").val(tip)
	//	tipo_atencion(tip)
	//	tipo_exam(tip)
	//	tipo_prueba(tip)
		}
	});
	
}
function tipo_prueba(id)
 {
	var opa = $("#op").val();
	var tor = $("#idingresomuestra").val();
	 
	$.ajax({
         type: "POST",
         url: carpeta+"tipoprueba.php",
		 data: "idtpate="+id+"&op="+opa+"&idtor="+tor,
         success: function(data) {
		//	 alert(data)
		 $("#div-tipprueba").html(data)
		 }
     });
 }
 

function tipo_atencion(id)
 {
	var opa = $("#op").val();
	var tor = $("#codigo").val();
	 
	$.ajax({
         type: "POST",
         url: carpeta+"tipoatencion.php",
		 data: "idtpate="+id+"&op="+opa+"&idtor="+tor,
         success: function(data) {
		 $("#div-seguro").html(data)
		 }
     });
 }
 
 function tipo_exam(id)
 {
	var opa = $("#op").val();
	 
	$.ajax({
         type: "POST",
         url: carpeta+"examenes.php",
		 data: "idtpate="+id+"&op="+opa,
         success: function(data) {
		 $("#div-datos").html(data)
		 }
     });
 }
 
 function mayuscula(e) {
	e.value = e.value.toUpperCase();
}


function solonumeros(evt){
    
    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;
    
    if(code==8) { // backspace.
      return true;
    } else if(code>=48 && code<=57) { // is a number.
      return true;
    } else{ // other keys.
      return false;
    }
}


function suma(idx)
{
	var c1			=   $("#c1"+idx).val()
	var c2			=   $("#c2"+idx).val()
	var c3			=   $("#c3"+idx).val()
	var c4			=   $("#c3"+idx).val()
	var c5			=   $("#c5"+idx).val()
	var c6			=   $("#c6"+idx).val()
	var c7			=   $("#c7"+idx).val()
	var c8			=   $("#c8"+idx).val()
	/*
	var c1pos		=   $("#c1pos").val()
	var c2pos		=   $("#c2pos").val()
	var c3pos		=   $("#c3pos").val()
	var c4pos		=   $("#c4pos").val()
	var c5pos		=   $("#c5pos").val()
	var c6pos		=   $("#c6pos").val()
	var c7pos		=   $("#c7pos").val()
	var c8pos		=   $("#c8pos").val()
	var totalposit	=   parseInt(c1pos)+parseInt(c2pos)+parseInt(c3pos)+parseInt(c4pos)+parseInt(c5pos)+parseInt(c6pos)+parseInt(c7pos)+parseInt(c8pos)
	$("#tposit").val(totalposit)
	
	*/
	
	var totainsp	=   parseInt(c1)+parseInt(c2)+parseInt(c3)+parseInt(c4)+parseInt(c5)+parseInt(c6)+parseInt(c7)+parseInt(c8)
	//alert(totainsp)
	$("#rinspeccionado"+idx).val(totainsp)
	//$("#rinspeccionado"+idx).html(totainsp)
	
}