var count=0;
var carpeta = "../facturacion/gestion_nota_credito/";
var aja2 = "../ajax/";
var correo_idpago='';
//$('#comprobantes').select2();
//$('#idclientes').select2();

function mostrarVentana()
{
    var ventana = document.getElementById('userModal'); 
   /* ventana.style.display = 'block'; 
    $('#userModal').modal('show'); */
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
function ocultarVentana()
{
    $('#userModal').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 

}

//console.log('Test nota credito');
function regresar_index(dir)
{
    var resultado = document.getElementById('page-wrapper');
    ajax = objetoAjax();
    ajax.open("GET", dir+"index.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            recarga2(carpeta)
        }
    }
    ajax.send(null);
}
/* $("#idclientes").on('change',function (){
    console.log($(this).val());
    $("#direccion_cliente").val($('option:selected',this).attr("direc"));
}) */
/* tipo_comprobante
comprobante
fecha_emision
ruc_cliente
cliente
direccion_cliente
echo '<option value="'.$pago['idpago'].'" nrodoc="'.$pago['nrodocumento'].'" tpcomprobante="'.$pago['descripcion'].'" fecha="'.$pago['fecharecepcion'].'" ruc="'.$pago['ruc'].'" rz="'.$pago['razonsocial'].'" direccion="'.$pago['direccion'].'">'.$pago['nrodocumento'].'</option>';
 *//* 
$("#comprobantes").on('change', function() {
    console.log(this.value);
    $("#userModal").modal('show');
    $("#comprobante_select").val(this.value);
    $("#tipo_comprobante").val($('option:selected',this).attr("tpcomprobante"));
    $("#comprobante").val($('option:selected',this).attr("nrodoc"));
    $("#fecha_emision").val($('option:selected',this).attr("fecha"));
    $("#ruc_cliente").val($('option:selected',this).attr("ruc"));
    $("#cliente").val($('option:selected',this).attr("rz"));
    $("#direccion_cliente").val($('option:selected',this).attr("direccion"));
    modalHidden1();
    mostrarVentana();
    //recarga2(carpeta);
  });
  function modalHidden1() {
    $("#modalcomprobante").modal('hide');
       
  }
  function modalShow1() {
    $("#modalcomprobante").modal('show');
    ocultarVentana();
} */
function recarga2(dir){
    $("#imp_bruto").val(0);
    $("#imp_bruto1").val(0);
    $("#imp_bruto2").val(0);
    $("#id_desc").val(0);
    $(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "destroy":true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [[ 1, "desc" ]],
        "ajax": dir+"registros.php?idpago="+$("#comprobantes").val(),
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            console.log(aData);
    

            $("#imp_bruto").val(parseFloat($("#imp_bruto").val())+parseFloat(aData[7]));
            $("#imp_bruto1").val(parseFloat($("#imp_bruto1").val())+parseFloat(aData[7]));
            $("#imp_bruto2").val(parseFloat($("#imp_bruto2").val())+parseFloat(aData[7]));
            $("#id_desc").val(parseFloat($("#id_desc").val())+parseFloat(aData[5]));
		 /* if ( aData[7] == "PROCESADO")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[7] == "ANULADO")
			{
				$('td', nRow).css('color', 'red');
			} */
		}
        } );
    } )
    
}


function registrar_nota(){
    if($("#comprobante_select").val()=='0'){
        alert('aun no selecionó un comprobante!!');
        $("#modalcomprobante").modal('show');
        return;
    }
    var dataform =$("#registrar_nota").serializeArray().reduce(function(obj, item) {
		obj[item.name] = item.value;
		return obj;
	}, {});
    $.ajax({
        type: "POST",
        url: carpeta+"registrar_nota_credito.php",
        data: dataform,
        success: function(data) {
            
                data = JSON.parse(data);
                if(!data.status){
                    alert(data.msg);
                }else{
                    alert(data.msg);
                    ocultarVentana();
                    recarga2(carpeta);
                }
                    
                
                /* 
                alert(data.msg);
                ocultarVentanaSendEmail(); */
            }
        });
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
function imprimir(nro)
{
	var server = window.location.hostname;
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	var urlprint = "../facturacion/gestion_nota_credito/generar_pdf_comprobante.php?item_pago="+nro+"&pdf_show=1";
	document.all.mostrarpdf.src = urlprint
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
function ocultarVentanaSendEmail()
{
    $('#email').val('');
    $('#sendCorror').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 
    $( "#action2" ).prop( "disabled", false );
    $(".upload-msg").html("");
    

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
