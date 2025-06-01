
var carpeta = "../inventario/salidamaterial/";
var aja2 =  "../ajax/";

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
	var urlprint = "../inventario/salidamaterial/imprimir.php?nromovimiento="+nro+"&embedded=true";
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

function validar_form()
{
    if($('#idunidadejec').val()==""){
        alert("La unidad ejecutora no debe ser Nulo!!!")
        $("#idred").focus();
        return
    }
    if($('#idred').val()==""){
        alert("La red no debe ser Nulo!!!")
        $("#idred").focus();
        return
    }
    if($('#idmicrored').val()==""){
        alert("La microred no debe ser Nulo!!!")
        $("#idmicrored").focus();
        return
    }
    if($('#idestablecimiento').val()==""){
        alert("El establecimiento no debe ser Nulo!!!")
        $("#idestablecimiento").focus();
        return
    }
	if($('#idtiposalida').val()==0)
    {
        alert("Tipo salida no debe ser Nulo !!!")
        $("#idtiposalida").focus();
        return
    } 
    if($('#idarea').val()=="")
    {
        alert("Unidad de Trabajo no debe ser Nulo !!!")
        $("#idarea").focus();
        return
    }
    
	if($('#idareatrabajo').val()=="")
    {
        alert("Area de Trabajo no debe ser Nula !!!")
        $("#idareatrabajo").focus();
        return
    }
	
	if($('#idsolicita').val()=="")
	{
        alert("Debe indicar quien Solicita el requerimiento !!!")
        $("#idsolicita").focus();
        return
    }
	if($('#identregado').val()==0)
	{
        alert("Entregado por:, no debe ser Nulo !!!")
        $("#identregado").focus();
        return
    }
    if($('#idrequerimiento').val()=="")
	{     
        alert("Debe seleccionar un requerimiento, no debe ser Nulo !!!")
        $("#idrequerimiento").focus(); 
        return
    }
	if($('#contar_diagnostico2').val()=="")
	{     
        alert("No se a encontrado detalles del requerimiento, Debe seleccionar un requerimiento !!!")
        $("#contar_diagnostico2").focus(); 
        return
    }
	
	var opt = $("#op").val()
	var cod = $("#codigo").val()
	if (opt!=3){
        guardar_datos()
	} else {
		var res=confirm("¿Desea Anular la referencia Nª "+cod+" ?")
		if(res==false) {
         regresar_index(carpeta)
		  ocultarVentana()
		}
		else {	
		guardar_anulado()
		}
	}
	return true
	
}
//console.log("TESTTT");
$(document).ready(function() {
    $('#anuladosswitch').change(function(){
        //console.log("switch");
        if ($(this).is(':checked')) {
      
            mostar_anulados();
        }else{
            
            ocultar_anulados();
        }
    });
});
function ocultar_anulados(){
    console.log("ocultar anulados");
    $('.odd').hide();
    //document.getElementsByClassName('odd').style.visibility = "hidden";
}
function mostar_anulados(){
    console.log("mostrar anulados");
    $('.odd').show();
    //document.getElementsByClassName('odd').style.visibility = "visible";
}
function guardar_anulado()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"anular.php",
        data: $("#user_form").serialize(),
		success: function(data) {
	//	alert(data)
        regresar_index(carpeta)
        }
    });
    ocultarVentana()
}

function validarbarra()
{
    var nrodoc	=	$("#codbarra").val();

		$.ajax({
        type:  "POST",
        url:   carpeta+"validarcodbarra.php",
        data:  "nrocodb="+nrodoc,
        success:  function (response) {
            var r=response.split("|")
            if(r[1]==1)
            {
                alert('Codigo de Barra ya existe: '+nrodoc+', Por Favor ingrese nuevo Codigo'),
				$("#codbarra").val("");
                $("#codbarra").focus()
            }
            else
				{
					guardar_datos()
				}
			}
		});
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
	 //	alert(data)
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
    ajax.send(null)
}


function anular_form(op,cod)
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

