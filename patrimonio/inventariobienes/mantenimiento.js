
var carpeta = "../patrimonio/inventariobienes/";
var aja2 = "../ajax/";
// se asigna el valor de la tabla temporal si existe o no datos en el localstorage
var TablaDetalleArray = ((localStorage.getItem('DetalleArray')) ? JSON.parse(localStorage.getItem('DetalleArray')) : []);
function mostrarVentana() {
    var ventana = document.getElementById('userModal'); // Accedemos al contenedor
}

function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del número */
    var length = number.toString().length; /* Largo del número */
    var zero = "0"; /* String de cero */

    if (width <= length) {
        if (number < 0) {
            return ("-" + numberOutput.toString());
        } else {
            return numberOutput.toString();
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString());
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString());
        }
    }
}
function ocultarVentana() {
    $('#userModal').modal('hide'); // Este es lo mas practivo y menos codigo para ocultar el formulario 

}

function cerrarImpresion() {
    $('#impresiones').modal('hide');
}


function cargar_form(op, cod) {
    console.log("op:" + op, "cop:" + cod);
    console.log((op == 1) ? "crear" : "Editar");
    $.ajax({
        type: "POST",
        url: carpeta + "form-mantenimiento.php",
        data: "op=" + op + "&cod=" + cod,
        success: function (data) {
            mostrarVentana();
            $('#modal-body').html(data)
        }
    });

}

function cargar_form_bienes(op, cod) {
    console.log("op:" + op, "cop:" + cod);
    console.log((op == 1) ? "crear" : "Editar");
    $.ajax({
        type: "POST",
        url: carpeta + "form-mantenimiento_bienes.php",
        data: "op=" + op + "&cod=" + cod,
        success: function (data) {
            mostrarVentana();
            $('#modal-body').html(data)
        }
    });

}

function anular_form(op, cod) {
    console.log("op:" + op, "cop:" + cod);
    $.ajax({
        type: "POST",
        url: carpeta + "form-mantenimiento.php",
        data: "op=" + op + "&cod=" + cod,
        success: function (data) {
            mostrarVentana();
            $('#modal-body').html(data)
        }
    });
}

function validarHeader() {
    if ($('#idunidadejec').val() == "") {
        alert("La unidad ejecutora no debe ser Nulo!!!")
        $("#idred").focus();
        return
    }
    if ($('#idred').val() == "") {
        alert("La red no debe ser Nulo!!!")
        $("#idred").focus();
        return
    }
    if ($('#idmicrored').val() == "") {
        alert("La microred no debe ser Nulo!!!")
        $("#idmicrored").focus();
        return
    }
    if ($('#idestablecimiento').val() == "") {
        alert("El establecimiento no debe ser Nulo!!!")
        $("#idestablecimiento").focus();
        return
    }

    var hoy = new Date();
    var hora = zfill(hoy.getHours(), 2) + ':' + zfill(hoy.getMinutes(), 2) + ':' + zfill(hoy.getSeconds(), 2);
    var dataJson = serializeToJson($("#formHeader").serialize());
    
    dataJson.Hfecharecepcion += " " + hora;
    console.log(dataJson);
    var opt = $("#op").val()
    var cod = $("#codigo").val()

    if (opt != 3) {
        guardar_datos(dataJson,opt);
    } else {
        var res = confirm("¿Desea Anular la referencia Nª " + cod + " ?")
        if (res == false) {
            regresar_index(carpeta, op)
            ocultarVentana()
        }
        else {
            guardar_anulado()
        }
    }
    return true
}


function guardar_anulado() {
    $("#action").prop("disabled", true);
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... " + "<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta + "anular.php",
        data: $("#user_form").serialize(),
        success: function (data) {
            // 	alert(data)
            regresar_index(carpeta)
        }
    });
    ocultarVentana()
}
//envia los datos a guardar
//paso la opcion por que quiero que se chanque el localStorage
//solo con los detalles de un nuevo registro mas lo con lo de edicion
function guardar_datos(data,op=1) {
    //console.log("carpeta", carpeta);
    $("#action").prop("disabled", true);
    $(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... " + "<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta + "guardar.php",
        data: data,
        success: function (data) {
            regresar_index(carpeta);
        }
    });
    ocultarVentana()
}
//paso la opcion por que quiero que se chanque el localStorage
//solo con los detalles de un nuevo registro mas lo con lo de edicion
function regresar_index(dir, op=1) {
    //reinicia el detalle con los datos de json al cerrar modal
    if(op=1){
        TablaDetalleArray = ((localStorage.getItem('DetalleArray')) ? JSON.parse(localStorage.getItem('DetalleArray')) : []);
            
    }
     
    var resultado = document.getElementById('page-wrapper');
    ajax = objetoAjax();
    ajax.open("GET", dir + "index.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            resultado.innerHTML = ajax.responseText;
            recarga2(dir)
        }
    }
    ajax.send(null);
}

function recarga2(dir) {
    console.log("recarga tabla", dir);
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [[0, "asc"]],
            "ajax": dir + "registros.php",
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData[9] == "PROCESADO") {
                    $('td', nRow).css('color', 'GREEN');
                } else if (aData[9] == "ANULADO") {
                    $('td', nRow).css('color', 'red');
                }
            }
        });
    });
}

function anular_referencia(id, nref) {
    var res = confirm("¿Desea Anular la referencia Nª " + nref + " ?")
    if (res == false) {
        return false
    }
    else {
        $.ajax({
            type: "POST",
            url: carpeta + "anular.php",
            data: "anulado=" + id + "&numero=" + nref,
            success: function (data) {
                regresar_index(carpeta)
            }
        });
    }
}


