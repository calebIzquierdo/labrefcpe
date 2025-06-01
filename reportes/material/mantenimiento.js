var carpeta = "../reportes/material/";


var listar_matriales = function() {
    
     
    var table = $('#reporte-ventas').DataTable();    
    table.destroy();

    var params = {
        idtm : $('#tipomaterial').val()       
    };
    $.ajax({
        url : carpeta+'material.php',
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
                        </tr>
                    `;                  
                });
                

                $("#cuerpo-reporte").html(body);

                $('#reporte-ventas').DataTable({
                    "dom": 'Bfrtip',
                    "destroy": true,
                    "buttons": [
                        'excel', 'pdf'
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


