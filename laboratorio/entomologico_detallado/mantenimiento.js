
var carpeta = "../laboratorio/entomologico/";
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
	var urlprint = "../laboratorio/entomologico/imprimir.php?fechainicial=2020-03-06&fechafinal=2020-03-06&embedded=true";
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

function imprimir_detalles(idpc)
{
	var urlprint = carpeta+"imprimir.php?idpc="+idpc+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
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
	/*	tipo_atencion(tip)
		tipo_exam(tip)
		
		*/tipo_prueba(tip)
		}
	});
	
}
 
 function mayuscula(e) {
	e.value = e.value.toUpperCase();
}


function agregar_antigrama()
{
    var insp		=   $("#inspec").val()
    var zona		=   $("#zon").val()
    var zona_text	=   $("#zon option:selected").html()
    var mzn			=   $("#mzn").val()
    var fami		=   $("#fam").val()
    var vins		=   $("#vins").val()
    var vprg		=   $("#vprog").val()
    var direccion	=   $("#direc").val()
	var muest		=	$("#muestra").val();
    var idint		=   $("#iterven").val()
    var idint_text	=	$("#iterven option:selected").html();
    var larva		=	$("#larvas").val();
    var pupa		=	$("#pupas").val();
    var adulto		=	$("#adultos").val();
    var aedesag		=	$("#aedesag").val();
    var otro		=	$("#otros").val();
    
   
    if(insp=="")
    {
        alert("Ingrese Nombre del Inspector !!!")
        $("#inspec").focus();
        return
    }
	if(zona=="")
    {
        alert("Zona no debe ser Nulo!!!")
        $("#zon").focus();
        return
    }
	if(mzn=="")
    {
        alert("Manzana no debe ser Nulo!!!")
        $("#mzn").focus();
        return
    }
	if(direccion=="")
    {
        alert("Direccion no debe ser Nulo!!!")
        $("#direc").focus();
        return
    }
	/* if(foco==0)
    {
        alert("Foco no debe ser Nulo!!!")
        $("#direc").focus();
        return
    }
   */
    count_enf++;
    $("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_enf+"'>"+
      	"<td>"+count_enf+"</td>"+
		"<td><input type='hidden' name='idinspector"+count_enf+"' id='idinspector"+count_enf+"' value='"+insp+"' />"+insp+" </td>"+
        "<td><input type='hidden' name='idzona"+count_enf+"' id='idzona"+count_enf+"' value='"+zona+"' />"+zona_text+"</td>"+
        "<td><input type='hidden' name='direccion"+count_enf+"' id='direccion"+count_enf+"' value='"+direccion+"' />"+direccion+"</td>"+
        "<td><input type='hidden' name='manzana"+count_enf+"' id='manzana"+count_enf+"' value='"+mzn+"' />"+mzn+"</td>"+
        "<td><input type='hidden' name='familia"+count_enf+"' id='familia"+count_enf+"' value='"+fami+"' />"+fami+"</td>"+
        "<td><input type='hidden' name='vinspec"+count_enf+"' id='vinspec"+count_enf+"' value='"+vins+"' />"+vins+"</td>"+
        "<td><input type='hidden' name='vprogam"+count_enf+"' id='vprogam"+count_enf+"' value='"+vprg+"' />"+vprg+"</td>"+
        "<td><input type='hidden' name='idtipointervencion"+count_enf+"' id='idtipointervencion"+count_enf+"' value='"+idint+"' />"+idint_text+"</td>"+
        "<td><input type='hidden' name='idtipofoco"+count_enf+"' id='idtipofoco"+count_enf+"' value='0' />"+
		"<input type='button' onclick='add_foco("+count_enf+")' class='btn btn-success'  value='Agregar' /> </td>"+
        "<td><input type='hidden' name='larva"+count_enf+"' id='larva"+count_enf+"' value='"+larva+"' />"+larva+"</td>"+
        "<td><input type='hidden' name='pupa"+count_enf+"' id='pupa"+count_enf+"' value='"+pupa+"' />"+pupa+"</td>"+
        "<td><input type='hidden' name='adulto"+count_enf+"' id='adulto"+count_enf+"' value='"+adulto+"' />"+adulto+"</td>"+
        "<td><input type='hidden' name='aedes"+count_enf+"' id='aedes"+count_enf+"' value='"+aedesag+"' />"+aedesag+"</td>"+
        "<td><input type='hidden' name='otro"+count_enf+"' id='otro"+count_enf+"' value='"+otro+"' />"+otro+"</td>"+
        "<td><input type='hidden' name='rinspeccionado"+count_enf+"' id='rinspeccionado"+count_enf+"' value='0' />0</td>"+
        "<td><input type='hidden' name='rpositiva"+count_enf+"' id='rpositiva"+count_enf+"' value='0' />0</td>"+
        "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_enf+")' title='Borrar Registro' /></td>"+
        "</tr>")

    $("#inspec").val("");
    $("#zon").val("");
    $("#mzn").val("");
    $("#direc").val("");
	$("#foco").val(0);
	$("#larvas").val(0);
	$("#pupas").val(0);
	$("#adultos").val(0);
	$("#aedesag").val(0);
	$("#otros").val(0);
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

function add_foco(id){
	index=id
	var ventana=window.open(carpeta+"ficha_foco.php?idfoco="+$("#idtipofoco"+id).val()+"&idm="+$("#idingresomuestra").val(),800,500)
	ventana.focus();
}
/*
function recuperar_recipiente(id)
{
  $("#idtipofoco"+index).val(id)
  document.frmguardar.submit()

}
*/	  
function recuperar_recipiente(id,trecp,tposi)
{
//	alert(id+"; "+trecp+"; "+tposi)
	$("#idtipofoco"+index).val(id)
	$("#idtipofoco"+index).html(id)
	$("#rinspeccionado"+index).val(trecp)
	$("#rinspeccionado"+index).html(trecp)
	$("#rpositiva"+index).val(tposi)
	$("#rpositiva"+index).html(tposi)
	
}


