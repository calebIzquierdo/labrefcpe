var carpeta = "../reportes/muestra/";
var aja2 = "../ajax/";

function cerrarImpresion()
{
   $('#impresiones').modal().hide();
}

function imprimir(valores)
{
	var server = window.location.hostname;
	//var urlprint = "http://"+server+"/referencias/hospitalizacion/paciente/imprimir.php?nromovimiento="+nro+"&embedded=true";
	// var urlprint = carpeta+"imprimir.php?nromovimiento="+nro+"&embedded=true";
	var urlprint = carpeta+valores+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}

function imprimir_fichaA()
{
    var fini	=  $("#finicioA").val();
    var ffin	=  $("#ffinalA").val();
    var tip_ref	=  $("#area").val();

    if (fini==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Inicial")
        return false
    }

    if (ffin==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Final")
		return true
    }
		
	var valores = "imp_unidad.php?finicio="+fini+"&ffinal="+ffin+"&ida="+tip_ref
	imprimir(valores);
	
}
function imprimir_ficha()
{
    var fini	=  $("#finicio").val();
    var ffin	=  $("#ffinal").val();
    var tip_ref	=  $("#idtiporeferencia").val();

    if (fini==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Inicial")
        return false
    }

    if (ffin==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Final")
		return true
    }
		
	var valores = "imprimir.php?finicio="+fini+"&ffinal="+ffin+"&tp_ref="+tip_ref
	imprimir(valores);
	
}

//funciones de Listar los registros 
function regresar_index(dir) {
	
		var resultado = document.getElementById('page-wrapper');
		ajax = objetoAjax();
		ajax.open("GET", dir+"index.php", true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4) {
				resultado.innerHTML = ajax.responseText;
				//recarga2(dir)
			}
		}
		ajax.send(null); 

}

function imprimir_origen(test)
{

    var fini	=  $("#finicio2"+test).val();
    var ffin	=  $("#ffinal2"+test).val();
    var tip_orig	=  $("#idestablecimiento"+test).val();
    var est	= test;


    if (tip_orig=="") {
		cerrarImpresion()
        alert("Seleccionar Origen de la Referencia")
        $("#idestablecimiento"+test).focus();
        return false
		
    }
    if (fini==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Inicial")
        $("#finicio2"+test).focus();
        return false
		
    }

    if (ffin==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Final")
        $("#ffinal2"+test).focus();
        return false
		
    }

   // var ventana= window.open(carpeta+"origen.php?finicio="+fini+"&ffinal="+ffin+"&tp_ref="+tip_orig+"&estad="+est,800,950)
	var valores = "origen.php?finicio="+fini+"&ffinal="+ffin+"&tp_ref="+tip_orig
	imprimir(valores);
}


