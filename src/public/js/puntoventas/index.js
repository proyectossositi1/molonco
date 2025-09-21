$(document).ready(function () {
    init({
        datatable: {
            id: '#datatable'
        }
    });

    $('#metodopago-efectivo, #metodopago-tarjeta').css('display', 'none');
    $('#cantidad').on('input', recalcular);
    $('#pago_cliente').on('input', recalcular_cambio);

    $('#buscador_productos').on('keydown', function (e) {
        if (e.key !== 'Enter') return;
        filter_prodcutos(this.value);
    });
});

const search_producto = () => {
    filter_prodcutos();
}

function filter_prodcutos(qRaw) {
    const $sel = $('#id_producto');
    if ($.fn.selectpicker) $sel.selectpicker({ liveSearchNormalize: true });

    const q = String(qRaw || $('#buscador_productos').val()).trim().toLowerCase();
    if (!q) return false;

    const $opts = $sel.find('option[value!=""]'); // ignora placeholder

    // 1) exacto por código de barras -> 2) exacto por SKU -> 3) contiene
    let $match = $opts.filter((i, el) => (el.dataset.codigo_barras || '').toLowerCase() === q);
    if (!$match.length) $match = $opts.filter((i, el) => (el.dataset.sku || '').toLowerCase() === q);
    if (!$match.length) {
        $match = $opts.filter((i, el) => {
            const d = el.dataset, txt = (el.textContent || '').toLowerCase();
            return txt.includes(q) ||
                (d.codigo_barras || '').toLowerCase().includes(q) ||
                (d.sku || '').toLowerCase().includes(q);
        });
    }

    if ($match.length) {
        const value = $match.first().val();
        if ($.fn.selectpicker) $sel.selectpicker('val', value);
        else $sel.val(value).trigger('change');
        $sel.trigger('producto:update');
        return true;
    } else {
        if ($.fn.selectpicker) $sel.selectpicker('val', '');
        else $sel.val('').trigger('change');
        $sel.trigger('producto:update');
        return false;
    }
}

const onchange_metodopagos = (el) => {
    const $opt = $(el).find('option:selected');
    const _metodo_pago = $opt.val();

    switch (_metodo_pago) {
        case '1': // EFECTIVO
            $('#metodopago-efectivo').css('display', 'inline');
            $('#metodopago-tarjeta').css('display', 'none');
            break;

        case '2': // TARJETA DEBITO/CREDITO
            $('#metodopago-efectivo').css('display', 'none');
            $('#metodopago-tarjeta').css('display', 'inline');
            break;

        default:
            $('#metodopago-efectivo, #metodopago-tarjeta').css('display', 'none');
            break;
    }
}

const filter = (el) => {
    const key = el.getAttribute('data-filter-key') || el.name; // <-- nombre del elemento
    const value = el.value?.trim() ?? '';

    if (key != "" && value != "") {
        ajax_function_object({
            route: `puntodeventas/filter_productos/key/${key}/value/${value}`,
            method: 'get',
            function: (_response) => {
                $('#id_producto').html(_response.list_productos);

                if (!_response.next) {
                    alert_toastr(_response.response_message);
                }
            }
        });
    } else {
        alert_toastr({
            type: 'warning',
            message: 'ES NECESARIO SELECCIONAR AL MENOS UNA CATEGORIA, SUBCATEGORIA, TIPO O MARCA PARA PODER FILTRAR EL LISTADO DE PRODUCTOS.'
        });
    }
}

const onchange_productos = (el) => {
    const $opt = $(el).find('option:selected');
    const _producto = $opt.val();
    const _precio = $opt.data('precio');

    let _value_producto = (_precio == "undefined") ? 0 : _precio;
    $('#precio').val(_value_producto);
    $('#cantidad').val(1).trigger('input');
}

const recalcular = () => {
    const precio = $('#precio').val();
    const cantidad = $('#cantidad').val();

    $('#subtotal').val(numeric_format(precio * cantidad));
}

const recalcular_cambio = () => {
    const _efectivo_recibido = $('#pago_cliente').val();
    const _total = $('#total').val()
    let _cambio = (_efectivo_recibido != "") ? (parseFloat(_efectivo_recibido) - moneyToNumber(_total)) : 0;

    $('#cambio_cliente').val(numeric_format(_cambio));
}

const form_filter = () => {
    let _next = false;

    const $opt_producto = $('#id_producto').find('option:selected');
    const _producto = $opt_producto.val();
    const _existencia = $opt_producto.data('cantidad');
    const _cantidad = $('#cantidad').val();

    if (_producto != "") {
        if (_cantidad != "") {
            if (_cantidad > _existencia) {
                alert_toastr({
                    type: 'warning',
                    message: `LA CANTIDAD DE ${_cantidad} NO PUEDE SER MAYOR A LA EXISTENCIA DE ${_existencia}.`
                });
            } else {
                _next = true;
            }
        } else {
            alert_toastr({
                type: 'warning',
                message: 'ES NECESARIO ESCRIBIR UNA CANTIDAD.'
            });
        }
    } else {
        alert_toastr({
            type: 'warning',
            message: 'ES NECESARIO SELECCIONAR UN PRODUCTO PARA EL REGISTRO.'
        });
    }

    return _next;
}

