
function limpiar_(){
    $('#egreso_descripcion').val("");
    $('#egreso_monto').val("");
    $('#movimiento_tipo').val("");
}

$("#agregar_egresos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-agregar-egreso";
    //Extraemos las variable según los valores del campo consultado
    var egreso_descripcion = $('#egreso_descripcion').val();
    var id_sucursal = $('#id_sucursal').val();
    var egreso_monto = $('#egreso_monto').val();
    var movimiento_tipo = $('#movimiento_tipo').val();

    valor = validar_campo_vacio('id_sucursal', id_sucursal, valor);
    valor = validar_campo_vacio('movimiento_tipo', movimiento_tipo, valor);
    valor = validar_campo_vacio('egreso_descripcion', egreso_descripcion, valor);
    valor = validar_campo_vacio('egreso_monto', egreso_monto, valor);

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/guardar_egresos",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Movimiento guardado! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        limpiar_();
                        break;
                    case 2:
                        respuesta('Error al guardar egreso, vuelva a intentarlo', 'error');
                        break;
                    case 3:
                        respuesta(r.result.message, 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});




function eliminar_egreso(id_movimiento){
    var valor = true;
    //Validamos si los campos a usar no se encuentran vacios
    valor = validar_parametro_vacio(id_movimiento, valor);
    if(valor) {
        var boton = "btn-eliminar_egreso" + id_movimiento;
        var cadena = "id_movimiento=" + id_movimiento;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/eliminar_egreso",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, "Eliminando...", true);
            },
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        $('#egresos' + id_movimiento).remove();
                        respuesta('¡Registro Eliminado!', 'success');
                        break;
                    case 2:
                        respuesta('Error al eliminar registro', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}


function editar_egreso(id_movimiento,id_sucursal,movimiento_tipo, egreso_descripcion, egreso_monto){
    $('#id_movimiento').val(id_movimiento);
    $('#id_sucursal_e').val(id_sucursal);
    $('#movimiento_tipo_e').val(movimiento_tipo);
    $('#egreso_descripcion_e').val(egreso_descripcion);
    $('#egreso_monto_e').val(egreso_monto);
}


$("#editar_egresos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    //Definimos el botón que activa la función
    var boton = "btn-editar-egreso";
    //Extraemos las variable según los valores del campo consultado
    var egreso_descripcion_e = $('#egreso_descripcion_e').val();
    var id_sucursal_e = $('#id_sucursal_e').val();
    var movimiento_tipo_e = $('#movimiento_tipo_e').val();
    var egreso_monto_e = $('#egreso_monto_e').val();
    var id_movimiento = $('#id_movimiento').val();

    //Si var valor no ha cambiado de valor, procedemos a hacer la llamada de ajax
    if(valor){
        //Cadena donde enviaremos los parametros por POST
        $.ajax({
            type: "POST",
            url: urlweb + "api/Egreso/editar_egresos",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Movimiento Editado correctamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al editar egreso, vuelva a intentarlo', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});