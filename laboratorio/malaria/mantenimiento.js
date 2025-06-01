
var carpeta = "../laboratorio/malaria/";
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
	var urlprint = carpeta+"imprimir.php?idpc="+nro+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}
function muestras(nro)
{
	// var server = window.location.hostname;
	// var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
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

function contarArray(){
	var items = $("#user_form").serializeArray();
	var totavar = items.length
	$('#itemvar').val(totavar)
	console.log("Total Item: "+$('#itemvar').val());
	
	validar_form()
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
	var fecharecoj	=   $("#feval").val()
	var labeva		=   $("#labeva").val()
	var labeva_text	=   $("#labeva option:selected").html()
	var codle = labeva_text.split('-');
	var codlam		=   $("#clami").val()
    var mtama		=   $("#mtam").val()
	var mtama_text	=   $("#mtam option:selected").html()
	var mubica		=   $("#mubic").val()
	var mubica_text	=   $("#mubic option:selected").html()
    var mcalid		=   $("#mcali").val()
    var mcalid_text	=   $("#mcali option:selected").html()
	var cdesh		=   $("#cdesh").val()
	var cdesh_text	=   $("#cdesh option:selected").html()
	var ctono		=   $("#cton").val()
	var ctono_text	=   $("#cton option:selected").html()
    var cpp			=   $("#cpp").val()
	var cpp_text	=   $("#cpp option:selected").html()
    var ftam		=   $("#ftam").val()
	var ftam_text	=   $("#ftam option:selected").html()
    var fubi		=   $("#fubi").val()
    var fubi_text	=   $("#fubi option:selected").html()
	var fext		=   $("#fext").val()
	var fext_text	=   $("#fext option:selected").html()
	var resu		=   $("#resu").val()
	var resu_text	=   $("#resu option:selected").html()
	var espe		=   $("#espe").val()
	var espe_text	=   $("#espe option:selected").html()
	var dens		=   $("#dens").val()
	var dens_text	=   $("#dens option:selected").html()
	var conc		=   $("#conc").val()
	var conc_text	=   $("#conc option:selected").html()
	var desco		=   $("#desco").val()
	var desco_text	=   $("#desco option:selected").html()
	var dcespe		=   $("#dcespe").val()
	var dcespe_text	=   $("#dcespe option:selected").html()
	 
	if(labeva==0)
	{
		alert("Lavoratorio Evaluador no debe ser Null!!")
		$("#labeva").focus();
		return
	}
	
	if(codlam=="")
    {
        alert("Codigo Lamina no debe ser Nulo!!!")
        $("#clami").focus();
        return
    }
	if(mtama==0)
    {
        alert("Tamaño Muestra no debe ser Nulo!!!")
        $("#mtam").focus();
        return
    }
	
	if(mubica==0)
    {
        alert("Ubicación Muestra no debe ser Nulo!!!")
        $("#mubic").focus();
        return
    }
	
	if(mcalid==0)
    {
        alert("Calidad Muestra no debe ser Nulo!!!")
        $("#mcali").focus();
        return
    }
	if(cdesh==0)
    {
        alert("Desh. Coloración no debe ser Nulo!!!")
        $("#cdesh").focus();
        return
    }
	if(ctono==0)
    {
        alert("Tono Color no debe ser Nulo!!!")
        $("#cton").focus();
        return
    }
	if(cpp==0)
    {
        alert("PP Color no debe ser Nulo!!!")
        $("#cpp").focus();
        return
    }
	
	if(ftam==0)
    {
        alert("Frotis Tamaño no debe ser Nulo!!!")
        $("#ftam").focus();
        return
    }
	
	if(fubi==0)
    {
        alert("Frotis Ubicación de Foco no debe ser Nulo!!!")
        $("#fubi").focus();
        return
    }
	if(fext==0)
    {
        alert("Frotis Exten de Foco no debe ser Nulo!!!")
        $("#fext").focus();
        return
    }
	if(resu==0)
    {
        alert("Concordacia de Resultado no debe ser Nulo!!!")
        $("#resu").focus();
        return
    }
	if(espe==0)
    {
        alert("Especie no debe ser Nulo!!!")
        $("#espe").focus();
        return
    }
	if(dens==0)
    {
        alert("Densidad no debe ser Nulo!!!")
        $("#dens").focus();
        return
    }
	if(conc==0)
    {
        alert("Concordacia no debe ser Nulo!!!")
        $("#conc").focus();
        return
    }
	if(desco==0)
    {
        alert("DesCordacia de Resultado no debe ser Nulo!!!")
        $("#desco").focus();
        return
    }
	if(dcespe==0)
    {
        alert("Descondancia de Especie no debe ser Nulo!!!")
        $("#dcespe").focus();
        return
    }
	
    count_enf++;
    $("#tbmuestras").append("<tr id='itemmuestra"+count_enf+"'>"+
      	"<td>"+count_enf+"</td>"+
		"<td><input type='hidden' name='fechaevalua"+count_enf+"' id='fechaevalua"+count_enf+"' value='"+fecharecoj+"' />"+fecharecoj+"</td>"+
		"<td><input type='hidden' name='codlab"+count_enf+"' id='codlab"+count_enf+"' value='"+labeva+"' />"+codle[0]+"</td>"+
		"<td><input type='hidden' name='codlam"+count_enf+"' id='codlam"+count_enf+"' value='"+codlam+"' />"+codlam+"</td>"+
		"<td><input type='hidden' name='mtama"+count_enf+"' id='mtama"+count_enf+"' value='"+mtama+"' />"+mtama_text+"</td>"+
		"<td><input type='hidden' name='mubica"+count_enf+"' id='mubica"+count_enf+"' value='"+mubica+"' />"+mubica_text+"</td>"+
        "<td><input type='hidden' name='mcalid"+count_enf+"' id='mcalid"+count_enf+"' value='"+mcalid+"' />"+mcalid_text+"</td>"+
		"<td><input type='hidden' name='cdesh"+count_enf+"' id='cdesh"+count_enf+"' value='"+cdesh+"' />"+cdesh_text+"</td>"+
		"<td><input type='hidden' name='ctono"+count_enf+"' id='ctono"+count_enf+"' value='"+ctono+"' />"+ctono_text+"</td>"+
		"<td><input type='hidden' name='cpp"+count_enf+"' id='cpp"+count_enf+"' value='"+cpp+"' />"+cpp_text+"</td>"+
		"<td><input type='hidden' name='ftam"+count_enf+"' id='ftam"+count_enf+"' value='"+ftam+"' />"+ftam_text+"</td>"+
		"<td><input type='hidden' name='fubi"+count_enf+"' id='fubi"+count_enf+"' value='"+fubi+"' />"+fubi_text+"</td>"+
        "<td ><input type='hidden' name='fext"+count_enf+"' id='fext"+count_enf+"' value='"+fext+"' />"+fext_text+"</td>"+
		"<td ><input type='hidden' name='resu"+count_enf+"' id='resu"+count_enf+"' value='"+resu+"' />"+resu_text+"</td>"+
        "<td ><input type='hidden' name='espe"+count_enf+"' id='espe"+count_enf+"' value='"+espe+"' />"+espe_text+"</td>"+
        "<td ><input type='hidden' name='dens"+count_enf+"' id='dens"+count_enf+"' value='"+dens+"' />"+dens_text+"</td>"+
		"<td ><input type='hidden' name='conc"+count_enf+"' id='conc"+count_enf+"' value='"+conc+"' />"+conc_text+"</td>"+
        "<td ><input type='hidden' name='desco"+count_enf+"' id='desco"+count_enf+"' value='"+desco+"' />"+desco_text+"</td>"+
		"<td ><input type='hidden' name='dcespe"+count_enf+"' id='dcespe"+count_enf+"' value='"+dcespe+"' />"+dcespe_text+"</td>"+
       
	   "<td class='bg-success align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_aedes("+count_enf+")' title='Borrar Registro' /></td>"+
        "</tr>")

	//$("#feval").val("")
	//$("#labeva").val(0)
	$("#clami").val("")
    $("#mtam").val(0)
	$("#mubic").val(0)
	$("#mcali").val(0)
    $("#cdesh").val(0)
	$("#cton").val(0)
	$("#cpp").val(0)
	$("#ftam").val(0)
	$("#fubi").val(0)
    $("#fext").val(0)
	$("#resu").val(0)
	$("#espe").val(0)
	$("#dens").val(0)
	$("#conc").val(0)
	$("#desco").val(0)
	$("#dcespe").val(0)
	
		
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

function excel_ficha(id)
{
    window.open(carpeta+"excel.php?id="+id)
    window.close()
    return true
}
