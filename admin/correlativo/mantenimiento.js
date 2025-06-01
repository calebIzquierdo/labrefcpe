
var carpeta = "../admin/correlativo/";
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
    var ventana=window.open("../lista/establecimiento/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function duplicidad()
{
    objindex="Establecimiento"
    var ventana=window.open("../lista/establecimiento/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function recibir(id,nombre,coddiad,idred)
{

    $("#idestablesolicita").val(id);
	$("#nombre_establecimiento").val(nombre+" - "+coddiad)
	$("#codrenae").val(nombre)
	$("#idpriva").val(idred)
	genera_correlativo()
	
}
function validar_form(){
	if ($("#codrenae").val()==""){
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
	
	guardar_datos()
}

function genera_correlativo(){
	
	var idst =  $("#idestablesolicita").val();
	var nomb =  $("#nombre_establecimiento").val();
	var aann = $("#idanio").val()
	var aan2 = $("#idanio option:selected").html()
	
	$.ajax({
        type:  "POST",
        url:   carpeta+"duplicidad.php",
        data:  "ides="+idst+"&anio="+aann,
        success:  function (response) {
            var r=response.split("|")
            if(r[1]==1)
            {
                alert("Establecimiento: "+nomb+" y Periodo: "+aan2+" ya fue creado, Por Favor ingrese nuevo Codigo"),
				$("#idestablesolicita").val(0);
                $("#idanio").val(0)
				$("#nombre_establecimiento").val("");
				$("#action").prop( "disabled", true );
				$("#nombre_correlativo").val("")
				$("#correlativo").val("")
				$("#codrenae").val("")
            }
            else
				{
					 $( "#action" ).prop( "disabled", false );
					var idbarra = $("#codrenae").val()
					var priva = $("#idpriva").val()
					var ipre = idbarra.substr(3,5);
					var an  = $("#idanio option:selected").html();
					var anio = an.substr(2,2);
					var nro1   = $("#correlativo").val();
					
					var nro = nro1.padStart(5,0)
					$("#nombre_correlativo").val(ipre+""+anio+""+nro)
				}
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
