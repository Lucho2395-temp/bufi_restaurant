function buscar_datos_reporte_movimientos(){
    
    let fecha_desde = $('#fecha_desde').val();
    let fecha_hasta = $('#fecha_hasta').val();
    let boton = "buscar_reporte_movimientos";
    let valor = true;

    valor = validar_campo_vacio('fecha_desde', fecha_desde, valor);
    valor = validar_campo_vacio('fecha_hasta', fecha_hasta, valor);
    
    if(valor){
        let datos = "fecha_desde=" + fecha_desde +
            "&fecha_hasta=" + fecha_hasta;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Reporte/buscar_reporte_movimientos",
            data: datos,
            // contentType: false,
            // cache: false,
            // processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-search text-white-50\"></i> Buscar", false);
                let data = r;
                let body = "";
                console.log(r)
                if (data.length > 0) {
                    let a = 1;
                    data.map(function (el, index) {
                        body +=
                            `
                            <tr>
                                <td>${a}</td>
                                <td>${el.recurso} </td>
                                <td>${el.ingreso} ${el.unidad_original}</td>
                                <td>${el.salida}${el.medida_minima ? ' ' + el.medida_minima : ''}</td>
                                <td>
                                    ${((el.ingreso * el.conversion) - el.salida ) / el.conversion + el.unidad_original}
                                </td>
                            </tr>
                        `
                        a++;
                    });
                }
                $('#cuerpo_tabla_reporte_movimientos').html(body);
            }
        });
    }
}