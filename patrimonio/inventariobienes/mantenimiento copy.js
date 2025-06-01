
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
    if ($('#idtipoingreso').val() == 0) {
        alert("Tipo Ingreso no debe ser Nulo !!!")
        $("#idtipoingreso").focus();
        return
    }

    if ($('#nrorden').val() == "") {
        alert("Numero de Orden no debe ser Nula!!!")
        $("#nrorden").focus();
        return
    }

    if ($('#idproveedor').val() == "") {
        alert("Debe seleccionar Proveeor!!!")
        $("#idproveedor").focus();
        return
    }

    if ($('#idcomprobante').val() == 0) {
        alert("Comprobante no debe ser Nula !!!")
        $("#idcomprobante").focus();
        return
    }

    if ($('#nrocomprobante').val() == 0) {
        alert("Nro Comprobante no debe ser Nula !!!")
        $("#nrocomprobante").focus();
        return
    }
    if (TablaDetalleArray.length == 0) {
        alert("Debe Ingresar almenos 01 Articulo antes de guardar !!!")
        $("#contar_diagnostico2").focus();
        return
    }

    var hoy = new Date();
    var hora = zfill(hoy.getHours(), 2) + ':' + zfill(hoy.getMinutes(), 2) + ':' + zfill(hoy.getSeconds(), 2);
    var dataJson = serializeToJson($("#formHeader").serialize());
    dataJson.detalle = TablaDetalleArray;
    dataJson.Hfecharecepcion += " " + hora;
    console.log(dataJson);
    var opt = $("#op").val()
    var cod = $("#codigo").val()
    console.log("OP:", opt);
    console.log("CODIGO:", cod);
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
            //limpi el array temporal y el localstorage
            TablaDetalleArray = [];
            //Solo se limpiaran en localStorage para los nuevos registros, mas no al momento de realizar ediciones
            if(op=1){
                localStorage.setItem("DetalleArray", "[]");

            }else{
                TablaDetalleArray = ((localStorage.getItem('DetalleArray')) ? JSON.parse(localStorage.getItem('DetalleArray')) : []);
            }
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



function quitar_diagnostico(idx) {
    $("#itemdiagnostico" + idx).remove();

    cuentaItem();
}
function editar_diagnostico(idx) {
    document.getElementById("action").value = "Actualizar";
    //$("action").val("Actualizar");
    //$("action").html("Actualizar");
    //let nombre_material= $("#itemdiagnostico"+idx).getElementById("nombre_material"+idx).innerHTML;
    var mate = $("#mate" + idx).html();
    var mate_text = $("#mate_text" + idx).html();
    var unidad = $("#unidad" + idx).html();
    var tipmate = $("#tipmate" + idx).html();
    var marca = $("#marca" + idx).html();
    cargar_marca(marca);
    var cant = $("#cant" + idx).html();
    var fvence = $("#fvence" + idx).html();
    var estad = $("#estad" + idx).html();
    var series = $("#series" + idx).html();
    var modeloo = $("#modelo" + idx).html();
    var patri = $("#patri" + idx).html();
    var patlab = $("#patlab" + idx).html();
    var pcomp = $("#pcomp" + idx).html();
    var pvent = $("#pvent" + idx).html();
    var lte = $("#lte" + idx).html();
    console.log("Modelo edit:", modeloo, idx);
    $("#material").val(parseInt(mate))
    $("#nombre_material").val(mate_text)
    $("#marca").val(parseInt(marca));
    $("#cantidad").val(parseInt(cant));
    $("#estado").val(parseInt(estad));
    $("#serie").val(series);
    document.getElementById("modelo").value = modeloo;
    $("#modelo").val(modeloo);
    $("#codpatri").val(patri);
    $("#codpatrilab").val(patlab);
    $("#pcompra").val(parseFloat(pcomp));
    $("#pventa").val(parseFloat(pvent));
    $("#unid").val(unidad)
    $("#tipmate").val(tipmate)
    $("#lotes").val(lte);

    //$("#contar_diagnostico").val(count_enf);
    count_edit = idx;
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

//agregar un bueno row al table
function addTable(dataJson) {
    console.log(JSON.stringify(dataJson));
    count_enf++;
    $("#table-detalle").append("<tr id='itemdiagnostico" + count_enf + "'>" +
        "<td>" +
        count_enf +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='idpersonal" + count_enf + "' id='idpersonal" + count_enf + "' value='" + dataJson.idpersonal + "' />" + dataJson.nombre_personal +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='idarea" + count_enf + "' id='idarea" + count_enf + "' value='" + dataJson.idarea + "' />" +
        "<input type='hidden' name='idareatrabajo" + count_enf + "' id='idareatrabajo" + count_enf + "' value='" + dataJson.idareatrabajo + "' />" + dataJson.nombreareatrabajo +
        "</td>" +
        "<td>" +
        "<inpu type='hidden't name='material" + count_enf + "' id='material" + count_enf + "' value='" + dataJson.material + "' />" + dataJson.nombre_material +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='marca" + count_enf + "' id='marca" + count_enf + "' value='" + dataJson.marca + "' />" + dataJson.nombre_marca +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='modelo" + count_enf + "' id='modelo" + count_enf + "' value='" + dataJson.modelo + "' />" + dataJson.nombre_modelo +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='codpatri" + count_enf + "' id='codpatri" + count_enf + "' value='" + dataJson.codpatri + "' />" +
        dataJson.codpatri +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='codpatrilab" + count_enf + "' id='codpatrilab" + count_enf + "' value='" + dataJson.codpatrilab + "' />" +
        dataJson.codpatrilab +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='color" + count_enf + "' id='color" + count_enf + "' value='" + dataJson.color + "' />" + dataJson.color +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='estado" + count_enf + "' id='estado" + count_enf + "' value='" + dataJson.estado + "' />" + dataJson.nombre_estado +
        "</td>" +
        "<td>" +
        "<input type='hidden' name='serie" + count_enf + "' id='serie" + count_enf + "' value='" + dataJson.serie + "' />" +
        "<input type='hidden' name='observacion" + count_enf + "' id='observacion" + count_enf + "' value='" + dataJson.observacion + "' />" + dataJson.serie +
        "</td>" +
        "<td>" +
        "<button type='button'  data-backdrop='static' data-keyboard='false' onclick='eliminar_item(" + count_enf + ","+$("#op").val()+")' class='btn btn-outline btn-danger btn-primary btn-xs'>Anular</button>" +
        "</td>" +

        "</tr>"
    );
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
    //agregar row al array
    TablaDetalleArray.push(dataJson);

    console.log(TablaDetalleArray);
    //actualiza el locarstorage
    localStorage.setItem("DetalleArray", JSON.stringify(TablaDetalleArray));


    addTable(dataJson);
    //limpia || reinicia los inputs del detalle
    //$("#formDetalle")[0].reset();
    resetDetalle();

}
//paso la opcion por que quiero que se chanque el localStorage
//solo con los detalles de un nuevo registro mas lo con lo de edicion
function eliminar_item(valor, op) {
    count_enf = 0;
    //TablaDetalleArray = [];

    var items = TablaDetalleArray;
    items.splice(valor - 1, 1);
    TablaDetalleArray = items;
    if(op==1){
        localStorage.setItem("DetalleArray", JSON.stringify(items));

    }
    $("#table-detalle").empty();
    items.forEach(d => addTable(d));
}

