var carpeta = "../reportes/entomologia/";
var aja2 = "../ajax/";

function cerrarImpresion()
{
   $('#modal').modal().hide();
}

function imprimir(valores)
{
	var urlprint = carpeta+valores+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}

function imprimir_ficha(id)
{
    var fini	=  $("#finicio"+id).val();
    var ffin	=  $("#ffinal"+id).val();
    var cdr		=  $("#codparamae"+id).val();
    var idr		=  $("#red"+id).val();
    var idmr	=  $("#idmicrored"+id).val();
    var idests	=  $("#idestablecimiento"+id).val();
	

    if (fini==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Inicial")
        return 
    }

    if (ffin==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Final")
		return 
    }
	
	if (cdr==0){
		cerrarImpresion()
        alert("Seleccionar N° Reporte")
		$("#codparamae").infocus();
		return 
    }
	switch(id) {
		case 1:
			cerrarImpresion()
			var valores = "imprimirAedico.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr
			imprimir(valores);
			/*
			window.open(carpeta+"imprimir.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr)
			window.close()
			cerrarImpresion()
			return true
			*/
		break;
		case 2:
			cerrarImpresion()
			var valores = "imprimirAedico.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr
			imprimir(valores);
			/*window.open(carpeta+"imprimirAedico.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr)
			window.close()
			cerrarImpresion()
			return true
			*/
		break;
		default:
		//alert(id+"fin "+fini+" fsa "+ffin+" cdr "+cdr+" red "+idr+" mic "+idmr+" est "+idests)
	
			cerrarImpresion()
			var valores = "imp_unidad.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr
			imprimir(valores);
			/*window.open(carpeta+"imp_unidad.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr)
			window.close()
			cerrarImpresion()
			return true
			*/
	} 


	/*
	var valores = "imprimirAedico.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr
	imprimir(valores);
	*/
	
	
}

function ficha_excel(id)
{
    var fini	=  $("#finicio"+id).val();
    var ffin	=  $("#ffinal"+id).val();
    var cdr		=  $("#codparamae"+id).val();
    var idr		=  $("#red"+id).val();
    var idmr	=  $("#idmicrored"+id).val();
    var idests	=  $("#idestablecimiento"+id).val();
		

    if (fini==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Inicial")
        return 
    }

    if (ffin==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Final")
		return 
    }
	
	if (cdr==0){
		cerrarImpresion()
        alert("Seleccionar N° Reporte")
		$("#codparamae"+id).infocus();
		return 
    }
	if (id==1){
		cerrarImpresion()
		window.open(carpeta+"excel.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr)
		window.close()
		cerrarImpresion()
	return true
	}else {
		cerrarImpresion()
		window.open(carpeta+"excelAedico.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr)
		window.close()
		cerrarImpresion()
		return true
	}

	
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


function cargar_microredB(cod)
{
	$.ajax({
            type: "POST",
            url: aja2+"microredB.php",
            data: "codi="+cod,
            success: function(data) {
            $("#div-microredB").html(data)
            }
       });
}

function cargar_estableB(cod,estable)
{
	$.ajax({
            type: "POST",
            url: aja2+"establecimientoB.php",
            data: "microred="+cod,
            success: function(data) {
            $("#div-establecimientoB").html(data)
            }
       });
}


function cargar_microredC(cod)
{
	$.ajax({
            type: "POST",
            url: aja2+"microredC.php",
            data: "codi="+cod,
            success: function(data) {
            $("#div-microredC").html(data)
            }
       });
}

function cargar_estableC(cod,estable)
{
	$.ajax({
            type: "POST",
            url: aja2+"establecimientoC.php",
            data: "microred="+cod,
            success: function(data) {
            $("#div-establecimientoC").html(data)
            }
       });
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
   
    if (fini==""){
        alert("Seleccionar Fecha Inicial")
        return false
    }

    if (ffin==""){
        alert("Seleccionar Fecha Final")
        return false
    }

    window.open(carpeta+"excel.php?finicio="+fini+"&ffinal="+ffin)
    window.close()
    return true
}

