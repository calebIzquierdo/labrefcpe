<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

?> 


<!DOCTYPE html>
<html>

	
	<head>
	<meta charset="utf-8">
	 <!-- jQuery -->
    <script src="<?=$path?>bootstrap/vendor/jquery/jquery.min.js"></script>

	<!-- BS JavaScript -->
	<script type="text/javascript" src="<?=$path?>bootstrap/vendor/bootstrap/js/bootstrap.js"></script>

	<!-- Bootstrap Core CSS -->
    <link href="<?=$path?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=$path?>bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=$path?>bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

   
   	<!-- DataTables JavaScript -->
    <script src="<?=$path?>bootstrap/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?=$path?>bootstrap/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?=$path?>bootstrap/vendor/datatables-responsive/dataTables.responsive.js"></script>
     <!-- DataTables CSS -->
    <link href="<?=$path?>bootstrap/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?=$path?>bootstrap/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


<script type="text/javascript" language="javascript" >
	var carpeta = "../../lista/pacientes/"
	var carpeta_ajax = "../../ajax/"
	
	$(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "responsive": true,
        "destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": "registros.php"
      } );
    } );

function mostrarVentana()
{
   $('#userModal').modal('show');
}

function ocultarVentana()
{
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


function guardar_datos()
{
    $( "#action" ).prop( "disabled", true );
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");

    $.ajax({
            type: "POST",
            url: carpeta+"guardar.php",
            data: $("#user_form").serialize(),
            success: function(data) {
			recarga2(carpeta)
            }
       });
	ocultarVentana()
}

	//funciones de Listar los registros 

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
	ocultarVentana()
//	window.location.reload();
}


	function enviar(id,index)
	{
		window.opener.recibir(id,$("#apellidos"+index).val()+"; "+$("#nombres"+index).val(),$("#dni"+index).val())
		window.close()
	}
	
	 function esNumero(strNumber) {
        if (strNumber == null) return false;
        if (strNumber == undefined) return false;
        if (typeof strNumber === "number" && !isNaN(strNumber)) return true;
        if (strNumber == "") return false;
        if (strNumber === "") return false;
        var psInt, psFloat;
        psInt = parseInt(strNumber);
        psFloat = parseFloat(strNumber);
        return !isNaN(strNumber) && !isNaN(psFloat);
    }

    function CalcularEdad(fecha) {
   
        // Si la fecha es correcta, calculamos la edad

        if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
            fecha = formatDate(fecha, "dd/mm/yyyy");
        }

        var values = fecha.split("/");
        var dia = values[0];
        var mes = values[1];
        var ano = values[2];

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth() + 1;
        var ahora_mes1 = fecha_hoy.getMonth() ;
        var ahora_dia = fecha_hoy.getDate();
	
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }

        // calculamos los meses
        var meses = 0;

        if (ahora_mes > mes && dia > ahora_dia)
            meses = ahora_mes - mes - 1;
        else if (ahora_mes > mes)
            meses = ahora_mes - mes
        if (ahora_mes < mes && dia < ahora_dia)
            meses = 12 - (mes - ahora_mes);
        else if (ahora_mes < mes)
            meses = 12 - (mes - ahora_mes + 1);
        if (ahora_mes == mes && dia > ahora_dia)
            meses = 11;

        // calculamos los dias
        var dias = 0;
        if (ahora_dia > dia)
            dias = ahora_dia - dia;
        if (ahora_dia < dia) {
            ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
        }
        document.getElementById('edadactual').value = edad + " Año(s), " + meses + " m"

     //   return edad + " años, " + meses + " meses y " + dias + " días";
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
    }
		guardar_datos();
  	return true
}



</script>
<style>
    table,  td {
        border: 0px solid black;
     /*   font-family: "Times New Roman", serif; */
        font-size: 12px;
    }
    th{
        /* el tamaño por defecto es 14px
      color:#456789; */
        font-size:12px;
    }
    .card-columns {
    media-breakpoint-only(lg) {
        column-count: 1;
    }
    
    }

.vcenter {
    display: inline-block;
    vertical-align: middle;
    float: none;
}
</style>

	</head>
	<!-- <body onload="loader()">  -->
	<body >
	<div id="buscarpaciente" name="buscarpaciente"  >
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-heading">
             <!-- /.panel-heading -->
		
			<h1 class="page-header">Lista de Pobladores  </h1>
			<div align="left">
			<button type="button" id="add_button" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="cargar_form(1,0)" data-target="#userModal" class="btn btn-info btn-lg">Nuevo Paciente</button>
            <!-- 
			<button type="button" id="add_button" name="add_button"  onclick="nuevo(1,0)" class="btn btn-info btn-lg">Nuevo Paciente</button>
			-->
         	</div>
			</br>
			
			<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead class="thead-inverse">
			<tr>
				<th>#</th>
				<th>D.N.I</th>
				<th>APELLIDOS</th>
				<th>NOMBRES</th>
				<th>H.CLINICA</th>
				<th>Seguro</th>
				<th>Editar</th>
				<th>Aceptar</th>
			</tr>

			</thead>
			
			</table> 
            </div>
            </div>
        </div>
    </div>


	
	<div id="userModal" name="userModal" class="modal fade">
	<div class="modal-dialog">
		<div id="modal-body" name="modal-body"> 
		
		</div>

		</div>
	</div>
</div>

</body>
	
<link rel="stylesheet" media="screen" href="<?=$path?>bootstrap/fecha/css/bootstrap-datetimepicker.min.css" >
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/date_es.js" charset="UTF-8"></script>

<script>
 //   cargar_datos_departamentoA("<?php $d=0;isset($row[1]["idpais"])?$d=$row[1]["idpais"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0; echo $d; ?>",2)
 //   cargar_datos_provinciaA("<?php $d=0;isset($row[1]["iddepartamento"])?$d=$row[1]["iddepartamento"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0; echo $d; ?>",2)
 //   cargar_datos_distritoA("<?php $d=0;isset($row[1]["idprovincia"])?$d=$row[1]["idprovincia"]:$d=0;echo $d; ?>","<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>",2)
 //   cargar_datos_sectoresA("<?php $d=0;isset($row[1]["iddistrito"])?$d=$row[1]["iddistrito"]:$d=0; echo $d; ?>","<?php $d=0;isset($row[1]["idsector"])?$d=$row[1]["idsector"]:$d=0; echo $d; ?>",2)

    // $( "#tabs" ).tabs();
</script>
</html>




