var count=0;
var carpeta = "../catalogo/tipo_examen/";
var aja2 = "../ajax/";

function mostrarVentana()
{
	var ventana = document.getElementById('userModal'); // Accedemos al contenedor
   //ventana.style.display = 'block'; // Y lo hacemos visible
}

function ocultarVentana()
{
	$('#userModal').modal('hide'); // Desactivamos el backdrop del contenedor
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
	var descripcion= $("#descripcion").val()
	if(descripcion=="")
	{
		alert("La Descripcion no puede ser NULA")
		return false
	}

	guardar_datos()
	return true
}

function cambiarestado(obj,input)
{
	if(obj.checked)
	{
		$("#"+input).val(1)
		document.getElementById("boton01").className = "btn btn-primary";
		document.getElementById('boton01').innerHTML="Activo";
	}else{
		$("#"+input).val(0)
		document.getElementById('boton01').innerHTML="Inactivo";
		document.getElementById("boton01").className = "btn btn-danger";
	}
}

function guardar_datos()
{
	$.ajax({
            type: "POST",
            url: carpeta+"guardar.php",
            data: $("#user_form").serialize(),
            success: function(data) {
			//	alert(data)
			regresar_index(carpeta)
            }
       });
	ocultarVentana();
}


//funciones de Listar los registros 
function regresar_index(dir) {
	
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
    	"responsive":true,
    	"destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": dir+"registros.php"
    	} );
	} );
}


function cargar_subarea(id,sub)
{
	$.ajax({
		type: "POST",
		url: carpeta+"subarea.php",
		data: "idarea="+id+"&sub="+sub,
		success: function(data) {
			$("#div-subarea").html(data)
		}
	});
}


function agregar_prueba()
{
   
    var tip_prueb	=   $("#tipatencion").val()
    var text_tiprueba	=	$("#tipatencion option:selected").html();
	var valor		=   $("#valor").val()
   
    if(tip_prueb==0)
    {
        alert("Seleccionar Convenio")
        $("#tipatencion").focus();
        return
    }
    if(valor=="")
    {

        alert("Precio no debe ser Nulo!!! ")
        $("#valor").focus();
        return
    }
	
    for( var i=1;i<=$("#contar_prueba").val();i++)
    {
        if(tip_prueb == $("#idtipoatencion"+i).val() )
        {
            alert("Convenio ya Fue Agregado")
            $("#tipoprueba").val(0)
            return
        }
    }

    count_prue++;
    $("#tbprueba").append("<tr id='itemprueba"+count_prue+"'>"+
        "<td>"+count_prue+" </td>"+
        "<td><input type='hidden' name='idtipoatencion"+count_prue+"' id='idtipoatencion"+count_prue+"' value='"+tip_prueb+"' />"+text_tiprueba+"</td>"+
        "<td><input type='hidden' name='valor"+count_prue+"' id='valor"+count_prue+"' value='"+valor+"' />"+valor+"</td>"+
        "<td align='center'><img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico("+count_prue+")' title='Borrar Registro' /></td>"+
        "</tr>")


    $("#tipatencion").val(0)
    $("#valor").val("")
    $("#contar_prueba").val(count_prue)
	cuentaItem()
  
}
function quitar_diagnostico(idx)
{
	$("#itemprueba"+idx).remove();
	cuentaItem();
}

function cuentaItem(){
	var diag1=0;
	$("#contar_prueba2").val(diag1);
	for( var i=1;i<=$("#contar_prueba").val();i++)
    {
        if(typeof($("#idtipoprueba"+i).val())!= 'undefined' )
        {
           diag1++;
		   $("#contar_prueba2").val(diag1);
        }
    }
}