function buscar_establecimiento()
{
    objindex="Establecimiento"
    var ventana=window.open("../lista/establecimiento/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

function buscar_paciente()
{
    objindex="Paciente"
    var ventana=window.open("../lista/pacientes/", 'Paciente', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}


function recibir(id,nombre,coddiad)
{

    if(objindex=="Establecimiento")
    {
        $("#idestablecimiento1").val(id)
        $("#nombre_establecimiento").val(nombre+" - "+coddiad)
    }

   
	if(objindex=="Paciente")
    {
		var cadena = nombre
		var separa = cadena.split(";");
		var apellido = separa[0];
		
        $("#idpaciente").val(coddiad)
        $("#apellidos").val(apellido)
        $("#nombre_paciente").val(coddiad+" - "+nombre)
    }
}


function excel_ficha()
{
    var fini	=  $("#finicioe").val();
    var ffin	=  $("#ffinale").val();
    var idr		=  $("#red").val();
    var idmr	=  $("#idmicrored").val();
    var idests	=  $("#idestablecimiento").val();
    var exm		=  $("#idexamen").val();
   
    if (fini==""){
        alert("Seleccionar Fecha Inicial")
        return false
    }

    if (ffin==""){
        alert("Seleccionar Fecha Final")
        return false
    }

    window.open(carpeta+"excel.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&exam="+exm)
    window.close()
    return true
}


function cargar_microred(cod)
{
	$.ajax({
            type: "POST",
            url: aja2+"microredA.php",
            data: "codi="+cod,
            success: function(data) {
            $("#div-microred").html(data)
            }
       });
}

function cargar_estable(cod,estable)
{
	$.ajax({
            type: "POST",
            url: aja2+"establecimientoA.php",
            data: "microred="+cod,
            success: function(data) {
            $("#div-establecimiento").html(data)
            }
       });
}


/*
function imprimir_fichaS()
{
    var fini	=  $("#finicioS").val();
    var ffin	=  $("#ffinalS").val();
    var tip_ref	=  $("#idtiporeferenciaS").val();

    if (fini==""){
        alert("Seleccionar Fecha Inicial")
        return false
    }

    if (ffin==""){
        alert("Seleccionar Fecha Final")
        return false
    }

    var ventana= window.open(carpeta+"imprimirS.php?finicio="+fini+"&ffinal="+ffin+"&tp_ref="+tip_ref,800,950)
}

function imprimir_fichaE()
{
    var fini	=  $("#finicioE").val();
    var ffin	=  $("#ffinalE").val();
    var tip_ref	=  $("#idtiporeferenciaE").val();

    if (fini==""){
        alert("Seleccionar Fecha Inicial")
        return false
    }

    if (ffin==""){
        alert("Seleccionar Fecha Final")
        return false
    }

    var ventana= window.open(carpeta+"imprimir_enviado.php?finicio="+fini+"&ffinal="+ffin+"&tp_ref="+tip_ref,800,950)
}


function imprimir_fichaEs()
{
    var fini	=  $("#finicioEs").val();
    var ffin	=  $("#ffinalEs").val();
    var tip_ref	=  $("#idtiporeferenciaEs").val();

    if (fini==""){
        alert("Seleccionar Fecha Inicial")
        return false
    }

    if (ffin==""){
        alert("Seleccionar Fecha Final")
        return false
    }

    var ventana= window.open(carpeta+"imprimir_enviado_s.php?finicio="+fini+"&ffinal="+ffin+"&tp_ref="+tip_ref,800,950)
}
function imprimir_fichaP()
{
    var fini	=  $("#finicioP").val();
    var ffin	=  $("#ffinalP").val();
    var tip_ref	=  $("#idtiporeferenciaP").val();
    var pob		=  $("#idpoblacion").val();
    var up		=  $("#idups").val();

    if (tip_ref==0){
	$("#idtiporeferenciaP").focus();
        alert("Seleccionar Tipo Referencia")
        return false
    }
	if (pob==0){
        alert("Seleccionar Población")
		$("#idpoblacion").focus();
        return false
    }

	if (fini==""){
        alert("Seleccionar Fecha Inicial")
        return false
    }
	
    if (ffin==""){
        alert("Seleccionar Fecha Final")
        return false
    }

    var ventana= window.open(carpeta+"poblacion_recib.php?finicio="+fini+"&ffinal="+ffin+"&tp_ref="+tip_ref+"&pob="+pob+"&ups="+up,800,950)
}


function imprimir_fichaEnv()
{
    var fini	=  $("#finicioEnv").val();
    var ffin	=  $("#ffinalEnv").val();
    var tip_ref	=  $("#idtiporeferenciaEnv").val();
    var pob		=  $("#idpoblacionEnv").val();
    var up		=  $("#upsdestino").val();

    if (tip_ref==0){
	$("#idtiporeferenciaEnv").focus();
        alert("Seleccionar Tipo Referencia")
        return false
    }
	if (pob==0){
        alert("Seleccionar Población")
		$("#idpoblacionEnv").focus();
        return false
    }

	if (fini==""){
        alert("Seleccionar Fecha Inicial")
		$("#finicioEnv").focus();
        return false
    }
	
    if (ffin==""){
        alert("Seleccionar Fecha Final")
		$("#ffinalEnv").focus();
        return false
    }

    var ventana= window.open(carpeta+"poblacion_envio.php?finicio="+fini+"&ffinal="+ffin+"&tp_ref="+tip_ref+"&pob="+pob+"&ups="+up,800,950)
}


function imprimir_xpaciente()
{

    var fini	=  $("#finicio3").val();
    var ffin	=  $("#ffinal3").val();
	var tipo	=  $("#idtipo").val();
	
	if ($("#idtipo").val()==1){
		 var idpaciente	=  $("#apellidos").val();
	}else {
		 var idpaciente	=  $("#idpaciente").val();
	}
   
    if (idpaciente=="") {
        alert("Seleccionar Nombre del Paciente")
        $("#idestablecimiento"+test).focus();
        return false
    }
    if (fini==""){
        alert("Seleccionar Fecha Inicial")
        $("#finicio3").focus();
        return false
    }

    if (ffin==""){
        alert("Seleccionar Fecha Final")
        $("#ffinal3").focus();
        return false
    }

    var ventana= window.open(carpeta+"paciente.php?finicio="+fini+"&ffinal="+ffin+"&idpaciente='"+idpaciente+"'&tp_ref="+tipo,800,950)
}

function AbrirPopup(url,width,height)
{
    var ventana=window.open(url, 'Buscar', 'width='+width+', height='+height+', resizable=yes, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}

*/