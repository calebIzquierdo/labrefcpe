
var carpeta = "../inventario/requerimiento/";
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
	var urlprint = "../inventario/requerimiento/imprimir.php?idrequerimiento="+nro+"&embedded=true";
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
function validar_form()
{
    if($('#idestablecimiento').val()==""){
        alert("El establecimiento no debe ser Nulo!!!")
        $("#idestablecimiento").focus();
        return
    }
	
	if($('#idarea').val()==""){
        alert("La unidad de trabajo no debe ser Nulo!!!")
        $("#idarea").focus();
        return
    }
	
	if($('#idareatrabajo').val()==""){
        alert("La area de trabajo no debe ser Nulo!!!")
        $("#idareatrabajo").focus();
        return
    }
	
	if($('#idpersonal').val()==""){
        alert("El solicitante no debe ser Nulo!!!")
        $("#nombre_personal").focus();
        return
    }
	
    if($('#glosa').val()==""){
        alert("La glosa no debe ser Nulo!!!")
        $("#glosa").focus();
        return
    }
    
	if($('#contar_detalle_reque').val()==0){
        alert("Lista de materiales no debe ser Nulo!!!")
        $("#nombre_material").focus();
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


function guardar_anulado()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"operaciones.php",
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
    //console.log("carpeta", carpeta);
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");

    var formData = $("#user_form").serialize();

    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: formData,
		success: function(data) {

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

function buscar_personal()
{
    objindex="Personal"
    var ventana=window.open("../lista/personal/", 'Personal', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function agregar_antigrama()
{
    var mate		=   $("#material").val()
    var mate_text	=	$("#nombre_material").val()	
	var cant		=	$("#cantidad").val();
    var especifi    =   $("#especificaciones").val()
   
    // console.log(unidad);
    if(mate==0)
    {
        alert("Material no debe ser Nulo!!!")
        $("#material").focus();
        return
    }
	
	
	if(cant=="")
    {
        alert("Cantidad no debe ser Nulo!!!")
        $("#cantidad").focus();
        return
    }
	
	document.getElementById("action").value="Agregar";

	
	if(count_edit){
        alert("1")
        document.getElementById("action").value="Agregar";
        quitar_diagnostico(count_edit);
        $("#detalleRequerimiento").append("<tr id='itemrequerimiento"+count_edit+"'>"+
        
      	"<td>"+
          "<p style='display:none' id='mate"+count_edit+"'>"+mate+"</p>"+
          "<p style='display:none' id='cant"+count_edit+"'>"+cant+"</p>"+        
          "<p style='display:none' id='mate_text"+count_edit+"'>"+mate_text+"</p>"+              
          "<p style='display:none' id='especificaciones"+count_edit+"'>"+especifi+"</p>"+ 
        "</td>"+
      	"<td><input type='hidden' name='cantidad"+count_edit+"' id='cantidad"+count_edit+"' value='"+cant+"' />"+cant+" </td>"+
        "<td>"+
        "<input type='hidden' name='idmaterial"+count_edit+"' id='idmaterial"+count_edit+"' value='"+mate+"' />"+mate_text+"</td>"+       
        "<td>"+
        "<input type='hidden' name='especificaciones"+count_edit+"' id='especificaciones"+count_edit+"' value='"+especifi+"' />"+especifi+"</td>"+
		"<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_edit+")' title='Borrar Registro' /></td>"+
        "</tr>");
        count_edit=null;
    }else{
        
        document.getElementById("action").value="Agregar";
        for( var i=1;i<=$("#contar_detalle_reque").val();i++)
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
        
        $("#detalleRequerimiento").append("<tr id='itemrequerimiento"+count_enf+"'>"+
            
            "<td>"+
            "<span>"+count_enf+"</span>"+

            "</td>"+
            "<td><input type='hidden' name='cantidad"+count_enf+"' id='cantidad"+count_enf+"' value='"+cant+"' />"+cant+" </td>"+
            "<td>"+
            "<input type='hidden' name='idmaterial"+count_enf+"' id='idmaterial"+count_enf+"' value='"+mate+"' />"+mate_text+"</td>"+       
            "<td>"+
            "<input type='hidden' name='especificaciones"+count_enf+"' id='especificaciones"+count_enf+"' value='"+especifi+"' />"+especifi+"</td>"+
            "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_enf+")' title='Borrar Registro' /></td>"+
            "</tr>");
            
        }
        
        document.getElementById("action").value="Agregar";
        

		$("#material").val(0)
		$("#nombre_material").val("")
		$("#cantidad").val(0);
        $("#especificaciones").val("")	
        $("#contar_detalle_reque").val($('#detalleRequerimiento tr').length)		 
}

function quitar_diagnostico(idx)
{
	$("#itemrequerimiento"+idx).remove();

	$("#contar_detalle_reque").val($('#detalleRequerimiento tr').length)
}
function editar_diagnostico(idx){
    document.getElementById("action").value="Actualizar";
    //$("action").val("Actualizar");
    //$("action").html("Actualizar");
    //let nombre_material= $("#itemdiagnostico"+idx).getElementById("nombre_material"+idx).innerHTML;
    var mate		=   $("#mate"+idx).html();
    var mate_text	=	$("#mate_text"+idx).html();
	var unidad		=	$("#unidad"+idx).html();
	var cant		=	$("#cant"+idx).html();
    console.log("Modelo edit:", modeloo, idx);
        $("#material").val(parseInt(mate))
		$("#nombre_material").val(mate_text)
		$("#cantidad").val(parseInt(cant));
		$("#unid").val(unidad)

		//$("#contar_diagnostico").val(count_enf);
        count_edit=idx;
}
function cuentaItem(){
    
	var diag=0;
	
	for( var i=1;i<=$("#contar_detalle_reque").val();i++)
    {
        if(typeof($("#idmaterial"+i).val())!= 'undefined' )
        {
            
           diag++;
		   $("#contar_detalle_reque").val(diag);
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
	//	alert(coddiad)
		var depd = 	coddiad;
		var res = depd.split("|");
		//var tipmat = res[0];
		var unid = res[1];

        $("#especificaciones").val(res[2])
        $("#unid").val(unid)
       //$("#tipmate").val(tipmat) 
		
    }

    if(objindex=="Personal")
    {
        $("#idpersonal").val(id)
        $("#nombre_personal").val(coddiad+" - "+nombre)
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