const store = () => {
    if (form_filter()) {
        ajax_function_object({
            route: 'puntodeventas/store',
            method: 'post',
            data: {
                form: $('#form')
            },
            function: (_response) => {
                if (_response.next) {
                    // RECARGAREMOS EL ID DE LA VENTA ABIERTA
                    $('#id_venta_producto').val(_response.id_venta_producto);
                    // RECARGAMOS LOS TOTALES
                    $('#total_subtotal').val(numeric_format(_response.data_totales.subtotal));
                    $('#iva').val(numeric_format(_response.data_totales.iva));
                    $('#total').val(numeric_format(_response.data_totales.total));
                    $('#datatable_refresh').html(_response.view);
                }
            }
        });
    }
}

const destroy = (_id) => {
    bootbox_alert({
        type: 'confirm',
        message: `¿Está seguro que desea eliminar el registro con folio <strong>${_id}</strong>?`,
        callback: (_response) => {
            ajax_function_object({
                route: 'puntodeventas/linea/destroy',
                method: 'post',
                data: {
                    id: _id,
                    id_venta_producto: $('#id_venta_producto').val()
                },
                function: (_response) => {
                    if (_response.next) {
                        $('#total_subtotal').val(numeric_format(_response.data_totales.subtotal));
                        $('#iva').val(numeric_format(_response.data_totales.iva));
                        $('#total').val(numeric_format(_response.data_totales.total));
                        $('#datatable_refresh').html(_response.view);
                    }

                    alert_toastr(_response.response_message);
                }
            });
        }
    });
}

const form_total_filter = () => {
    let _next = false;

    if ($('#id_metodo_pago').val() != "") {

        switch ($('#id_metodo_pago option:selected').val()) {
            case '1': // EFECTIVO
                if ($('#pago_cliente').val() != "") {
                    _next = true;
                } else {
                    alert_toastr({
                        type: 'warning',
                        message: 'ES OBLIGATORIO ESCRIBIR EL EFECTIVO RECIBIDO.'
                    });
                }
                break;
            case '2': // TARJETA
                if ($('#tipo_tarjeta option:selected').val() != "") {
                    if ($('#categoria_tarjeta option:selected').val() != "") {
                        if ($('#cod_referencia').val() != "") {
                            _next = true;
                        } else {
                            alert_toastr({
                                type: 'warning',
                                message: 'ES OBLIGATORIO EL CODIGO DE REFERENCIA DEL TICKET DE VENTA.'
                            });
                        }
                    } else {
                        alert_toastr({
                            type: 'warning',
                            message: 'ES OBLIGATORIO SELECCONAR UNA CATEGORIA DE TARJETA.'
                        });
                    }
                } else {
                    alert_toastr({
                        type: 'warning',
                        message: 'ES OBLIGATORIO SELECCONAR UN TIPO DE TARJETA.'
                    });
                }
                break;
        }

    } else {
        alert_toastr({
            type: 'warning',
            message: 'ES OBLIGATORIO SELECCIONAR UN METODO DE PAGO.'
        });
    }

    return _next;
}

const finalizar = () => {
    if (form_total_filter()) {
        ajax_function_object({
            route: 'puntodeventas/finalizar',
            method: 'post',
            data: {
                form: $('#form-finalizar'),
                data: {
                    id_venta_producto: $('#id_venta_producto').val(),
                    id_corte_caja: $('#id_corte_caja').val()
                }
            },
            function: (_response) => {
                if (_response.next) {
                    setTimeout(() => {
                        window.location.href = '/puntodeventas/';
                    }, 2000);
                }

                alert_toastr(_response.response_message);
            }
        });
    }
}

const realizar_cierre = (_folio_caja, _monto) => {
    if (_folio_caja != "") {
        bootbox_alert({
            type: 'confirm',
            message: `¿Está seguro que desea <strong>finalizar</strong> la caja no. ${_folio_caja} y con un monto de $ ${numeric_format(_monto)}?`,
            callback: (_response) => {
                ajax_function_object({
                    route: 'puntodeventas/caja/finalizar',
                    method: 'post',
                    data: {
                        id_corte_caja: _folio_caja
                    },
                    function: (_response) => {
                        if (_response.next) {
                            setTimeout(() => {
                                window.location.href = '/puntodeventas/';
                            }, 2000);
                        }

                        alert_toastr(_response.response_message);
                    }
                });
            }
        });
    } else {
        alert_toastr({
            type: 'warning',
            message: 'Es necesario que la caja se encuente abierta y existente.'
        });
    }
}
