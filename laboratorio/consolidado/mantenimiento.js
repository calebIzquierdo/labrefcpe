
var carpeta = "../laboratorio/consolidado/";
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

/*
function imprimir(nro)
{
	var server = window.location.hostname;
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	var urlprint = "../laboratorio/consolidado/imprimir.php?fechainicial=2020-03-06&fechafinal=2020-03-06&embedded=true";
	document.all.mostrarpdf.src = urlprint
}
*/

function imprimir_detalles(idpc)
{
	var urlprint = carpeta+"imprimir.php?idpc="+idpc+"&embedded=true";
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
		$('[href="#home"]').tab('show');
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
        return
    }
    if($('#zona').val()=="")
    {
        alert("Zona no debe ser Null!!")
		$("#zona").focusin();
        return
    }
	if($('#local').val()=="")
    {
        alert("Local no debe ser Null")
     	$( "#local" ).focusin()  
				 
        return
    }
	
	
        guardar_datos()

	return true
}


function guardar_datos()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: $("#user_form").serialize(),
        success: function(data) {
     //  alert(data)
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
    var res=confirm("¿Desea Anular la referencia Nª "+nref+" ?")
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

function buscar_distrito()
{
    objindex="Distrito"
    var ventana=window.open("../lista/distrito/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}


function agregar_antigrama()
{
    var zona		=   $("#zona").val()
	var zona_text	=   $("#zona option:selected").html()
	var localid		=   $("#local").val()
	var vprg		=   $("#vprog").val()
    var vins		=   $("#vinspec").val()
    var vposi		=   $("#vipos").val()
	var mrecb		=   $("#mrecbd").val()
	var c1			=   $("#c1insp").val()
	var c1pos		=   $("#c1pos").val()
	var c2			=   $("#c2insp").val()
	var c2pos		=   $("#c2pos").val()
	var c3			=   $("#c3insp").val()
	var c3pos		=   $("#c3pos").val()
	var c4			=   $("#c4insp").val()
	var c4pos		=   $("#c4pos").val()
	var c5			=   $("#c5insp").val()
	var c5pos		=   $("#c5pos").val()
	var c6			=   $("#c6insp").val()
	var c6pos		=   $("#c6pos").val()
	var c7			=   $("#c7insp").val()
	var c7pos		=   $("#c7pos").val()
	var c8			=   $("#c8insp").val()
	var c8pos		=   $("#c8pos").val()
	var inter		=   $("#trata").val()
	var inter_text	=   $("#trata option:selected").html()
	var totainsp	=   $("#trecip").val()
	var totalposit	=   $("#tposit").val()
    

	if(zona==0)
    {
        alert("Zona no debe ser Nulo!!!")
        $("#zona").focus();
        return
    }
	if(inter==0)
    {
        alert("Tipo Intervencion no debe ser Nulo!!!")
        $("#trata").focus();
        return
    }
	
    count_enf++;
    $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_enf+"'>"+
      	"<td>"+count_enf+"</td>"+
		"<td><input type='hidden' name='idzona"+count_enf+"' id='idzona"+count_enf+"' value='"+zona+"' />"+zona_text+"</td>"+
        "<td><input type='hidden' name='localidad"+count_enf+"' id='localidad"+count_enf+"' value='"+localid+"' />"+localid+"</td>"+
		"<td><input type='hidden' name='vprogram"+count_enf+"' id='vprogram"+count_enf+"' value='"+vprg+"' />"+vprg+"</td>"+
		"<td><input type='hidden' name='vinspec"+count_enf+"' id='vinspec"+count_enf+"' value='"+vins+"' />"+vins+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='vpositiva"+count_enf+"' id='vpositiva"+count_enf+"' value='"+vposi+"' />"+vposi+"</td>"+
		"<td><input type='hidden' name='mrecibida"+count_enf+"' id='mrecibida"+count_enf+"' value='"+mrecb+"' />"+mrecb+"</td>"+
        "<td class='bg-info'><input type='hidden' name='c1"+count_enf+"' id='c1"+count_enf+"' value='"+c1+"' />"+c1+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='c1positivo"+count_enf+"' id='c1positivo"+count_enf+"' value='"+c1pos+"' />"+c1pos+"</td>"+
		"<td class='bg-info'><input type='hidden' name='c2"+count_enf+"' id='c2"+count_enf+"' value='"+c2+"' />"+c2+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='c2positivo"+count_enf+"' id='c2positivo"+count_enf+"' value='"+c2pos+"' />"+c2pos+"</td>"+
		"<td class='bg-info'><input type='hidden' name='c3"+count_enf+"' id='c3"+count_enf+"' value='"+c3+"' />"+c3+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='c3positivo"+count_enf+"' id='c3positivo"+count_enf+"' value='"+c3pos+"' />"+c3pos+"</td>"+
		"<td class='bg-info'><input type='hidden' name='c4"+count_enf+"' id='c4"+count_enf+"' value='"+c4+"' />"+c4+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='c4positivo"+count_enf+"' id='c4positivo"+count_enf+"' value='"+c4pos+"' />"+c4pos+"</td>"+
		"<td class='bg-info'><input type='hidden' name='c5"+count_enf+"' id='c5"+count_enf+"' value='"+c5+"' />"+c5+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='c5positivo"+count_enf+"' id='c5positivo"+count_enf+"' value='"+c5pos+"' />"+c5pos+"</td>"+
		"<td class='bg-info'><input type='hidden' name='c6"+count_enf+"' id='c6"+count_enf+"' value='"+c6+"' />"+c6+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='c6positivo"+count_enf+"' id='c6positivo"+count_enf+"' value='"+c6pos+"' />"+c6pos+"</td>"+
		"<td class='bg-info'><input type='hidden' name='c7"+count_enf+"' id='c7"+count_enf+"' value='"+c7+"' />"+c7+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='c7positivo"+count_enf+"' id='c7positivo"+count_enf+"' value='"+c7pos+"' />"+c7pos+"</td>"+
		"<td class='bg-info'><input type='hidden' name='c8"+count_enf+"' id='c8"+count_enf+"' value='"+c8+"' />"+c8+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='c8positivo"+count_enf+"' id='c8positivo"+count_enf+"' value='"+c8pos+"' />"+c8pos+"</td>"+
		"<td class='bg-info'><input type='hidden' name='idtipointervencion"+count_enf+"' id='idtipointervencion"+count_enf+"' value='"+inter+"' />"+inter_text+"</td>"+
		"<td class='bg-info'><input type='hidden' name='rinspeccionado"+count_enf+"' id='rinspeccionado"+count_enf+"' value='"+totainsp+"' />"+totainsp+"</td>"+
        "<td class='bg-danger'><input type='hidden' name='rpositiva"+count_enf+"' id='rpositiva"+count_enf+"' value='"+totalposit+"' />"+totalposit+"</td>"+
        "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_enf+")' title='Borrar Registro' /></td>"+
        "</tr>")

	$("#zona").val(0)
	$("#vprog").val(0)
    $("#vinspec").val(0)
	$("#vipos").val(0)
	$("#mrecbd").val(0)
	$("#c1insp").val(0)
	$("#c1pos").val(0)
	$("#c2insp").val(0)
	$("#c2pos").val(0)
	$("#c3insp").val(0)
	$("#c3pos").val(0)
	$("#c4insp").val(0)
	$("#c4pos").val(0)
	$("#c5insp").val(0)
	$("#c5pos").val(0)
	$("#c6insp").val(0)
	$("#c6pos").val(0)
	$("#c7insp").val(0)
	$("#c7pos").val(0)
	$("#c8insp").val(0)
	$("#c8pos").val(0)
	$("#trata").val(0)
	$("#tposit").val(0)
	$("#trecip").val(0)
	
	
    $("#contar_diagnostico").val(count_enf);

    cuentaItem()
  
}

function quitar_diagnostico(idx)
{
	$("#itemdiagnostico"+idx).remove();
	cuentaItem();
}

function cuentaItem(){
	var diag=0;
	$("#contar_diagnostico2").val(diag);
	for( var i=1;i<=$("#contar_diagnostico").val();i++)
    {
        if(typeof($("#idzona"+i).val())!= 'undefined' )
        {
           diag++;
		   $("#contar_diagnostico2").val(diag);
        }
    }
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
		tipo_atencion(tip)
		tipo_exam(tip)
		tipo_prueba(tip)
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