function buscar_personal() {
    objindex = "Personal"
    var ventana = window.open("../lista/personal/", 'Personal', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}
function buscar_material() {
    objindex = "Materiales"
    var ventana = window.open("../lista/material/", 'Materiales', 'width=980,height=600,resizable=no, scrollbars=yes, status=yes,location=yes');
    ventana.focus();
}


function cuentaItem() {
    var diag = 0;
    $("#contar_diagnostico2").val(diag);
    for (var i = 1; i <= $("#contar_diagnostico").val(); i++) {
        if (typeof ($("#idmaterial" + i).val()) != 'undefined') {
            diag++;
            $("#contar_diagnostico2").val(diag);
        }
    }
}


function recibir(id, nombre, coddiad) {
    if (objindex == "Personal") {
        $("#idpersonal").val(id)
        $("#nombre_personal").val(coddiad + " - " + nombre)
    }

    if (objindex == "Materiales") {
        $("#material").val(id)
        $("#nombre_material").val(nombre)

        var depd = coddiad;
        var res = depd.split("|");
        var tipmat = res[0];
        var unid = res[1];

        $("#unid").val(unid)
        $("#tipmate").val(tipmat)

    }

}
function cargar_estado(id) {
    $("#nombre_estado").val(id.split("-")[1]);
    $("#estado").val(id.split("-")[0]);
}
function cargar_marca(id) {
    $("#nombre_marca").val(id.split("-")[1]);
    $("#marca").val(id.split("-")[0]);
    $.ajax({
        type: "POST",
        url: carpeta + "modelo.php",
        data: "idmarca=" + id.split("-")[0],
        success: function (data) {
            $("#div-modelo").html(data)
        }
    });
}
function cargar_modelo(id) {
    $("#modelo").val(id.split("-")[0]);
    $("#nombre_modelo").val(id.split("-")[1]);
}
function solonumeros(e) {
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57)
        e.preventDefault();
}
function mayuscula(e) {
    e.value = e.value.toUpperCase();
}
function cargar_areatrabajo(id) {
    $("#idareatrabajo").val(id.split("-")[0]);
    $("#idarea").val(id.split("-")[1]);
    $("#nombre_areatrabajo").val(id.split("-")[2]);
    console.log(id.split("-"));
}
function cargar_subarea(id) {

    $.ajax({
        type: "POST",
        url: carpeta + "subarea.php",
        data: "idarea=" + id,
        success: function (data) {
            $("#div-subarea").html(data)
        }
    });
}
//parse el serialize a json
function serializeToJson(serialize) {
    var data = serialize.split("&");
    var obj = {};
    for (var key in data) {
        obj[data[key].split("=")[0]] = data[key].split("=")[1].replaceAll('%20', ' ').replaceAll('%2F', '-');
    }
    return obj;
}


//reinicia los inputs de detalleArray
function resetDetalle() {
    //reinicila los inputs visibles y los no visibles
    //como: idpersonal, tipmate; los cuales validan si el responsable y el tipo de material fueron
    //seleccionados
    //**CONTENIDO */
    $('#nombre_material').val('');
    $('#codpatri').val('');
    $('#codpatrilab').val('');
    $('#color').val('');
    $('#serie').val('');
    $('#observacion').val('');

}
//Valida los campo requeridos del detalle
function validarDetalle() {
    if (!$("#idpersonal").val()) {
        alert("Seleccione el responsable");
        $("#nombre_personal").focus();
        return;
    }
    if (!$("#tipmate").val()) {
        alert("Seleccione el tipo de material");
        $("#nombre_material").focus();
        return;
    }
    var dataJson = serializeToJson($("#formDetalle").serialize());
    //registrar en la bd
    console.log(dataJson);
    $( "#action" ).prop( "disabled", true );
    //$(".upload-msg").html("Guardando... Por favor espere que se cierre el formulario, tardará de acuerdo a la conexion de la red... "+"<img src='../img/avance.gif' />");
    $.ajax({
        type: "POST",
        url: carpeta+"guardar_detalle.php",
        data: dataJson,
		success: function(data) {            
            console.log(data);
        }
    });
    addTable(dataJson);

}


//agregar un bueno row al table
function addTable(dataJson) {
    
    count_enf++;
    $("#table-detalle").append("<tr id='itemdiagnostico" + count_enf + "'>" +
            "<td>" + count_enf + "</td>" +
            "<td>" + dataJson.nombre_personal + "</td>" +
            "<td>" + dataJson.nombreareatrabajo + "</td>" +
            "<td>" + dataJson.nombre_material + "</td>" +
            "<td>" + dataJson.nombre_marca + "</td>" +
            "<td>" + dataJson.nombre_modelo + "</td>" +
            "<td>" + dataJson.codpatri + "</td>" +
            "<td>" + dataJson.codpatrilab + "</td>" +
            "<td>" + dataJson.color + "</td>" +
            "<td>" + dataJson.nombre_estado + "</td>" +
            "<td>" + dataJson.serie + "</td>" +
            "<td>" + 
            "<button type='button'  data-backdrop='static' data-keyboard='false' onclick='eliminar_item(" + count_enf + ","+$("#op").val()+")' class='btn btn-outline btn-danger btn-primary btn-xs'>Quitar</button>" +
            "</td>" +

        "</tr>"
    );
}

//paso la opcion por que quiero que se chanque el localStorage
//solo con los detalles de un nuevo registro mas lo con lo de edicion
function eliminar_item(valor, idx) {
    $.ajax({
        type: "POST",
        url: carpeta+"guardar_detalle.php",
        data: "op=" + 2 + "&cod=" + valor,
		success: function(data) {            
            console.log(data);
        }
    });
    $("#itemdiagnostico"+idx).remove();

	//cuentaItem();
}


