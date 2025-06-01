var carpeta = "../reportes/kits/";


var listar_matriales = function() {
	
    var table = $('#reporte-ventas').DataTable();    
    table.destroy();
//	var sumaTotal = table.column(5).data().sum();
//	alert(sumaTotal)
    var params = {
        idtm : $('#kits').val(),       
        idlab : $('#estable').val()       
    };
    $.ajax({
        url : carpeta+'kits.php',
        data : params,
        type : 'GET',
        dataType : 'json',
        success : function(response) {
            if (response.length > 0) {
                var body = "";             
                
                response.map(function (objRegistro) {
                    body += `
                        <tr>
                            <td>${objRegistro[0]}</td>
                            <td>${objRegistro[1]}</td>
                            <td>${objRegistro[2]}</td>
                            <td>${objRegistro[3]}</td>
							<td>${objRegistro[4]}</td>                            
							<td>${objRegistro[5]}</td>                            
                        </tr>
                    `;                  
                });
		
                $("#cuerpo-reporte").html(body);

                $('#reporte-ventas').DataTable({
                    "dom": 'Bfrtip',
                    "destroy": true,
                    "buttons": [
                       /* 'excel', 'pdf','csv'*/
                        'excel'
                    ],
                    "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
                    "pageLength": 10,
                    "responsive": true,                   
                    "language": {
                        "searchPlaceholder": "Ingrese criterio",
                        "search": "Buscar : ",
                        "lengthMenu": "Mostrar _MENU_ registros por página",
                        "zeroRecords": "No se encontraron registros",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No existen registros disponibles",
                        "infoFiltered": "(filtrado desde _MAX_ registros totales)",
                        "paginate": {
                            "previous": "Anterior",
                            "next": "Siguiente"
                        }
                    }
                });
               
                //
                $("#tabla-reporte").show();
               
                
            } else {
                $("#tabla-reporte").hide();
                               
                            
            }
        },
        error : function(xhr, status) {
            reject(status);
        },
        complete : function(xhr, status) {
            console.log(status);
        }
    });  
}

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
	var idtm = $('#kits').val();      
    var idlab = $('#estable').val();      
		
	switch(id) {
		case 1:
			cerrarImpresion()
			var valores = "imprimir.php?idtm="+idtm+"&idlab="+idlab
			imprimir(valores);
			
		break;
		case 2:
			cerrarImpresion()
			var valores = "imprimirAedico.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr
			imprimir(valores);
			
		break;
		default:
		//alert(id+"fin "+fini+" fsa "+ffin+" cdr "+cdr+" red "+idr+" mic "+idmr+" est "+idests)
	
			cerrarImpresion()
			var valores = "imp_unidad.php?finicio="+fini+"&ffinal="+ffin+"&idr="+idr+"&idmr="+idmr+"&idests="+idests+"&codp="+cdr
			imprimir(valores);
			
	} 

}



/*
Codigo de ejemplo
https://live.datatables.net/riketele/1/edit
https://live.datatables.net/riketele/3/edit

$(document).ready( function () {
  jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
      if ( typeof a === 'string' ) {
        a = a.replace(/[^\d.-]/g, '') * 1;
      }
      if ( typeof b === 'string' ) {
        b = b.replace(/[^\d.-]/g, '') * 1;
      }
      return a + b;
    }, 0);
  });
  jQuery.fn.dataTable.Api.register( 'sumSpan()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
      if ( typeof a === 'string' ) {
        a = a.replace(/[^\d.-]/g, '') * 1;
      }
      if ( typeof b === 'string' ) {
        var regex = /(\d+)/g;
        b = b.match(regex)[0];
        b = b.replace(/[^\d.-]/g, '') * 1;
      }
      return a + b;
    }, 0);
  });
  var table = $('#example').DataTable(
    {
      drawCallback: function () {
        var api = this.api();
        var total = api.column( 5, {"filter":"applied"}).data().sum();
        $('#monto').html(total);
        var edad = api.column( 3, {"filter":"applied"}).data().sumSpan();
        $('#edad').html(edad);
      }
    });
} );



*/