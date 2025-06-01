var carpeta = "../facturacion/gestion_cpe/";
var aja2 =  "../ajax/";
var correo_idpago='';
var baja_idpago='';
var nota_idpago='';

/* 
function excel_ficha()
{
    window.open(carpeta + "excel.php")
    window.close()
    return true
} */
/* function regresar_index(dir)
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
}*/

function recarga2(dir){
    $(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "destroy":true,
        "responsive": true,
        "processing": true,
        "serverSide": true,        
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
function firmar_pago(idpago){
    console.log("firmar_pago",idpago);
    $.ajax({
        type: "POST",
        url: carpeta+"firmar_comprobante.php",
        data: {idpago},
		success: function(data) {
            data= JSON.parse(data);
            console.log(data);
            //if(!data.status){
                alert(data.msg);
                recarga2(carpeta)
            //}
	 //	alert(data)
        //regresar_index(carpeta)
        }
    });

}
function enviar_pago(idpago){
    console.log("enviar_pago",idpago);
    $.ajax({
        type: "POST",
        url: carpeta+"enviar_comprobante.php",
        data: {idpago},
		success: function(data) {
            data= JSON.parse(data);
            console.log(data);
            //if(!data.status){
                alert(data.msg);
                recarga2(carpeta)
            //}
	 //	alert(data)
        //regresar_index(carpeta)
        }
    });
}

//https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService

function consultar_pago(idpago){
    console.log("consultar_pago",idpago);
    $.ajax({
        type: "POST",
        url: carpeta+"consultar_comprobante.php",
        data: {idpago},
		success: function(data) {
            data= JSON.parse(data);
            console.log(data);
            //if(!data.status){
                alert(data.msg);
            //}
	 //	alert(data)
        //regresar_index(carpeta)
        }
    });
}
function validar_baja(){
    //baja_idpago;
    
    if($('#observacionBajas').val()=='')
    {
        alert("Observacion no debe ser nulo!")
        $("#observacionnotacredito").focus();
        return
    }
    enviar_baja();
}
function enviar_baja(){
    $( "#action22" ).prop( "disabled", true );
    $(".upload-msg2").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    
    var dataform =$("#formbajas").serializeArray().reduce(function(obj, item) {
		obj[item.name] = item.value;
		return obj;
	}, {});
    dataform.idpago=baja_idpago;
    $.ajax({
        type: "POST",
        url: carpeta+"anular_baja.php",
        data: dataform,
        success: function(data) {
                /* data = JSON.parse(data);
                alert(data.msg);
                ocultarVentanaSendEmail(); */
            }
        });
}
function validar_nota_credito(){
    //baja_idpago;
    
    if($('#observacionnotacredito').val()=='')
    {
        alert("Observacion no debe ser nulo!")
        $("#observacionnotacredito").focus();
        return
    }
}
function enviar_nota_credito(){
    $( "#action3" ).prop( "disabled", true );
    $(".upload-msg3").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    
    var dataform = $("#formmodalnotacredito").serializeArray().reduce(function(obj, item) {
		obj[item.name] = item.value;
		return obj;
	}, {});
    dataform.idpago=nota_idpago;
    $.ajax({
        type: "POST",
        url: carpeta+"anular_nota_credito.php",
        data: dataform,
        success: function(data) {
                /* data = JSON.parse(data);
                alert(data.msg);
                ocultarVentanaSendEmail(); */
            }
        });
}

function open_modal_correo(idpago){
    correo_idpago=idpago;
}

function enviar_correo(){
    $( "#action2" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    
    var dataform =$("#send_pdfp").serializeArray().reduce(function(obj, item) {
		obj[item.name] = item.value;
		return obj;
	}, {});
    /* $.each($('#sendCorror').serializeArray(), function() {
        dataform[this.name] = this.value;
    }); */
    dataform.idpago=correo_idpago;
    console.log(dataform);
    $.ajax({
        type: "GET",
        url: carpeta+"generar_pdf_comprobante.php?item_pago="+correo_idpago+"&pdf_show=0",
		success: function(data) {
            data= JSON.parse(data);
            console.log(data);
            if(!data.status){
                alert(data.msg);
            }else{
                $.ajax({
                    type: "POST",
                    url: carpeta+"send_email.php",
                    data: dataform,
                    success: function(data) {
                            data = JSON.parse(data);
                            alert(data.msg);
                            ocultarVentanaSendEmail();
                        }
                    });
            }
        }
    });
}

function ocultarVentanaSendEmail()
{
    $('#email').val('');
    $('#sendCorror').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 
    $( "#action2" ).prop( "disabled", false );
    $(".upload-msg").html("");
    

}

function ocultarModalBaja()
{
    $('#observacionBajas').val('');
    $('#modalbajas').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 
    $( "#action22" ).prop( "disabled", false );
    $(".upload-msg2").html("");
    

}

function openModalBajas(idpago){
    baja_idpago=idpago;
}

function openModalNotaCredito(idpago){
    nota_idpago=idpago;
}

function ocultarModalNotaCredito()
{
    $('#observacionnotacredito').val('');
    $('#modalnotacredito').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 
    $( "#action3" ).prop( "disabled", false );
    $(".upload-msg3").html("");
    

}

function validar_correo(){
    
    if($('#email').val()=='')
    {
        alert("Correo no debe ser Nulo !!!")
        $("#email").focus();
        return
    }
    enviar_correo();
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

function anular_pago_credito(idpago){
    console.log("anular_pago_credito",idpago);
}

function imprimir(nro)
{
	var server = window.location.hostname;
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	var urlprint = "../facturacion/gestion_cpe/generar_pdf_comprobante.php?item_pago="+nro+"&pdf_show=1";
	document.all.mostrarpdf.src = urlprint
}

function mayuscula(e) {
	e.value = e.value.toUpperCase();
}

