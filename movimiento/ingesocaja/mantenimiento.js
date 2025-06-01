
var carpeta = "../movimiento/ingesocaja/";
var aja2 =  "../ajax/";

document.getElementById('nombre_establecimiento').readOnly = true; 

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
	//var urlprint = carpeta+"imprimir.php?nromovimiento="+nro+"&embedded=true";
	var urlprint = carpeta+"generar_pdf_comprobante.php?item_pago="+nro+"&pdf_show=1";
	
	document.all.mostrarpdf.src = urlprint
}

function cargar_form(op,cod)
{
	if (op==1){
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
	else {
		$.ajax({
		type: "POST",
		url: carpeta+"exonerado.php",
		data: "op="+op+"&cod="+cod,
		success: function(data) {
			mostrarVentana();
			$('#modal-body').html(data)
			}
		});
	}
}

function validar_form()
{
    var op= $('#op').val();
			
		if($('#idcliente').val()==0 || $('#idcliente').val()==null)
		{
			alert("Cliente no debe ser Nulo!!!")
			$("#idcliente").focus();
			return
		}
		
		if($('#idcomprobante').val()==0)
		{
			alert("Seleccionar Tipo comprobante !!!")
			$("#idcomprobante").focus();
			return
		}
		if($('#idserie').val()==0)
		{
			alert("Seleccionar la serie!!!")
			$("#idserie").focus();
			return
		}
		
		if($('#nrodocumento').val()=="")
		{
			alert("Numero Documento no debe ser Nulo!!")
			$("#nrodocumento").focus();
			return
		}
		if($('#idtipopago').val()==0)
		{
			alert("Tipo de Pago no debe ser Nulo!!!")
			$("#idtipopago").focus();
			return
		}
		if($('#contar_diagnostico2').val()==0)
		{
			alert("Debe tener por lo menos un registro para generar el Comprobante !!!")
		//	$("#contar_diagnostico2").focus();
			return
		}
		console.log($("#idcliente>option:selected").attr("iddocumento"),$("#idserie>option:selected").attr("seriedoc").split('0'));
		if($("#idcliente>option:selected").attr("iddocumento")==1 && ($("#idserie>option:selected").attr("seriedoc").split('0')[0]=="F")){
			alert("Este usuario no puede emitir factura!!!")
			$("#idcomprobante").focus();
			return
		}
	if ($('#idcomprobante').val()==7 )
	{
		if($('#idtipo_exonera').val()==0 )
		{
			alert("Debe seleccionar motivo de exoneración !!!")
			$("#idtipo_exonera").focus();
			return
		}
		if($('#descuento').val()==0 || $('#descuento').val()==null)
		{
			alert("Monto a Exonerar no debe ser Cero ni Nulo!!!")
			$("#descuento").focus();
			return
		}
		if($('#idpersonal').val()==0)
		{
			alert("Debe seleccionar quien Autoriza la Exoneración !!!")
			$("#idpersonal").focus();
			return
		}
		
		
	}
	
    guardar_datos();
	return true
	
}

function guardar_datos()
{
	const formData=$("#user_form").serializeArray().reduce(function(obj, item) {
		obj[item.name] = item.value;
		return obj;
	}, {});
	formData.valorLetras= numeroALetras(formData['0form_monto']);
	formData["0form_seriedocumento"]=$("#idserie>option:selected").attr("seriedoc");
	formData["0form_idseriedocumento"]=$("#idserie").val();
	/* formData["0form_idcomprobante"]=$("#idserie").val(); */
	console.log(formData);
	
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: (formData),
		success: function(data) {
	 //	alert(data)
        regresar_index(carpeta);
		ocultarVentana();
        }
    });
    
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
        "order": [[0,'desc']],
        "ajax": dir+"registros.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		 if ( aData[10] == "ANULAR")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[10] == "ANULADO")
			{
				$('td', nRow).css('color', 'red');
			}
		}
        } );
    } );
}

function anular_referencia(id,nref)
{
	
    var res=confirm("¿Desea Anular la Comprobante de Pago "+nref+" ?")
    if(res==false)
    {
        return false
    }
	else {
		var item = $('#contar_diagnostico').val()
   	    $.ajax({
            type:  "POST",
            url:   carpeta+"anular.php",
            data:  "anulado="+id+"&numero="+nref+"&cant="+item,
            success: function(data) {
			regresar_index(carpeta)
			}
		});
	}
}


