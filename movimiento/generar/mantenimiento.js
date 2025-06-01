
var carpeta = "../movimiento/generar/";
var aja2 =  "../ajax/";

function mostrarVentana()
{
    var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}

function ocultarVentana()
{
    $('#userModal').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 

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



function guardar_datos()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: $("#user_form").serialize(),
		success: function(data) {
		// alert(data)
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
		 if ( aData[7] == "PROCESADO")
		{
			$('td', nRow).css('color', 'GREEN');
		} else  if ( aData[7] == "ANULADO")
			{
				$('td', nRow).css('color', 'red');
			}
		}
        } );
    } );
}

function buscar_establecimiento()
{
    objindex="Establecimiento"
    var ventana=window.open("../lista/codestable/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function recibir(id,nombre,coddiad,idpr)
{
	 $("#item").val(id);
	 $("#idpr").val(idpr);
	var idbar	= nombre
	var idbarra	= idbar.split("|")
	var ipre = idbarra[0].substr(3,5);
	/*if (idpr!=8){
		var ipre = idbarra[0].substr(3,5);
	} else {
		var ipre = idbarra[0].padStart(11,0);
		//idbarra.padStart(11,0);
	}*/
	var anio	= coddiad
	var anio_cod	= anio.split("|")
	var anio = anio_cod[0].substr(2,2);
	var nro1 = anio_cod[1];
	var nro = nro1.padStart(5,0)
	
	$("#codrenae").val(ipre)
	$("#nombre_correlativo").val(ipre+""+anio+""+nro)
	
    $("#idestablesolicita").val(idbarra[2]);
   
	$("#nombre_establecimiento").val(idbarra[0]+" - "+idbarra[1])

}


function validar_form()
{
	if ($("#codrenae").val()==""){
		alert("Debe Seleccionar el Establecimiento o Procedencia")
		return
	}
	if ($("#idestablesolicita").val()==""){
		alert("Debe Seleccionar el Establecimiento o Procedencia")
		return
	}
	
	if ($("#idanio").val()==0){
		alert("Debe Seleccionar Periodo")
		$("#idanio").focus();
		return
	}
	
	if ($("#correlativo").val()==0){
		alert("El numero no debe ser Nulo!!")
		$("#correlativo").focus();
		return
	}
	
	if ( $("#cantidad").val()==0 || $("#contar_codigos").val()==0 )
	{
		alert("Debe ingresar por lo menos un digito Antes de Guardar !!")
		$("#correlativo").focus();
		return
	}
	
	guardar_datos()
	
}

function genera_correlativo(){
	var idbarra = $("#codrenae").val()
	var ipre = idbarra.substr(3,5);
	var an  = $("#idanio option:selected").html();
	var anio = an.substr(2,2);
	var nro1   = $("#correlativo").val();
	var nro = nro1.padStart(5,0)
	$("#nombre_correlativo").val(ipre+""+anio+""+nro)
	
}

function generar_codigo(){
	var item	=   $("#nombre_correlativo").val()
	var ipre	=	item.substr(0,7);
	var numero	=	item.substr(7,5);
	var nro		=	0;
	var codBarra = 0;
	var total = 	$("#cantidad").val();
	count_enf=0;
	
	var item = $("#cantidad").val();
    	
	for( var i=1;i<=$("#cantidad").val();i++)
    {
		$("#cant").val(numero)
		$("#contar_codigos").val(total)
		
		count_enf++
		var item2	=   $("#cant").val()
		var nro = item2.padStart(5,0)
		codBarra = ipre+""+nro
		$("#final_correlativo").val(codBarra)
        numero++
			
		$("#tbdiagnostico").append("<tr id='itemdiagnostico"+count_enf+"'>"+
		"<td align='center'>"+count_enf+"</td>"+
      	"<td>"+
		"<input type='hidden' name='codbarra"+count_enf+"' id='codbarra"+count_enf+"' value='"+codBarra+"' />"+codBarra+" </td>"+
         "</tr>")
	}
   
}


function excel_ficha(id)
{
   
    window.open(carpeta+"excel.php?id="+id)
    window.close()
    return true
}


function solonumeros(e)
{
	var key = window.event ? e.which : e.keyCode;
	if(key < 48 || key > 57)
		e.preventDefault();
	genera_correlativo()
}

function mayuscula(e) {
	e.value = e.value.toUpperCase();
}
