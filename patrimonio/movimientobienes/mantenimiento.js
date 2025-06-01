
var carpeta = "../patrimonio/movimientobienes/";
var aja2 =  "../ajax/";

var TablaDetalleArray=((localStorage.getItem('DetalleArray'))? JSON.parse(localStorage.getItem('DetalleArray')):[]);
function mostrarVentana()
{
    var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}
function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del número */
    var length = number.toString().length; /* Largo del número */ 
    var zero = "0"; /* String de cero */  
    
    if (width <= length) {
        if (number < 0) {
             return ("-" + numberOutput.toString()); 
        } else {
             return numberOutput.toString(); 
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString()); 
        }
    }
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
	var urlprint = "../inventario/ingresomaterial/imprimir.php?nromovimiento="+nro+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}

function cargar_form(op,cod)
{
    console.log("op:"+op, "cop:"+cod);
    console.log((op==1)?"crear":"Editar");
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

function anular_form(op,cod)
{
    console.log("op:"+op, "cop:"+cod);
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

function validarHeader()
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
    if($('#idtipoingreso').val()==0)
    {
        alert("Tipo Ingreso no debe ser Nulo !!!")
        $("#idtipoingreso").focus();
        return
    }
    
	if($('#nrorden').val()=="")
    {
        alert("Numero de Orden no debe ser Nula!!!")
        $("#nrorden").focus();
        return
    }
	
	if($('#idproveedor').val()=="")
	{
        alert("Debe seleccionar Proveeor!!!")
        $("#idproveedor").focus();
        return
    }
	
	if($('#idcomprobante').val()==0)
	{
        alert("Comprobante no debe ser Nula !!!")
        $("#idcomprobante").focus();
        return
    }
	
	if($('#nrocomprobante').val()==0)
	{
        alert("Nro Comprobante no debe ser Nula !!!")
        $("#nrocomprobante").focus();
        return
    }
	if(TablaDetalleArray.length==0)
	{
        alert("Debe Ingresar almenos 01 Articulo antes de guardar !!!")
        $("#contar_diagnostico2").focus();
        return
    }
	
	/*
	if($('#candmuestra').val()=="")
    {
        alert("Cantidad de Muestras no debe ser Nulo!!!")
        $("#cantidadmuestra").focus();
        return
    }
	
	
	if($('#contar_diagnostico').val()==0)
    {
        alert("Debe Ingresar por lo menos un Examen...")
		/* $('[href="#home"]').tab('show');
		 $( "#barra" ).focusin()        
		 $( "#cantidadmuestra" ).focusin()        
		 $( "#nrofua" ).focusin()        
		 $( "#referencia" ).focusin()        
		 $( "#tipoexamen" ).focusin()        
		 */
    //    return
    //}
    1
    var hoy = new Date();
    var hora = zfill(hoy.getHours(),2) + ':' + zfill(hoy.getMinutes(),2) + ':' + zfill(hoy.getSeconds(),2);
    var dataJson=serializeToJson($("#formHeader").serialize());
    dataJson.detalle=TablaDetalleArray;
    dataJson.Hfecharecepcion+=" "+hora;
    console.log(dataJson);
	var opt = $("#op").val()
	var cod = $("#codigo").val()
    console.log("OP:",opt);
    console.log("CODIGO:", cod);
	if (opt!=3){
        guardar_datos(dataJson);
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


function guardar_anulado()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"anular.php",
        data: $("#user_form").serialize(),
		success: function(data) {
	// 	alert(data)
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

function guardar_datos(data)
{
    //console.log("carpeta", carpeta);
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: data,
		success: function(data) {
            regresar_index(carpeta);
            TablaDetalleArray=[];
            localStorage.setItem("DetalleArray","[]");
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
    console.log("recarga tabla", dir);
    $(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "destroy":true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "asc" ]],
        "ajax": dir+"registros.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		 if ( aData[9] == "PROCESADO")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[9] == "ANULADO")
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


function buscar_personal()
{
    objindex="Personal"
    var ventana=window.open("../lista/personal/", 'Personal', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}
function buscar_material()
{
    objindex="Materiales"
    var ventana=window.open("../lista/material/", 'Materiales', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function agregar_antigrama()
{
    var mate		=   $("#material").val()
    var mate_text	=	$("#nombre_material").val()
	var unidad		=	$("#unid").val()
	var tipmate		=	$("#tipmate").val()
    var marca		=	$("#marca").val();
    var marca_text	=	$("#marca option:selected").html();
	var cant		=	$("#cantidad").val();
	var fvence		=	$("#vence").val();
	var estad		=	$("#estado").val();
    var estad_text	=	$("#estado option:selected").html();
    var series		=	$("#serie").val();
    var modelo		=	$("#modelo").val();
    var modelo_text	=	$("#modelo option:selected").html();
    var patri		=	$("#codpatri").val();
    var patlab		=	$("#codpatrilab").val();
    var pcomp		=	$("#pcompra").val();
    // var pvent		=	$("#pventa").val();
    var pvent		=	parseFloat(cant)*parseFloat(pcomp);
    var lte			=	$("#lotes").val();
   
    if(mate==0)
    {
        alert("Material no debe ser Nulo!!!")
        $("#material").focus();
        return
    }
	if(marca==0)
    {
        alert("Marca no debe ser Nulo!!!")
        $("#marca").focus();
        return
    }
	
	if(cant=="")
    {
        alert("Cantidad no debe ser Nulo!!!")
        $("#cantidad").focus();
        return
    }
	if(modelo==0)
    {
        alert("Modelo no debe ser Nulo!!!")
        $("#modelo").focus();
        return
    }
	if(estad==0)
    {
        alert("Estado no debe ser Nulo!!!")
        $("#estado").focus();
        return
    }
	document.getElementById("action").value="Agregar";
	/*var	res = idarea.split("|");
	var idsubarea = res[0]; */
	
	if(count_edit){
        document.getElementById("action").value="Agregar";
        quitar_diagnostico(count_edit);
        $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_edit+"'>"+
        
      	"<td>"+
          "<p style='display:none' id='mate"+count_edit+"'>"+mate+"</p>"+
        "<p style='display:none' id='mate_text"+count_edit+"'>"+mate_text+"</p>"+
        "<p style='display:none' id='unidad"+count_edit+"'>"+unidad+"</p>"+
        "<p style='display:none' id='tipmate"+count_edit+"'>"+tipmate+"</p>"+
        "<p style='display:none' id='marca"+count_edit+"'>"+marca+"</p>"+
        "<p style='display:none' id='marca_text"+count_edit+"'>"+marca_text+"</p>"+
        "<p style='display:none' id='cant"+count_edit+"'>"+cant+"</p>"+
        "<p style='display:none' id='fvence"+count_edit+"'>"+fvence+"</p>"+
        "<p style='display:none' id='estad"+count_edit+"'>"+estad+"</p>"+
        "<p style='display:none' id='estad_text"+count_edit+"'>"+estad_text+"</p>"+
        "<p style='display:none' id='series"+count_edit+"'>"+series+"</p>"+
        "<p style='display:none' id='modelo"+count_edit+"'>"+modelo+"</p>"+
        "<p style='display:none' id='modelo_text"+count_edit+"'>"+modelo_text+"</p>"+
        "<p style='display:none' id='patri"+count_edit+"'>"+patri+"</p>"+
        "<p style='display:none' id='patlab"+count_edit+"'>"+patlab+"</p>"+
        "<p style='display:none' id='pcomp"+count_edit+"'>"+pcomp+"</p>"+
        "<p style='display:none' id='pvent"+count_edit+"'>"+pvent+"</p>"+
        "<p style='display:none' id='lte"+count_edit+"'>"+lte+"</p>"+
            "<input type='hidden' name='idtipomaterial"+count_edit+"' id='idtipomaterial"+count_edit+"' value='"+tipmate+"' />"+
		    "<input type='hidden' name='idunidad"+count_edit+"' id='idunidad"+count_edit+"' value='"+unidad+"' />"
            +count_edit+
        "</td>"+
      	"<td><input type='hidden' name='cantidad"+count_edit+"' id='cantidad"+count_edit+"' value='"+cant+"' />"+cant+" </td>"+
        "<td>"+
        "<input type='hidden' name='idmaterial"+count_edit+"' id='idmaterial"+count_edit+"' value='"+mate+"' />"+mate_text+"</td>"+
        "<td>"+
        "<input type='hidden' name='idmarca"+count_edit+"' id='idmarca"+count_edit+"' value='"+marca+"' />"+marca_text+"</td>"+
        "<td><input type='hidden' name='serie"+count_edit+"' id='serie"+count_edit+"' value='"+series+"' />"+series+"</td>"+
        "<td><input type='hidden' name='idtipobien"+count_edit+"' id='idtipobien"+count_edit+"' value='"+estad+"' />"+estad_text+"</td>"+
        "<td><input type='hidden' name='fvencimiento"+count_edit+"' id='fvencimiento"+count_edit+"' value='"+fvence+"' />"+fvence+"</td>"+
        "<td>"+
            "<input type='hidden' name='idmodelo"+count_edit+"' id='idmodelo"+count_edit+"' value='"+modelo+"' />"
            +modelo_text+
        "</td>"+
        "<td><input type='hidden' name='pcompra"+count_edit+"' id='pcompra"+count_edit+"' value='"+pcomp+"' />"+pcomp+"</td>"+
        "<td><input type='hidden' name='pventa"+count_edit+"' id='pventa"+count_edit+"' value='"+pvent+"' />"+pvent+"</td>"+
        "<td><input type='hidden' name='lote"+count_edit+"' id='lote"+count_edit+"' value='"+lte+"' />"+lte+"</td>"+
        "<td><input type='hidden' name='codpatri"+count_edit+"' id='codpatri"+count_edit+"' value='"+patri+"' />"+patri+"</td>"+
        "<td><input type='hidden' name='codpatrilab"+count_edit+"' id='codpatrilab"+count_edit+"' value='"+patlab+"' />"+patlab+"</td>"+
        
		"<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_edit+")' title='Borrar Registro' /></td>"+
        "<td align='center'><img src='../img/edit.png' style='cursor:pointer' onclick='editar_diagnostico("+count_edit+")' title='Editar Registro' /></td>"+
        "</tr>");
        count_edit=null;
    }else{
        document.getElementById("action").value="Agregar";
        for( var i=1;i<=$("#contar_diagnostico").val();i++)
        {
            console.log(mate+" == "+$("#idmaterial"+i).val());
            if(mate == $("#idmaterial"+i).val() )
            {
                
                alert("El Tipo de Material ya Fue Agregado")
                $("#idmaterial").val(0)
                return
                
            }
        }
        count_enf++;
    $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_enf+"'>"+
        
      	"<td>"+
          "<p style='display:none' id='mate"+count_enf+"'>"+mate+"</p>"+
        "<p style='display:none' id='mate_text"+count_enf+"'>"+mate_text+"</p>"+
        "<p style='display:none' id='unidad"+count_enf+"'>"+unidad+"</p>"+
        "<p style='display:none' id='tipmate"+count_enf+"'>"+tipmate+"</p>"+
        "<p style='display:none' id='marca"+count_enf+"'>"+marca+"</p>"+
        "<p style='display:none' id='marca_text"+count_enf+"'>"+marca_text+"</p>"+
        "<p style='display:none' id='cant"+count_enf+"'>"+cant+"</p>"+
        "<p style='display:none' id='fvence"+count_enf+"'>"+fvence+"</p>"+
        "<p style='display:none' id='estad"+count_enf+"'>"+estad+"</p>"+
        "<p style='display:none' id='estad_text"+count_enf+"'>"+estad_text+"</p>"+
        "<p style='display:none' id='series"+count_enf+"'>"+series+"</p>"+
        "<p style='display:none' id='modelo"+count_enf+"'>"+modelo+"</p>"+
        "<p style='display:none' id='modelo_text"+count_enf+"'>"+modelo_text+"</p>"+
        "<p style='display:none' id='patri"+count_enf+"'>"+patri+"</p>"+
        "<p style='display:none' id='patlab"+count_enf+"'>"+patlab+"</p>"+
        "<p style='display:none' id='pcomp"+count_enf+"'>"+pcomp+"</p>"+
        "<p style='display:none' id='pvent"+count_enf+"'>"+pvent+"</p>"+
        "<p style='display:none' id='lte"+count_enf+"'>"+lte+"</p>"+
            "<input type='hidden' name='idtipomaterial"+count_enf+"' id='idtipomaterial"+count_enf+"' value='"+tipmate+"' />"+
		    "<input type='hidden' name='idunidad"+count_enf+"' id='idunidad"+count_enf+"' value='"+unidad+"' />"
            +count_enf+
        "</td>"+
      	"<td><input type='hidden' name='cantidad"+count_enf+"' id='cantidad"+count_enf+"' value='"+cant+"' />"+cant+" </td>"+
        "<td>"+
        "<input type='hidden' name='idmaterial"+count_enf+"' id='idmaterial"+count_enf+"' value='"+mate+"' />"+mate_text+"</td>"+
        "<td>"+
        "<input type='hidden' name='idmarca"+count_enf+"' id='idmarca"+count_enf+"' value='"+marca+"' />"+marca_text+"</td>"+
        "<td><input type='hidden' name='serie"+count_enf+"' id='serie"+count_enf+"' value='"+series+"' />"+series+"</td>"+
        "<td><input type='hidden' name='idtipobien"+count_enf+"' id='idtipobien"+count_enf+"' value='"+estad+"' />"+estad_text+"</td>"+
        "<td><input type='hidden' name='fvencimiento"+count_enf+"' id='fvencimiento"+count_enf+"' value='"+fvence+"' />"+fvence+"</td>"+
        "<td><input type='hidden' name='idmodelo"+count_enf+"' id='idmodelo"+count_enf+"' value='"+modelo+"' />"+modelo_text+"</td>"+
        "<td><input type='hidden' name='pcompra"+count_enf+"' id='pcompra"+count_enf+"' value='"+pcomp+"' />"+pcomp+"</td>"+
        "<td><input type='hidden' name='pventa"+count_enf+"' id='pventa"+count_enf+"' value='"+pvent+"' />"+pvent+"</td>"+
        "<td><input type='hidden' name='lote"+count_enf+"' id='lote"+count_enf+"' value='"+lte+"' />"+lte+"</td>"+
        "<td><input type='hidden' name='codpatri"+count_enf+"' id='codpatri"+count_enf+"' value='"+patri+"' />"+patri+"</td>"+
        "<td><input type='hidden' name='codpatrilab"+count_enf+"' id='codpatrilab"+count_enf+"' value='"+patlab+"' />"+patlab+"</td>"+
        
		"<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_enf+")' title='Borrar Registro' /></td>"+
        "<td align='center'><img src='../img/edit.png' style='cursor:pointer' onclick='editar_diagnostico("+count_enf+")' title='Editar Registro' /></td>"+
        "</tr>");
        
    }
	
    document.getElementById("action").value="Agregar";
    

		$("#material").val(0)
		$("#nombre_material").val("")
		$("#marca").val(0);
		$("#cantidad").val(0);
		$("#estado").val(0);
		$("#serie").val("");
		$("#modelo").val("0");
		$("#codpatri").val("");
		$("#codpatrilab").val("");
		$("#pcompra").val(0);
		$("#pventa").val(0);
		$("#unid").val("")
		$("#tipmate").val("")
		$("#contar_diagnostico").val(count_enf);
		
        cuentaItem();
  
}

function quitar_diagnostico(idx)
{
	$("#itemdiagnostico"+idx).remove();

	cuentaItem();
}
function editar_diagnostico(idx){
    document.getElementById("action").value="Actualizar";
    //$("action").val("Actualizar");
    //$("action").html("Actualizar");
    //let nombre_material= $("#itemdiagnostico"+idx).getElementById("nombre_material"+idx).innerHTML;
    var mate		=   $("#mate"+idx).html();
    var mate_text	=	$("#mate_text"+idx).html();
	var unidad		=	$("#unidad"+idx).html();
	var tipmate		=	$("#tipmate"+idx).html();
    var marca		=	$("#marca"+idx).html();
    cargar_marca(marca);
	var cant		=	$("#cant"+idx).html();
	var fvence		=	$("#fvence"+idx).html();
	var estad		=	$("#estad"+idx).html();
    var series		=	$("#series"+idx).html();
    var modeloo		=	$("#modelo"+idx).html();
    var patri		=	$("#patri"+idx).html();
    var patlab		=	$("#patlab"+idx).html();
    var pcomp		=	$("#pcomp"+idx).html();
    var pvent		=	$("#pvent"+idx).html();
    var lte			=	$("#lte"+idx).html();
    console.log("Modelo edit:", modeloo, idx);
        $("#material").val(parseInt(mate))
		$("#nombre_material").val(mate_text)
		$("#marca").val(parseInt(marca));
		$("#cantidad").val(parseInt(cant));
		$("#estado").val(parseInt(estad));
		$("#serie").val(series);
        document.getElementById("modelo").value=modeloo;
		$("#modelo").val(modeloo);
		$("#codpatri").val(patri);
		$("#codpatrilab").val(patlab);
		$("#pcompra").val(parseFloat(pcomp));
		$("#pventa").val(parseFloat(pvent));
		$("#unid").val(unidad)
		$("#tipmate").val(tipmate)
        $("#lotes").val(lte);
        
		//$("#contar_diagnostico").val(count_enf);
        count_edit=idx;
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

function recibir(id,nombre,coddiad)
{
   if(objindex=="Personal")
    {
        $("#idpersonal").val(id)
        $("#nombre_personal").val(coddiad+" - "+nombre)
    }

    if(objindex=="Materiales")
    {
        $("#material").val(id)
        $("#nombre_material").val(nombre)
		
		var depd = 	coddiad;
		var res = depd.split("|");
		var tipmat = res[0];
		var unid = res[1];

        $("#unid").val(unid)
        $("#tipmate").val(tipmat)
		
    }

}
function cargar_estado(id){
    $("#nombre_estado").val(id.split("-")[1]);
    $("#estado").val(id.split("-")[0]);
}
function cargar_marca(id)
{
    $("#nombre_marca").val(id.split("-")[1]);
    $("#marca").val(id.split("-")[0]);
	$.ajax({
		type: "POST",
		url: carpeta+"modelo.php",
		data: "idmarca="+id.split("-")[0],
		success: function(data) {
			$("#div-modelo").html(data)
		}
	});
}
function cargar_modelo(id){
    $("#modelo").val(id.split("-")[0]);
    $("#nombre_modelo").val(id.split("-")[1]);
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

function cargar_areatrabajo(id){
    $("#idareatrabajo").val(id.split("-")[0]);
    $("#idarea").val(id.split("-")[1]);
    $("#nombre_areatrabajo").val(id.split("-")[2]);
    console.log(id.split("-"));
}
function serializeToJson(serialize){
    var data = serialize.split("&");
    var obj={};
    for(var key in data)
    {
        obj[data[key].split("=")[0]] = data[key].split("=")[1].replaceAll('%20',' ').replaceAll('%2F','-');
    }
    return obj;
}
function addTable(dataJson){
    count_enf++;
    $("#table-detalle").append("<tr id='itemdiagnostico"+count_enf+"'>"+
        "<td>"+
        count_enf+
        "</td>"+
        "<td>"+
        "<input type='hidden' name='0form_idpersonal"+count_enf+"' id='0form_idpersonal"+count_enf+"' value='"+dataJson["0form_idpersonal"]+"' />"+dataJson.nombre_personal+
        "</td>"+
        "<td>"+
        "<input type='hidden' name='idareatrabajo"+count_enf+"' id='idareatrabajo"+count_enf+"' value='"+dataJson.idareatrabajo+"' />"+
        "<input type='hidden' name='idarea"+count_enf+"' id='idarea"+count_enf+"' value='"+dataJson.idarea+"' />"+dataJson.nombreareatrabajo+
        "</td>"+
        "<td>"+
        "<inpu type='hidden't name='material"+count_enf+"' id='material"+count_enf+"' value='"+dataJson.material+"' />"+dataJson.nombre_material+
        "</td>"+
        "<td>"+
        "<input type='hidden' name='marca"+count_enf+"' id='marca"+count_enf+"' value='"+dataJson.marca+"' />"+dataJson.nombre_marca+
        "</td>"+
        "<td>"+
        "<input type='hidden' name='modelo"+count_enf+"' id='modelo"+count_enf+"' value='"+dataJson.modelo+"' />"+dataJson.nombre_modelo+
        "</td>"+
        "<td>"+
        "<input type='hidden' name='codpatrilab"+count_enf+"' id='codpatrilab"+count_enf+"' value='"+dataJson.codpatrilab+"' />"+
        "<input type='hidden' name='codpatri"+count_enf+"' id='codpatri"+count_enf+"' value='"+dataJson.codpatri+"' />"+
        dataJson.codpatri+
        "</td>"+
        "<td>"+
        "<input type='hidden' name='color"+count_enf+"' id='color"+count_enf+"' value='"+dataJson.color+"' />"+dataJson.color+
        "</td>"+
        "<td>"+
        "<input type='hidden' name='estado"+count_enf+"' id='estado"+count_enf+"' value='"+dataJson.estado+"' />"+dataJson.nombre_estado+
        "</td>"+
        "<td>"+
        "<input type='hidden' name='serie"+count_enf+"' id='serie"+count_enf+"' value='"+dataJson.serie+"' />"+
        "<input type='hidden' name='observacion"+count_enf+"' id='observacion"+count_enf+"' value='"+dataJson.observacion+"' />"+dataJson.serie+
        "</td>"+
        "<td>"+
        "anular"+
        "</td>"+
        "<td>"+
        "editar"+
        "</td>"+
    "</tr>"
    );
}
function validarDetalle(){
    if(!$("#idpersonal").val()){
        alert("Seleccione el responsable");
        $("#nombre_personal").focus();
        return;
    }
    if(!$("#tipmate").val()){
        alert("Seleccione el tipo de material");
        $("#nombre_material").focus();
        return;
    }
    var dataJson=serializeToJson($("#formDetalle").serialize());
    TablaDetalleArray.push(dataJson);
    localStorage.setItem("DetalleArray",JSON.stringify(TablaDetalleArray));
    addTable(dataJson);
    $("#formDetalle")[0].reset();
}

function cargar_subarea(id)
{
    
	$.ajax({
		type: "POST",
		url: carpeta+"subarea.php",
		data: "idarea="+id,
		success: function(data) {
			$("#div-subarea").html(data)
		}
	});
}