function buscar_establecimiento()
{
	var idsel = $('#idselect').val(); 
	objindex="Establecimiento"
	if (idsel==1){
		$('#nombre_establecimiento').val(""); 
		var ventana=window.open("../lista/establecimiento/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
		ventana.focus();
	} else{
	//	alert("Ups, estamos trabajando para servirle mejor")
	//$("#idestablesolicita").val("373");
	var codbarra = $("#nombre_establecimiento").val();
		
		$.ajax({
			type: "POST",
			url: carpeta+"porcodbar.php",
			data: "cod="+codbarra+"&count_enf="+count_enf+"&monto_total="+monto_total,
			success: function(data) {
				$("#tbdiagnostico>tbody").append(data)
				$('#monto').val(formato_moneda_peruana(monto_total));
				$('#monto1').val(formato_moneda_peruana(monto_total));
			}
			
		});
	}
}


function cambiosOpcion()
{
	var id = $("#idselect").val();
   if (id==1){
	 document.getElementById('nombre_establecimiento').readOnly = true; 
	 buscar_establecimiento()
   }else {
	   document.getElementById('nombre_establecimiento').readOnly = false;  
   }
   
}

function imprimir_detalles(idpc)
{
    var ventana=window.open(carpeta+"imprimir.php?idpc="+idpc, 'Imprimir Detalle del Equipo', 'width=800,height=600,resizable=no, scrollbars=yes, status=yes,location=yes'); 
    ventana.focus();
   
}

function recibir(id,nombre,coddiad)
{

    if(objindex=="Diagnostico")
    {
        $("#diagnostico").val(id)
        $("#nombre_diagnostico").val(coddiad+" - "+nombre)
        $("#codigo_diagnostico").val(coddiad)
        $("#only_diagnostico").val(nombre)
      //  agregar_diagnostico()
    }

   if(objindex=="Pacientes")
    {
        $("#idpaciente").val(id)
        $("#nombre_paciente").val(coddiad+" - "+nombre)
        CalcularEdad(id)
    }

    if(objindex=="Establecimiento")
    {
        $("#idestablesolicita").val(id)
        $("#nombre_establecimiento").val(nombre+" - "+coddiad)
		cargar_cobro(id)
    }
	

}

function cuentaItem(){
	var diag=0;
	$("#contar_diagnostico2").val(diag);
	for( var i=1;i<=$("#contar_diagnostico").val();i++)
    {
        if(typeof($("#idmuestradetalle"+i).val())!= 'undefined' )
        {
           diag++;
		   $("#contar_diagnostico2").val(diag);
		   count_enf = diag;
        }
    }
}

function anular_pago(id,nref)
{
	
	var res=confirm("¿Desea Anular Comprobante con el Item N° "+nref+" ?")
	
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


/*
function buscar_renaes()
{
	var idbarra = $("#codbarra").val()
	var ipre = idbarra.substr(0,5);
	
	if (ipre!=""){
	$.ajax({
		type: "POST",
		url: carpeta+"procedencia.php",
		data: "idipres="+ipre,
		success: function(data) {

		var	res = data.split("|");
		var idestab = res[0]
		var nombre = res[1]
	
		$("#idestablesolicita").val(idestab)
        $("#nombre_establecimiento").val(nombre)
		cargar_cobro(idestab)
			//$("#div-subarea").html(data)
		}
	});
	} else {
		$("#idestablesolicita").val("")
        $("#nombre_establecimiento").val("")
	}
}
*/

function solonumeros(e)
{
	var key = window.event ? e.which : e.keyCode;
	if(key < 48 || key > 57)
		e.preventDefault();
}

function mayuscula(e) {
	e.value = e.value.toUpperCase();
}

function descuentoss()
{
	
	var descu	=	$("#descuento").val()
    var mon		=   $("#monto1").val()
	var old		= 	parseInt($("#monto1").val()).toFixed(2)
	var total	=	(parseInt(mon - descu))
	
	if (total < 0){
		alert("El descuento no debe ser Mayor que el Monto Total");
		$("#descuento").val(0);
		$("#monto").val(old)
	}else {
		$("#monto").val(total.toFixed(2))
	}
}

function quitar_diagnostico(idx)
{
	var mon		=   $("#monto1").val()
	var old		= 	$("#valor"+idx).val()
	var sald 	= 	parseFloat(mon) - parseFloat(old)
	
	$("#itemdiagnostico"+idx).remove();
	
	$("#monto1").val(sald)
	$("#monto").val(sald)
	$("#descuento").val(sald)
	cuentaItem();
}

function cargarn(ts){
	$("#nrodocumento").val($('option:selected', ts).attr('valor'));
}

function cargar_serie(){
	$("#nrodocumento").val("");
	const data={
		idcomprobante:$("#idcomprobante").val()
	}
	$.ajax({
		type: "POST",
		url: carpeta+"filter-serie.php",
		data: data,
		success: function(data) {
			$("#idserie").html(data);
			
		}
	});
}

function cargar_exonerar(id)
{
	cargar_serie();
	/* $("#seriedocumento").val(serie);
	$("#nrodocumento").val((parseInt(valor)+1)); */
	var mon	=   $("#monto1").val()
	if (id == 7){
	$.ajax({
		type: "POST",
		url: carpeta+"exonerar.php",
	//	data: "cod="+id+"&op="+op,
		success: function(data) {
			$("#div-exonerar").html(data)
			$("#descuento").val(mon)
			
		}
	});
	} else {
		$('#div-exonerar').empty();
	}
}
function cargar_cobro(id)
{
	var op = $("#op").val();
	
	$.ajax({
		type: "POST",
		url: carpeta+"porcobrar.php",
		data: "cod="+id+"&op="+op,
		success: function(data) {
			$("#div-porcobrar").html(data)
		}
		
	});
}

function formato_moneda_peruana(valor){
    return Number.parseFloat(valor).toFixed(2)
}
