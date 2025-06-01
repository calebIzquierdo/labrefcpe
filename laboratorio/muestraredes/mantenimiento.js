
var carpeta = "../laboratorio/muestraredes/";
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
	var urlprint = "../laboratorio/tuberculosis/urocultivo/imprimir.php?nromovimiento="+nro+"&embedded=true";
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
    if($('#idtipoatencion').val()==0)
    {
        alert("Tipo Atencion no debe ser Nulo !!!")
        $("#idtipoatencion").focus();
        return
    }
    console.log("O"+$('#idestablesolicita').val()+"O");
	if($("#idestablesolicita").val()=='    ' ||$("#nombre_establecimiento").val()=='    ' )
    {
        alert("Procedencia no debe ser Nula, Clic para seleccionar Procedencia")
        $("#nombre_establecimiento").focus();
        return
    }
	
	if($('#codbarra').val()=="")
	{
        alert("Codigo de Barra no debe ser Nulo!!!")
        $("#barra").focus();
        return
    }
	
	/*
	if($('#candmuestra').val()=="")
    {
        alert("Cantidad de Muestras no debe ser Nulo!!!")
        $("#cantidadmuestra").focus();
        return
    }
	*/
	
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
        return
    }
   
	if ($('#op').val()==1) {
        validarbarra()
    } else {
        guardar_datos()
    }
	return true
	
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
		//alert(data)
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
        "order": [[ 1, "desc" ]],
        "ajax": dir+"registros.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		 if ( aData[7] == "PROCESADO")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[7] == "ANULADO")
			{
				$('td', nRow).css('color', 'red');
			}
		}
		/*, lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ]*/
		
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
    var ventana=window.open("../lista/establecimiento/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function agregar_antigrama()
{
    var tipoexamen	=   $("#tipoexamen").val();
    var cantidad	=   $("#cant").val();
    var cant_text	=   $("#cant").val();
    var tipexam_text	=	$("#tipoexamen option:selected").html();
    var idarea		=	$("#areadestino").val();
    var idarea_text	=	$("#areadestino option:selected").html();
   
    if(tipoexamen==0)
    {
        alert("Exámen no debe ser Nulo!!!")
        $("#tipoexamen").focus();
        return
    }
    if(cantidad==0)
    {
        alert("Cantidad no debe ser Nulo!!!")
        $("#cantidad").focus();
        return
    }
	if(idarea==0)
    {
        alert("Unidad Destino no debe ser Nulo!!!")
        $("#areadestino").focus();
        return
    }
   
   var	res = idarea.split("|");
	var idsubarea = res[0];
	var idareas = res[1];
	
	var	are_text = idarea_text.split("/");
	var text_area =  are_text[1];
	var text_subarea = are_text[0]
	
	for( var i=1;i<=$("#contar_diagnostico").val();i++)
    {
        if(tipoexamen == $("#idtipo_examen"+i).val() )
        {
            alert("El Tipo de Examen ya Fue Agregado")
            $("#tipoexamen").val(0)
            return
        }
    }

    count_enf++;
    $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_enf+"'>"+
      	"<td><input type='hidden' name='idmuestradetalle"+count_enf+"' id='idmuestradetalle"+count_enf+"' value='0' />"+count_enf+""+
		"<input type='hidden' name='idareatrabajo"+count_enf+"' id='idareatrabajo"+count_enf+"' value='"+idsubarea+"' /> </td>"+
        "<td><input type='hidden' name='cantidad"+count_enf+"' id='cantidad"+count_enf+"' value='"+cantidad+"' />"+cant_text+"</td>"+
        "<td><input type='hidden' name='idtipo_examen"+count_enf+"' id='idtipo_examen"+count_enf+"' value='"+tipoexamen+"' />"+tipexam_text+"</td>"+
        "<td><input type='hidden' name='idarea"+count_enf+"' id='idarea"+count_enf+"' value='"+idareas+"' />"+text_area+"</td>"+
        "<td>"+text_subarea+"</td>"+
        "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_enf+")' title='Borrar Registro' /></td>"+
        "</tr>")

    $("#tipoexamen").val("");
	$("#tipoexamen option:selected").html("");
    $("#areadestino").val(0);
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
        if(typeof($("#idantibiograma"+i).val())!= 'undefined' )
        {
           diag++;
		   $("#contar_diagnostico2").val(diag);
        }
    }
}

function buscar_paciente()
{
	objindex="Pacientes"
	var ventana=window.open("../lista/pacientes/", 'Pacientes', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
	ventana.focus();
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
    }

}

function cargar_subarea(id)
{
	$.ajax({
		type: "POST",
		url: carpeta+"subarea.php",
		data: "tpexam="+id,
		success: function(data) {
			$("#div-subarea").html(data)
		}
	});
}

function buscar_renaes()
{
	var idbarra = $("#codbarra").val()
	var ipre = idbarra.substr(0,5);
		
	if (ipre!=""){
	$.ajax({
		type: "POST",
		url: carpeta+"procedencia.php",
		data: "idipres="+ipre+"&nrocodb="+idbarra,
		success: function(data) {
		var	res = data.split("|");
		var idestab = res[0]
		var nombre = res[1]
			if (nombre==1){
				alert('Codigo de Barra ya existe: '+idbarra+', Por Favor ingrese nuevo Codigo'),
				$("#codbarra").val("");
				$("#codbarra").focus()
				$("#idestablesolicita").val("")
				$("#nombre_establecimiento").val("")
			}else{
				$("#idestablesolicita").val(idestab)
				$("#nombre_establecimiento").val(nombre)
			}
			//$("#div-subarea").html(data)
		}
	});
	} else {
		$("#idestablesolicita").val("")
        $("#nombre_establecimiento").val("")
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