function recarga2(dir){
    console.log("Recargando");
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            "destroy":true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [[ 0, "asc" ]],
            "ajax": dir+"registros.php",
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if ( aData[9] == "PROCESADO"){
                    $('td', nRow).css('color', 'GREEN');
                } else  if ( aData[9] == "ANULADO"){
                    $('td', nRow).css('color', 'red');
                }
            },
            "createdRow": function( nRow, aData, type ) {
                if (aData[9] == "ANULADO") {
                    $(nRow).hide();
                }
            }
        }).then(()=>{
            ocultar_anulados()
        });
    })
    
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


function buscar_proveedor()
{
    objindex="Proveedor"
    var ventana=window.open("../lista/proveedor/", 'Proveedor', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function buscar_requerimiento()
{
    objindex="NroRequerimiento"
    var ventana=window.open("../lista/requerimiento/", 'NroRequerimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function buscar_material()
{
    objindex="Materiales"
    var ventana=window.open("../lista/material_lista/", 'Materiales', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function listar_antigramas() {
    $("#error-div").html("");
    var requerimiento = $("#text-requerimiento").val(); ///00000030
	if(requerimiento==""){
		 $("#error-div").html("DEBE SELECCIONAR UN REQUERIMIENTO PARA LA SALIDA DE MATERIALES");
	//	buscar_requerimiento()
	}else{
		$("#error-div").html("");
    $.ajax({
        type: "POST",
        url: carpeta+"consulta_requerimiento.php",
        data: "requerimiento="+requerimiento,
        success: function(data) {
            var datos = JSON.parse(data);

            if(datos.exist == null){
                $("#tbdiagnostico > tbody").empty();
                $("#error-div").html("<div class='alert alert-danger' role='alert'>Error... El requerimiento no existes...</div>");
                return;
            } else if(datos.exist == 5){
                $("#tbdiagnostico > tbody").empty();
                $("#error-div").html("<div class='alert alert-danger' role='alert'>Error... El requerimiento ya ha sido entregado...</div>");
                return;
            } else if(datos.exist == 3){
                $("#tbdiagnostico > tbody").empty();
                $("#error-div").html("<div class='alert alert-danger' role='alert'>Error... El requerimiento ha sido anulado...</div>");
                return;
            } else if(datos.exist == 1){
                $("#tbdiagnostico > tbody").empty();
                $("#error-div").html("<div class='alert alert-danger' role='alert'>Error... El requerimiento aun no ha sido aprobado...</div>");
                return;
            } else if(datos.exist == 4){
                
                var count = 0;
                $("#tbdiagnostico > tbody").empty();
                $("#idrequerimiento").val(datos.idrequerimiento);
                $.each(datos.detalle, function(index, value) {
                    
                    count++;
                    $("#tbdiagnostico").append(
                        "<tr id='itemdiagnostico"+count+"'>"+
                            "<td>"+
                                "<p style='display:none' id='mate"+count+"'>"+value.idmaterial+"</p>"+
                                "<p style='display:none' id='mate_text"+count+"'>"+value.material+"</p>"+
                                "<p style='display:none' id='unidad"+count+"'>"+value.idunidad+"</p>"+
                                "<p style='display:none' id='unidad_text"+count+"'>"+value.u_medida+"</p>"+
                                "<p style='display:none' id='tipmate"+count+"'>"+value.idtipomaterial+"</p>"+
                                "<p style='display:none' id='marca"+count+"'>"+value.idmarca+"</p>"+
                                "<p style='display:none' id='marca_text"+count+"'>"+value.marca+"</p>"+
                                "<p style='display:none' id='cant"+count+"'>"+value.cant_aprobada+"</p>"+
                                "<p style='display:none' id='fvence"+count+"'>"+value.fvence+"</p>"+
                                "<p style='display:none' id='series"+count+"'>"+value.series+"</p>"+
                                "<p style='display:none' id='modelo"+count+"'>"+value.idmodelo+"</p>"+
                                "<p style='display:none' id='patri"+count+"'>"+value.patri+"</p>"+
                                "<p style='display:none' id='patlab"+count+"'>"+value.patlab+"</p>"+
                                "<p style='display:none' id='cnt"+count+"'>"+value.cant_aprobada+"</p>"+
                                "<input type='hidden' name='idmodelo"+count+"' id='idmodelo"+count+"' value='"+value.idmodelo+"' />"+
                                "<input type='hidden' name='idtipomaterial"+count+"' id='idtipomaterial"+count+"' value='"+value.idtipomaterial+"' />"+count+
                            "</td>"+
                            "<td><input type='hidden' name='cantidad"+count+"' id='cantidad"+count+"' value='"+value.cant_aprobada+"' />"+value.cant_aprobada+" </td>"+
                            "<td><input type='hidden' name='idunidad"+count+"' id='idunidad"+count+"' value='"+value.idunidad+"' />"+value.u_medida+" </td>"+
                            "<td><input type='hidden' name='idmaterial"+count+"' id='idmaterial"+count+"' value='"+value.idmaterial+"' />"+value.material+"</td>"+
                            "<td><input type='hidden' name='idmarca"+count+"' id='idmarca"+count+"' value='"+value.idmarca+"' />"+value.marca+"</td>"+
                            "<td><input type='hidden' name='serie"+count+"' id='serie"+count+"' value='"+value.series+"' />"+value.series+"</td>"+
                            "<td><input type='hidden' name='fvencimiento"+count+"' id='fvencimiento"+count+"' value='"+value.fvence+"' />"+value.fvence+"</td>"+
                            "<td><input type='hidden' name='codpatri"+count+"' id='codpatri"+count+"' value='"+value.patri+"' />"+value.patri+"</td>"+
                            "<td><input type='hidden' name='codpatrilab"+count+"' id='codpatrilab"+count+"' value='"+value.patlab+"' />"+value.patlab+"</td>"+
                            "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count+")' title='Quitar Registro' /></td>"+
                            "<td align='center'><img src='../img/edit.png' style='cursor:pointer' onclick='editar_diagnostico("+count+")' title='Editar Registro' /></td>"+
                        "</tr>"
                    )

                });

                // $.each(datos.detalle, function(index, value) {
                    
                //     count++;
                //     $("#tbdiagnostico").append(
                //         "<tr id='itemdiagnostico"+value.count_enf+"'>"+
                //             "<td>"+
                //                 "<p style='display:none' id='mate"+value.count_enf+"'>"+value.idmaterial+"</p>"+
                //                 "<p style='display:none' id='mate_text"+value.count_enf+"'>"+value.material+"</p>"+
                //                 "<p style='display:none' id='unidad"+value.count_enf+"'>"+value.idunidad+"</p>"+
                //                 "<p style='display:none' id='unidad_text"+value.count_enf+"'>"+value.u_medida+"</p>"+
                //                 "<p style='display:none' id='tipmate"+value.count_enf+"'>"+value.idtipomaterial+"</p>"+
                //                 "<p style='display:none' id='marca"+value.count_enf+"'>"+value.idmarca+"</p>"+
                //                 "<p style='display:none' id='marca_text"+value.count_enf+"'>"+value.marca+"</p>"+
                //                 "<p style='display:none' id='cant"+value.count_enf+"'>"+value.cant_aprobada+"</p>"+
                //                 "<p style='display:none' id='fvence"+value.count_enf+"'>"+value.fvence+"</p>"+
                //                 "<p style='display:none' id='series"+value.count_enf+"'>"+value.series+"</p>"+
                //                 "<p style='display:none' id='modelo"+value.count_enf+"'>"+value.idmodelo+"</p>"+
                //                 "<p style='display:none' id='patri"+value.count_enf+"'>"+value.patri+"</p>"+
                //                 "<p style='display:none' id='patlab"+value.count_enf+"'>"+value.patlab+"</p>"+
                //                 "<p style='display:none' id='cnt"+value.count_enf+"'>"+value.cant_aprobada+"</p>"+
                //                 "<input type='hidden' name='idmodelo"+value.count_enf+"' id='idmodelo"+value.count_enf+"' value='"+value.idmodelo+"' />"+
                //                 "<input type='hidden' name='idtipomaterial"+value.count_enf+"' id='idtipomaterial"+value.count_enf+"' value='"+value.idtipomaterial+"' />"+value.count_enf+
                //             "</td>"+
                //             "<td><input type='hidden' name='cantidad"+value.count_enf+"' id='cantidad"+value.count_enf+"' value='"+value.cant_aprobada+"' />"+value.cant_aprobada+" </td>"+
                //             "<td><input type='hidden' name='idunidad"+value.count_enf+"' id='idunidad"+value.count_enf+"' value='"+value.idunidad+"' />"+value.u_medida+" </td>"+
                //             "<td><input type='hidden' name='iidmaterial"+value.count_enf+"' id='idmaterial"+value.count_enf+"' value='"+value.idmaterial+"' />"+value.material+"</td>"+
                //             "<td><input type='hidden' name='idmarca"+value.count_enf+"' id='idmarca"+value.count_enf+"' value='"+value.idmarca+"' />"+value.marca+"</td>"+
                //             "<td><input type='hidden' name='serie"+value.count_enf+"' id='serie"+value.count_enf+"' value='"+value.series+"' />"+value.series+"</td>"+
                //             "<td><input type='hidden' name='fvencimiento"+value.count_enf+"' id='fvencimiento"+value.count_enf+"' value='"+value.fvence+"' />"+value.fvence+"</td>"+
                //             "<td><input type='hidden' name='codpatri"+value.count_enf+"' id='codpatri"+value.count_enf+"' value='"+value.patri+"' />"+value.patri+"</td>"+
                //             "<td><input type='hidden' name='codpatrilab"+value.count_enf+"' id='codpatrilab"+value.count_enf+"' value='"+value.patlab+"' />"+value.patlab+"</td>"+
                //             "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+value.count_enf+")' title='Quitar Registro' /></td>"+
                //             "<td align='center'><img src='../img/edit.png' style='cursor:pointer' onclick='editar_diagnostico("+value.count_enf+")' title='Editar Registro' /></td>"+
                //         "</tr>"
                //     )

                // });

                $("#contar_diagnostico").val(count);
                $("#contar_diagnostico2").val(count);

                // console.log(datos);
            }

        }
    });
	}
}

function agregar_antigrama()
{
	var treg = $("#contar_diagnostico").val();
	var treg2 = $("#contar_diagnostico2").val();
    var mate		=   $("#material").val()
    var mate_text	=	$("#material_texto").val()
	var unidad		=	$("#unid").val()
	var unidad_text =	$("#unid_text").val()
	var tipmate		=	$("#tipmate").val()
    var marca		=	$("#marca").val();
    var marca_text	=	$("#marca_texto").val();
	var cant		=	$("#cantidad").val();
	var fvence		=	$("#vence").val();
    var series		=	$("#serie").val();
    var modelo		=	$("#modelo").val();
    var patri		=	$("#codpatri").val();
    var patlab		=	$("#codpatrilab").val();
    var lote_text	=	$("#lot").val();
	var stok_act	= 	parseInt($("#stock").val());
	var cnt			= 	parseInt($("#cantidad").val());
	//var count_enf	=	0;
   
    if(mate==0)
    {
        alert("Material no debe ser Nulo!!!")
        $("#material").focus();
        return
    }
	
	if(cant=="" || cant==0  )
    {
        alert("Cantidad no debe ser 0 ó Nulo!!!")
        $("#cantidad").focus();
        return
    }
	
	if (cnt > stok_act){
		alert("Cantidad Ingresada debe ser Menor que Stock de Almacen: "+stok_act)
		return 
	}
	
	for( var i=1;i<=$("#contar_diagnostico").val();i++)
    {
        if(mate == $("#material"+i).val() )
        {
            alert("El Tipo de Material ya Fue Agregado")
            $("#idmaterial").val(0)
            return
        }
    }
	
    document.getElementById("action").value="Agregar";
	
    if(count_edit){
		
        document.getElementById("action").value="Agregar";
        quitar_diagnostico(count_edit);
    $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_edit+"'>"+
      	"<td>"+
          "<p style='display:none' id='mate"+count_edit+"'>"+mate+"</p>"+
          "<p style='display:none' id='mate_text"+count_edit+"'>"+mate_text+"</p>"+
          "<p style='display:none' id='unidad"+count_edit+"'>"+unidad+"</p>"+
          "<p style='display:none' id='unidad_text"+count_edit+"'>"+unidad_text+"</p>"+
          "<p style='display:none' id='tipmate"+count_edit+"'>"+tipmate+"</p>"+
          "<p style='display:none' id='marca"+count_edit+"'>"+marca+"</p>"+
          "<p style='display:none' id='marca_text"+count_edit+"'>"+marca_text+"</p>"+
          "<p style='display:none' id='cant"+count_edit+"'>"+cant+"</p>"+
          "<p style='display:none' id='fvence"+count_edit+"'>"+fvence+"</p>"+
          "<p style='display:none' id='series"+count_edit+"'>"+series+"</p>"+
          "<p style='display:none' id='modelo"+count_edit+"'>"+modelo+"</p>"+
          "<p style='display:none' id='patri"+count_edit+"'>"+patri+"</p>"+
          "<p style='display:none' id='patlab"+count_edit+"'>"+patlab+"</p>"+
          /* "<p style='display:none' id='stok_act"+count_enf+"'>"+stock+"</p>"+ */
          "<p style='display:none' id='cnt"+count_edit+"'>"+cant+"</p>"+
          "<input type='hidden' name='idmodelo"+count_edit+"' id='idmodelo"+count_edit+"' value='"+modelo+"' />"+
		"<input type='hidden' name='idtipomaterial"+count_edit+"' id='idtipomaterial"+count_edit+"' value='"+tipmate+"' />"+count_edit+" </td>"+
		"<td><input type='hidden' name='cantidad"+count_edit+"' id='cantidad"+count_edit+"' value='"+cant+"' />"+cant+" </td>"+
      	"<td><input type='hidden' name='idunidad"+count_edit+"' id='idunidad"+count_edit+"' value='"+unidad+"' />"+unidad_text+" </td>"+
        "<td><input type='hidden' name='idmaterial"+count_edit+"' id='idmaterial"+count_edit+"' value='"+mate+"' />"+mate_text+"</td>"+
        "<td><input type='hidden' name='idmarca"+count_edit+"' id='idmarca"+count_edit+"' value='"+marca+"' />"+marca_text+"</td>"+
        "<td><input type='hidden' name='lote"+count_edit+"' id='lote"+count_edit+"' value='"+lote_text+"' />"+lote_text+"</td>"+
        "<td><input type='hidden' name='serie"+count_edit+"' id='serie"+count_edit+"' value='"+series+"' />"+series+"</td>"+
        "<td><input type='hidden' name='fvencimiento"+count_edit+"' id='fvencimiento"+count_edit+"' value='"+fvence+"' />"+fvence+"</td>"+
        "<td><input type='hidden' name='codpatri"+count_edit+"' id='codpatri"+count_edit+"' value='"+patri+"' />"+patri+"</td>"+
        "<td><input type='hidden' name='codpatrilab"+count_edit+"' id='codpatrilab"+count_edit+"' value='"+patlab+"' />"+patlab+"</td>"+
        "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_edit+")' title='Borrar Registro' /></td>"+
        "<td align='center'><img src='../img/edit.png' style='cursor:pointer' onclick='editar_diagnostico("+count_edit+")' title='Editar Registro' /></td>"+
        
        "</tr>")
        count_edit=null;
		$("#contar_diagnostico").val(treg);
		$("#contar_diagnostico2").val(treg2);
		count_enf =treg;
		
    }else{
		document.getElementById("action").value="Agregar";
        for( var i=1;i<=$("#contar_diagnostico").val();i++)
        {
            // console.log("N° Reg: "+$("#contar_diagnostico").val());
            // console.log(mate+" == "+$("#idmaterial"+i).val());
            // console.log(marca+" == "+$("#idmarca"+i).val());
            if(mate == $("#idmaterial"+i).val() && marca ==$("#idmarca"+i).val() )
            {
                
                alert("El Tipo de Material y Marca ya Fue Agregado")
                $("#idmaterial").val(0)
                return
                
            }
        }
		//count_enf =treg;
	    count_enf++;
    $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_enf+"'>"+
      	"<td>"+
          "<p style='display:none' id='mate"+count_enf+"'>"+mate+"</p>"+
          "<p style='display:none' id='mate_text"+count_enf+"'>"+mate_text+"</p>"+
          "<p style='display:none' id='unidad"+count_enf+"'>"+unidad+"</p>"+
          "<p style='display:none' id='unidad_text"+count_enf+"'>"+unidad_text+"</p>"+
          "<p style='display:none' id='tipmate"+count_enf+"'>"+tipmate+"</p>"+
          "<p style='display:none' id='marca"+count_enf+"'>"+marca+"</p>"+
          "<p style='display:none' id='marca_text"+count_enf+"'>"+marca_text+"</p>"+
          "<p style='display:none' id='cant"+count_enf+"'>"+cant+"</p>"+
          "<p style='display:none' id='fvence"+count_enf+"'>"+fvence+"</p>"+
          "<p style='display:none' id='series"+count_enf+"'>"+series+"</p>"+
          "<p style='display:none' id='modelo"+count_enf+"'>"+modelo+"</p>"+
          "<p style='display:none' id='patri"+count_enf+"'>"+patri+"</p>"+
          "<p style='display:none' id='patlab"+count_enf+"'>"+patlab+"</p>"+
          /* "<p style='display:none' id='stok_act"+count_enf+"'>"+stock+"</p>"+ */
          "<p style='display:none' id='cnt"+count_enf+"'>"+cant+"</p>"+
          "<input type='hidden' name='idmodelo"+count_enf+"' id='idmodelo"+count_enf+"' value='"+modelo+"' />"+
		"<input type='hidden' name='idtipomaterial"+count_enf+"' id='idtipomaterial"+count_enf+"' value='"+tipmate+"' />"+count_enf+" </td>"+
		"<td><input type='hidden' name='cantidad"+count_enf+"' id='cantidad"+count_enf+"' value='"+cant+"' />"+cant+" </td>"+
      	"<td><input type='hidden' name='idunidad"+count_enf+"' id='idunidad"+count_enf+"' value='"+unidad+"' />"+unidad_text+" </td>"+
        "<td><input type='hidden' name='idmaterial"+count_enf+"' id='idmaterial"+count_enf+"' value='"+mate+"' />"+mate_text+"</td>"+
        "<td><input type='hidden' name='idmarca"+count_enf+"' id='idmarca"+count_enf+"' value='"+marca+"' />"+marca_text+"</td>"+
        "<td><input type='hidden' name='lote"+count_enf+"' id='lote"+count_enf+"' value='"+lote_text+"' />"+lote_text+"</td>"+
        "<td><input type='hidden' name='serie"+count_enf+"' id='serie"+count_enf+"' value='"+series+"' />"+series+"</td>"+
        "<td><input type='hidden' name='fvencimiento"+count_enf+"' id='fvencimiento"+count_enf+"' value='"+fvence+"' />"+fvence+"</td>"+
        "<td><input type='hidden' name='codpatri"+count_enf+"' id='codpatri"+count_enf+"' value='"+patri+"' />"+patri+"</td>"+
        "<td><input type='hidden' name='codpatrilab"+count_enf+"' id='codpatrilab"+count_enf+"' value='"+patlab+"' />"+patlab+"</td>"+
        "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_enf+")' title='Borrar Registro' /></td>"+
        "<td align='center'><img src='../img/edit.png' style='cursor:pointer' onclick='editar_diagnostico("+count_enf+")' title='Editar Registro' /></td>"+
        
        "</tr>")
		$("#contar_diagnostico").val(treg);
		$("#contar_diagnostico2").val(treg2);
	//	alert("nuevo2 "+count_enf)
      //  cuentaItem()
    }
	
	//alert("nuevo2 "+count_enf)
    
    document.getElementById("action").value="Agregar";
	
		$("#material").val(0)
		$("#nombre_material").val("")
		$("#material_texto").val("")
		$("#marca").val(0);
		$("#cantidad").val(0);
		$("#stock").val("");
		$("#serie").val("");
		$("#modelo").val("");
		$("#codpatri").val("");
		$("#codpatrilab").val("");
		$("#unid").val("");
		$("#lot").val("");
		$("#lote_texto").val("");
		$("#tipmate").val("");
		$("#contar_diagnostico").val(count_enf);
		$("#contar_diagnostico2").val(count_enf);
        let date = new Date()

        let day = date.getDate()
        let month = date.getMonth() + 1
        let year = date.getFullYear()

        if(month < 10){
        $("#vence").val(`${day}-0${month}-${year}`);
        }else{
        $("#vence").val(`${day}-${month}-${year}`);
        } 
}

function quitar_diagnostico(idx)
{
	$("#itemdiagnostico"+idx).remove();
	cuentaItem();
}

function editar_diagnostico(idx){
	var treg = $("#contar_diagnostico").val();
	var treg2 = $("#contar_diagnostico2").val();
    document.getElementById("action").value="Actualizar";
    //console.log('');
    var mate		=   $("#mate"+idx).html();
    var marca		=	$("#marca"+idx).html();
    $.ajax({
		type: "POST",
		url: carpeta+"stock_diagnostico.php",
		data: "idmaterial="+mate+"&idmarca="+marca,
		success: function(data) {
                console.log("cantidad",data);
                var stok_act	= data;
                var mate_text	=	$("#mate_text"+idx).html();
                var unidad		=	$("#unidad"+idx).html();
                var unidad_text =	$("#unidad_text"+idx).html();
                var tipmate		=	$("#tipmate"+idx).html();
                
                var marca_text	=	$("#marca_text"+idx).html();
                var cant		=	$("#cant"+idx).html();
                var fvence		=	$("#fvence"+idx).html();
                var series		=	$("#series"+idx).html();
                var modelo		=	$("#modelo"+idx).html();
                var patri		=	$("#patri"+idx).html();
                var patlab		=	$("#patlab"+idx).html();
                var lote_text	=	$("#lote"+idx).html();
                var patlab		=	$("#patlab"+idx).html();
                var cnt			= 	parseInt($("#cnt"+idx).html());

                $("#nombre_material").val(unidad_text+" - "+marca_text+" - "+mate_text)
                $("#material").val(mate)
                $("#material_texto").val(mate_text)
                $("#unid").val(unidad)
                $("#unid_text").val(unidad_text)
                $("#tipmate").val(tipmate)
                $("#marca").val(marca);
                $("#marca_texto").val(marca_text);
                $("#cantidad").val(cant);
                $("#vence").val(fvence);
                $("#serie").val(series);
                $("#modelo").val(modelo);
                $("#codpatri").val(patri);
                $("#codpatrilab").val(patlab);
                $("#stock").val(stok_act);
                $("#cantidad").val(cnt);
				$("#lote_texto").val(lote_texto)
			//	$("#lot").val(lote_texto)
                count_edit=idx;
			}
		});
		/*
    $("#contar_diagnostico").val(treg);
	$("#contar_diagnostico2").val(treg2);
	*/
	
}

function cuentaItem(){
	var diag=0;
	$("#contar_diagnostico2").val(diag);
	for( var i=1;i<=$("#contar_diagnostico").val();i++)
    {
        if(typeof($("#idmaterial"+i).val())!= 'undefined' )
        {
           diag++;
		   $("#contar_diagnostico2").val(diag);
        }
    }
}

function imprimir_detalles(idpc)
{
    var ventana=window.open(carpeta+"imprimir.php?idpc="+idpc, 'Imprimir Detalle del Equipo', 'width=800,height=600,resizable=no, scrollbars=yes, status=yes,location=yes'); 
    ventana.focus();
   
}

function zeroFill( number, width )
{
  width -= number.toString().length;
  if ( width > 0 )
  {
    return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
  }
  return number + ""; // always return a string
}


function Area(ar,sar)
 {     

   // $("#idareatrabajo").val("");
    $.ajax({
	 type: "POST",
	 url: carpeta+"area.php",
	 data: "idar="+ar,
	 success: function(data) {
		 $("#idarea").html(data)  
	 }
	});
	AreaTrabajo(ar,sar);
 }

 function AreaTrabajo(idArea,idsarea)
 {
	$.ajax({
	 type: "POST",
	 url: carpeta+"subarea.php",
	 data: "idArea="+idArea+"&idsarea="+idsarea,
	 success: function(data) {
		 $("#idareatrabajo").html(data)
	 }
	});
 }

 function Solicitante(idsoli)
 {
   //	alert(idsoli)
	$.ajax({
	 type: "POST",
	 url: carpeta+"solicita.php",
	 data: "idsoli="+idsoli,
	 success: function(data) {
		 $("#solicitaDO").html(data)
		// alert(data)	
	 }
	});
 }

function recibir(id,nombre,coddiad,fven)
{
   if(objindex=="Proveedor"){
        $("#idproveedor").val(id)
        $("#nombre_proveedor").val(coddiad+" - "+nombre)
    }
	
	if(objindex=="NroRequerimiento") //NroRequerimiento
	{
		var nroreq = zeroFill(id,7)

		$("#error-div").html("");
		$("#text-requerimiento").val(nroreq);
		//window.opener.recibir(id,$("#idarea"+index).val(),$("#subarea"+index).val(),$("#soli"+index).val())
		
		Area(nombre,coddiad)
		Solicitante(fven)
		listar_antigramas()
		
	}
	
    if(objindex=="Materiales")
    {
		
        $("#idingreso").val(id)
        $("#nombre_material").val(nombre)
		
		var depd = 	coddiad;
		var res = depd.split("|");
		var unid = res[0];
		var marca = res[1];
		var material = res[2];
		var tipmate = res[3];
		var stock_texto = res[4];
		var idmod = res[5];

        $("#unid").val(unid)
        $("#marca").val(marca)
        $("#material").val(material)
        $("#tipmate").val(tipmate)
        $("#stock").val(stock_texto)
        $("#modelo").val(idmod)
       
		
		var texto	= 	nombre;
		var rnom = texto.split("-");
		var unid_text = rnom[0];
		var marca_t = rnom[1];
		var material_texto = rnom[2];
		var tipmate_texto = res[3];
		var lote_text = res[6];
		
		//alert(lote_text)
		$("#unid_text").val(unid_text)
        $("#marca_texto").val(marca_t)
        $("#material_texto").val(material_texto)
        $("#tipmate_texto").val(tipmate_texto)
        $("#lote_texto").val(lote_text)
        $("#lot").val(lote_text)
		
		var fc	= 	fven;
		var fch = fc.split("-");
		var d = fch[2];
		var m = fch[1];
		var a = fch[0];
		var nfec = a+"/"+m+"/"+d
		console.log("vence",nfec);
		console.log("lote:",lote_text);
		$("#vence").val(nfec);
    }
}

function cargar_subarea(id,idsub)
{
	$.ajax({
		type: "POST",
		url: carpeta+"subarea.php",
		data: "idarea="+id+"&idsub="+idsub,
		success: function(data) {
			$("#div-subarea").html(data)
		}
	});
}

function tiposalida()
{
   var idtip	=	$("#idtiposalida").val();
  
		$.ajax({
        type:  "POST",
        url:   carpeta+"tiposalida.php",
        data:  "tip="+idtip,
        success:  function (response) {
			var r=response.split("|")
			$("#idcorrelativo").val(r[0]);
			$("#nrorden").val(r[1])
		}
	});
}

function solonumeros(e)
{
	var key = window.event ? e.which : e.keyCode;
	if(key < 48 || key > 57)
		e.preventDefault();
}

function mayuscula(e) {
	e.value = e.value.toUpperCase();
}
/* recarga2(carpeta); */
