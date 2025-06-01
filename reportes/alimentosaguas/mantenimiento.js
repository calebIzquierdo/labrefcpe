var carpeta = "../reportes/alimentosaguas/";
var aja2 = "../ajax/";





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




function buscar_establecimiento()
{
    objindex="Establecimiento"
    var ventana=window.open("../lista/establecimiento/", 'Establecimiento', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}





function excel_ficha()
{
    var fini	=  $("#finicioe").val();
    var ffin	=  $("#ffinale").val();
    /*var idr		=  $("#red").val();
    var idmr	=  $("#idmicrored").val();
    var idests	=  $("#idestablecimiento").val();
    var exm		=  $("#idexamen").val();*/
   
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

