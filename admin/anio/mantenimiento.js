
var carpeta = "../admin/anio/";
var aja2 =  "../ajax/";

function validar()
{
    var res=confirm("¿Desea Generar el nuevo Periodo ?")
    if(res)
    {
		guardar_datos()
		
    }
	return false
	
}

function guardar_datos()
{
  
    $.ajax({
        type: "POST",
        url: carpeta+"guardar.php",
        data: $("#frmguardar").serialize(),
		success: function(data) {
        regresar_index(carpeta)
        }
    });
}

function regresar_index(dir)
{
    var resultado = document.getElementById('page-wrapper');
    ajax = objetoAjax();
    ajax.open("GET", dir+"index.php", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
          //  recarga2(dir)
        }
    }
    ajax.send(null);
}
