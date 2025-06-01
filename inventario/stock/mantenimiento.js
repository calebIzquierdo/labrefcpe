
var carpeta = "../inventario/stock/";
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
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	var urlprint = "../inventario/stock/imprimir.php?nromovimiento="+nro+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}

//function cargar_form(op,cod)
function cargar_form()
{
	alert("Estamos trabajando, Por favor Espere")
	ocultarVentana()
	regresar_index(carpeta)
    
/*
	$.ajax({
		type: "POST",
		url: carpeta+"form-mantenimiento.php",
		data: "op="+op+"&cod="+cod,
		success: function(data) {
			mostrarVentana();
			$('#modal-body').html(data)
			}
		});
		*/
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
function validar_form()
{
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
	if($('#contar_diagnostico2').val()==0)
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

function guardar_datos()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: $("#user_form").serialize(),
		success: function(data) {
	// 	alert(data)
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
		 if ( aData[7] == "VENCE")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[7] == "NO VENCE")
			{
				$('td', nRow).css('color', 'BLUE');
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


function buscar_proveedor()
{
    objindex="Proveedor"
    var ventana=window.open("../lista/proveedor/", 'Proveedor', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
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
    var patri		=	$("#codpatri").val();
    var patlab		=	$("#codpatrilab").val();
    var pcomp		=	$("#pcompra").val();
    var pvent		=	$("#pventa").val();
   
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
	if(estad==0)
    {
        alert("Marca no debe ser Nulo!!!")
        $("#estado").focus();
        return
    }
	
	/*var	res = idarea.split("|");
	var idsubarea = res[0]; */
	
	
	for( var i=1;i<=$("#contar_diagnostico").val();i++)
    {
        if(mate == $("#material"+i).val() )
        {
            alert("El Tipo de Material ya Fue Agregado")
            $("#idmaterial").val(0)
            return
        }
    }

    count_enf++;
    $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_enf+"'>"+
      	"<td><input type='hidden' name='idtipomaterial"+count_enf+"' id='idtipomaterial"+count_enf+"' value='"+tipmate+"' />"+
			"<input type='hidden' name='idunidad"+count_enf+"' id='idunidad"+count_enf+"' value='"+unidad+"' />"+count_enf+"</td>"+
      	"<td><input type='hidden' name='cantidad"+count_enf+"' id='cantidad"+count_enf+"' value='"+cant+"' />"+cant+" </td>"+
        "<td><input type='hidden' name='idmaterial"+count_enf+"' id='idmaterial"+count_enf+"' value='"+mate+"' />"+mate_text+"</td>"+
        "<td><input type='hidden' name='idmarca"+count_enf+"' id='idmarca"+count_enf+"' value='"+marca+"' />"+marca_text+"</td>"+
        "<td><input type='hidden' name='serie"+count_enf+"' id='serie"+count_enf+"' value='"+series+"' />"+series+"</td>"+
        "<td><input type='hidden' name='idtipobien"+count_enf+"' id='idtipobien"+count_enf+"' value='"+estad+"' />"+estad_text+"</td>"+
        "<td><input type='hidden' name='fvencimiento"+count_enf+"' id='fvencimiento"+count_enf+"' value='"+fvence+"' />"+fvence+"</td>"+
        "<td><input type='hidden' name='modelo"+count_enf+"' id='modelo"+count_enf+"' value='"+modelo+"' />"+modelo+"</td>"+
        "<td><input type='hidden' name='pcompra"+count_enf+"' id='pcompra"+count_enf+"' value='"+pcomp+"' />"+pcomp+"</td>"+
        "<td><input type='hidden' name='pventa"+count_enf+"' id='pventa"+count_enf+"' value='"+pvent+"' />"+pvent+"</td>"+
        "<td><input type='hidden' name='codpatri"+count_enf+"' id='codpatri"+count_enf+"' value='"+patri+"' />"+patri+"</td>"+
        "<td><input type='hidden' name='codpatrilab"+count_enf+"' id='codpatrilab"+count_enf+"' value='"+patlab+"' />"+patlab+"</td>"+
        
		"<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_enf+")' title='Borrar Registro' /></td>"+
        "</tr>")

		$("#material").val(0)
		$("#nombre_material").val("")
		$("#marca").val(0);
		$("#cantidad").val(0);
		$("#estado").val(0);
		$("#serie").val("");
		$("#modelo").val("");
		$("#codpatri").val("");
		$("#codpatrilab").val("");
		$("#pcompra").val(0);
		$("#pventa").val(0);
		$("#unid").val("")
		$("#tipmate").val("")
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
   if(objindex=="Proveedor")
    {
        $("#idproveedor").val(id)
        $("#nombre_proveedor").val(coddiad+" - "+nombre)
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


function solonumeros(e)
{
	var key = window.event ? e.which : e.keyCode;
	if(key < 48 || key > 57)
		e.preventDefault();
}

function mayuscula(e) {
	e.value = e.value.toUpperCase();
}
