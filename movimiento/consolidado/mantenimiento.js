var carpeta = "../movimiento/consolidado/";
var aja2 = "../ajax/";

function cerrarImpresion()
{
   $('#impresiones').modal().hide();
}

function imprimir(valores)
{
	//var server = window.location.hostname;
	var urlprint = carpeta+valores+"&embedded=true";
	document.all.mostrarpdf.src = urlprint
}

function imprimir_fichaA()
{
    var fini	=  $("#finicioA").val();
    var ffin	=  $("#ffinalA").val();
    var tip_ref	=  $("#idcomprobante").val();

    if (fini==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Inicial")
        return false
    }

    if (ffin==""){
		cerrarImpresion()
        alert("Seleccionar Fecha Final")
		return false
    }
		
	var valores = "imprimir.php?finicio="+fini+"&ffinal="+ffin+"&idcomp="+tip_ref
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


