function objetoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }

    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

//funciones de Listar los registros 
function listar_registros(dir) 
{
    //alert(dir)
	if (dir != "#")
	{
		$.getScript(dir+"mantenimiento.js", function(){
		});

		var resultado = document.getElementById('page-wrapper');
		//  resultado.innerHTML = '<br><br><br><center><img src="../img/ajax-loader2.gif"></center>';
		ajax = objetoAjax();
		// ajax.open("GET", "../paginas/lista_alumnos.php", true);
		ajax.open("GET", dir+"index.php", true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4) {
				resultado.innerHTML = ajax.responseText;
				history.pushState(null, "", "../include/main.php");
				table2(dir)
            }
		}
		ajax.send(null); 
	}
}
 
function table2(dir){
//	alert(dir)
    $(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "responsive": true,
        "destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": dir+"registros.php",
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			 if ( aData[7] == "VENCE" ||  aData[8] == "PROCESADO" ||  aData[10] == "PROCESADO")
			{
				$('td', nRow).css('color', 'GREEN');
			} 
				else  if ( aData[8] == "ANULADO" || aData[10] == "ANULADO" ||  aData[8] == "INACTIVO"){
				$('td', nRow).css('color', 'red');
			}
				else  if ( aData[7] == "NO VENCE"){
				$('td', nRow).css('color', 'BLUE');
			}
        },
		"createdRow": function( nRow, aData, type ) {
            if (aData[9] == "ANULADO") {
                $(nRow).hide();
            }
        }
      } )

    } );
}


