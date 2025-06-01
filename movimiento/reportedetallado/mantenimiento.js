var carpeta = "../movimiento/reportedetallado/";


var listar_matriales = function() {
    
     
    var table = $('#reporte-ventas').DataTable();    
    table.destroy();

    var params = {
        idcomprobante : $('#idcomprobante').val(), 
        finicioA : $('#finicioA').val(),
        ffinalA : $('#ffinalA').val()   
    };
    $.ajax({
        url : carpeta+'pagos.php',
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
                            <td>${objRegistro[6]}</td>
                            <td>${objRegistro[7]}</td>  
                            <td>${objRegistro[8]}</td>
                            <td>${objRegistro[9]}</td>
                            <td>${objRegistro[10]}</td>
                            <td>${objRegistro[11]}</td>  
                            <td>${objRegistro[12]}</td>
                            <td>${objRegistro[13]}</td>
                            <td>${objRegistro[14]}</td>
                            <td>${objRegistro[15]}</td>
                            <td>${objRegistro[16]}</td>
                            <td>${objRegistro[17]}</td>                               
                        </tr>
                    `;                  
                });
                

                $("#cuerpo-reporte").html(body);

                $('#reporte-ventas').DataTable({
                    "dom": 'Bfrtip',
                    "destroy": true,
                    "buttons": [
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


