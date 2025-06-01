var count=0;
var carpeta = "../catalogo/paciente/";
var carpeta_ajax = "../ajax/"

function mostrarVentana()
{
	// var ventana = document.getElementById('userModal'); // Accedemos al contenedor
   //ventana.style.display = 'block'; // Y lo hacemos visible
   $('#userModal').modal('show');
}

function ocultarVentana()
{
	// var ventana = document.getElementById('userModal'); // Accedemos al contenedor
    //ventana.style.display = 'none'; // Y lo hacemos invisible
    $('#userModal').modal('hide');
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
	var descripcion= $("#nombres").val()
	if(descripcion=="")
	{
		alert("El campo Nombre no debe ser Vacio")
        $('#nombres').focus();
		return false
	}

    var apellidos= $("#apellidos").val()
    if(apellidos=="")
    {
        alert("El campo apellidos no debe ser Vacio")
        $('#apellidos').focus();
        return false
    }
    var iddocumento= $("#iddocumento").val()
    $('#iddocumento').focus();
    if(iddocumento==0)
    {
        alert("El campo Tipo Documento no debe ser Vacio")
        return false
    }

    var nrodocumento= $("#nrodocumento").val()
    $('#nrodocumento').focus();
    if(nrodocumento=="")
    {
        alert("El campo Número Documento no debe ser Vacio")
        return false
    }
    var idseguro= $("#idseguro").val()
    $('#idseguro').focus();
    if(idseguro==0)
    {
        alert("El campo Tipo de Seguro no debe ser Vacio")
        return false
    }
    var hclinica= $("#hclinica").val()
    $('#hclinica').focus();
    if(hclinica=="")
    {
        alert("El campo Numero de Historia Clinica no debe ser Vacio")
        return false
    }
    var idtiposexo= $("#idtiposexo").val()
    $('#idtiposexo').focus();
    if(idtiposexo==0)
    {
        alert("El campo Sexualidad no debe ser Vacio")
        return false
    }
    var pais2= $("#pais2").val()
    $('#pais2').focus();
    if(pais2==0)
    {
        alert("El campo Pais no debe ser Vacio")
        return false
    }
    var departamentoB= $("#departamentoB").val()
    $('#departamentoB').focus();
    if(departamentoB==0)
    {
        alert("El campo Departamento no debe ser Vacio")
        return false
    }
    var provinciaB= $("#provinciaB").val()
    $('#provinciaB').focus();
    if(provinciaB==0)
    {
        alert("El campo Provincia no debe ser Vacio")
        return false
    }
    var distritoB= $("#distritoB").val()
    $('#distritoB').focus();
    if(distritoB==0)
    {
        alert("El campo Distrito no debe ser Vacio")
        return false
    } /*
    var sectorB= $("#sectorB").val()
    $('#pais2').focus();
    if(sectorB==0)
    {
        alert("El campo Sector no debe ser Vacio")
        return false
    } */
    if ($('#op').val()==1) {
        validarreferencia()
    } else {
        guardar_datos()
    }
	return true
}

function validarreferencia()
{
    var nrodoc;
    var tdoc;
    tdoc	=	$("#iddocumento").val();
    nrodoc	=	$("#nrodocumento").val();

	if ($("#iddocumento").val()==7 || $("#iddocumento").val()==5 ){
		 guardar_datos()
	}
	else
	{
		$.ajax({
        type:  "POST",
        url:   carpeta+"ver_registro.php",
        data:  "nrodoc="+nrodoc+"&tdoc="+tdoc,
        success:  function (response) {
            var r=response.split("|")
            if(r[1]==1)
            {
                alert('El número de Documento ya se encuentra registrado en la Base de Datos, Por Favor Verificar'),
                $("#nrodocumento").focus()
            }
            else
				{
					guardar_datos()
				}
			}
		});
	}

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
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");

    $.ajax({
            type: "POST",
            url: carpeta+"guardar.php",
            data: $("#user_form").serialize(),
            success: function(data) {
			regresar_index(carpeta)
            }
       });
	ocultarVentana()
}

function remove_rows(idx)
{
	$("#item"+idx).remove()
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
    	"responsive":true, // enable responsive
        "destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": dir+"registros.php",
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if ( aData[5] == "")
                {
                    $('td', nRow).css('background-color', '#f2dede');
                }
            }
    	} );
	} );
}


function cargar_datos_departamentoA(val,seleccion,opc)
{
	if (val==2){
		
		$.ajax({
        type: "POST",
        url:  carpeta+"ubigeo.php",
            success: function(data) {
            $("#div-ubigeo").html(data)
        }
    });
		
		cargar_datos_provinciaA(0,0,2)
		cargar_datos_distritoA(0,0,2)
		//cargar_datos_sectoresA(0,0,2)

		$.ajax({
			type: "POST",
			url:  carpeta_ajax+"departamento.php",
			data:"idpais="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=1",
			success: function(data) {
				$("#div-departamentoB").html(data)
			}
		});
	} else {
		$.ajax({
        type: "POST",
        url:  carpeta+"ubigeo2.php",
            success: function(data) {
            $("#div-ubigeo").html(data)
        }
    });
	}
}

function cargar_datos_provinciaA(val,seleccion,opc)
{
    $.ajax({
        type: "POST",
        url:  carpeta_ajax+"provincia.php",
        data:"iddepartamento="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=1",
        success: function(data) {
            $("#div-provinciaB").html(data)
        }
    });
}
function cargar_datos_distritoA(val,seleccion,opc)
{
    $.ajax({
        type: "POST",
        url:  carpeta_ajax+"distrito.php",
        data:"idprovincia="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=1",
        success: function(data) {
            $("#div-distritoB").html(data)
        }
    });
}
/*
function cargar_datos_sectoresA(val,seleccion,opc)
{
    $.ajax({
        type: "POST",
        url:  carpeta_ajax+"sector.php",
        data:"idsector="+val+"&seleccion="+seleccion+"&opcion="+opc+"&name=3",
        success: function(data) {
            $("#div-sectorB").html(data)
        }
    });
}
*/
