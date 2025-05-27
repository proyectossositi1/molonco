$(document).ready(function () {

});

$(document).ajaxSend(function (event, jqxhr, settings) {
    $.LoadingOverlay("show");
});
$(document).ajaxComplete(function (event, jqxhr, settings) {
    $.LoadingOverlay("hide");
});

const init = (_data = { datatable: {} }) => {
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    // ELIMINAMOS LOS LOCAL STORAGE
    clearLocalStorageByPrefix('ls_');
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    // OCULTAMOS SIEMPRE EL BOTON UPDATE
    $('#btn_update').css('display', 'none');
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    // INICIAMOS EL DATATABLE
    if (!_data.datatable || !_data.datatable.id) {
        console.error("Se necesita especificar un selector para el datatable.");
        return;
    }

    // Configuración base para DataTables
    const baseConfig = {
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
        },
        dom:
            "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
    };

    // Definir configuración según el tipo
    let config = {};
    switch (_data.datatable.type) {
        case 'simple':
            config = { ...baseConfig };
            break;

        default:
            config = {
                ...baseConfig,
                buttons: ["print", "excel", "colvis"]
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            };
            break;
    }

    // Inicialización de DataTable
    const table = $(`${_data.datatable.id}`).DataTable(config);

    // Adjuntar botones si existen
    if (config.buttons) {
        table.buttons().container().appendTo(`${_data.datatable.id}_wrapper .col-md-6:eq(0)`);
    }
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    // INICIAMOS EL SELECT2
    $('.selectpicker').select2({
        theme: 'bootstrap4'
    });
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    // INICIAMOS EL TRUMBOWYG - TEXTAREA
    $('.textareapicker').trumbowyg({
        resetCss: true,
        autogrow: true
    });
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    // INICIAMOS EL NUMBER
    $('.moneda').number(true, 2);
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    // INICIAMOS EL NUMERIC
    $('.numeric').numeric();
    $('.numeric-integer').numeric(
        false,
        function () {
            this.value = '';
            this.focus();
        }
    );
    $('.numeric-decimal').numeric({ decimalPlaces: 2 });
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    // INICIAMOS EL VALIDADOR DE CORREO
    $('.email').on("input", function () {
        const _email = $(this).val().trim();
        const _re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Expresión regular para email

        if (_email === "") {
            $(this).removeClass("is-valid is-invalid");
        } else if (_re.test(_email)) {
            $(this).removeClass("is-invalid").addClass("is-valid");
        } else {
            $(this).removeClass("is-valid").addClass("is-invalid");
        }
    });
}

// ------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------
const form_validate = (_data = { form: '', fields: [] }) => {
    let isValid = true;
    let formSelector = _data.form;
    let fieldsToValidate = _data.fields || []; // Lista de campos a validar
    let form = $(formSelector);

    if (form.length === 0) {
        console.error("EL FORMULARIO ESPECIFICADO NO EXISTE: " + formSelector);
        return false;
    }

    // Eliminar clases de error previas
    form.find(".form-control").removeClass("is-invalid");

    // Recorrer todos los inputs del formulario
    form.find("input, textarea, select ").each(function () {
        let input = $(this);
        let value;
        // let value = input.val().trim();
        let fieldName = input.attr("name") || "CAMPO SIN NOMBRE";

        // Verificar si el campo está en la lista de validación (si se especificó)
        if (fieldsToValidate.length > 0 && !fieldsToValidate.includes(fieldName)) {
            return; // Ignorar validación para este campo
        }

        // Validar campo vacío
        if (value === "") {
            input.addClass("is-invalid");
            alert_toastr({
                message: `EL CAMPO <strong>${fieldName.toUpperCase()} </strong> ES OBLIGATORIO.`
            });
            isValid = false;
            return false; // Detiene el `each` en el primer error
        }

        // Detectar si es un select multiple
        if (input.is('select') && input.prop('multiple')) {
            value = input.val(); // Devuelve un array
            if (!value || value.length === 0) {
                input.addClass("is-invalid");
                alert_toastr({
                    message: `DEBES SELECCIONAR AL MENOS UNA OPCIÓN EN <strong>${input.attr("name").toUpperCase()}</strong>.`
                });
                isValid = false;
                return false;
            }
        } else {
            // Para inputs normales y selects simples
            value = input.val() ? input.val().trim() : "";

            // Validar campo vacío
            if (value === "") {
                input.addClass("is-invalid");
                alert_toastr({
                    message: `EL CAMPO <strong>${input.attr("name").toUpperCase()}</strong> ES OBLIGATORIO.`
                });
                isValid = false;
                return false;
            }
        }

        // Validar URL si el campo tiene el atributo `name="url"`
        switch (input.attr("name")) {
            case "url":
                let urlPattern = /^(https?:\/\/)?([\w\-]+(\.[\w\-]+)+[/#?]?.*)?$/;
                if (!urlPattern.test(value)) {
                    input.addClass("is-invalid");
                    alert_toastr({
                        message: `EL CAMPO <strong>URL</strong> NO ES VALIDO. EJEMPLO: https://ejemplo.com o www.ejemplo.com`
                    });
                    isValid = false;
                    return false;
                }
                break;
            case "email":
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(value)) {
                    input.addClass("is-invalid");
                    alert_toastr({
                        message: `EL CAMPO <strong>EMAIL</strong> NO ES VÁLIDO.`
                    });
                    isValid = false;
                    return false;
                }
                break;
        }
    });

    return isValid;
}

const btn_action_change = (_data = { action: '' }) => {
    switch (_data.action) {
        case 'store':
            $('#btn_update').css('display', 'none');
            $('#btn_store').css('display', 'inline');
            break;

        case 'update':
            $('#btn_update').css('display', 'inline');
            $('#btn_store').css('display', 'none');
            break;
    }
}

const process_store = (_data = { form: '', route: '', fields: [], data: {}, datatable: {}, onSuccess: null, onError: null }) => {
    // VALIDAMOS QUE EXISTA EL FORM
    if (!_data?.form) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON EL FORMULARIO PARA REGISTRAR.' });
        return;
    }
    // VALIDAMOS QUE EXISTA EL ROUTE
    if (!_data?.route) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON LA RUTA DONDE SE REALIZARA LA ACION.' });
        return;
    }
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    let _form = $(`${_data.form}`);

    if (form_validate({
        form: _form,
        fields: _data.fields
    })) {
        ajax_function_object({
            route: _data.route,
            method: 'post',
            data: {
                form: _form,
                data: {
                    data: _data.data
                }
            },
            function: (_response) => {
                if (_response.next) {

                    if (!_data?.datatable?.id) {
                        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON UN DATATABLE PARA VISUALIZAR LA INFORAMCION ACTUALIZADA.' });
                    } else {
                        if (_data.datatable.id && _response.view) {
                            $(`${_data.datatable.id}_refresh`).html(_response.view);
                        }
                    }

                    form_clean(`${_data.form}`);

                    // Ejecutar callback de éxito si está definido
                    if (typeof _data.onSuccess === 'function') {
                        _data.onSuccess(_response);
                    }
                }

                // Ejecutar callback de error si está definido
                if (typeof _data.onError === 'function') {
                    _data.onError(_response);
                } else {
                    alert_toastr({ type: _response.response_message.type, message: _response.response_message.message });
                }
            }
        });
    }
}

const process_edit = (_data = { form: '', route: '', fields: [], data: {}, datatable: {}, onSuccess: null, onError: null }) => {
    // VALIDAMOS QUE EXISTA EL FORM
    if (!_data?.form) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON EL FORMULARIO PARA EDITAR.' });
        return;
    }
    // VALIDAMOS QUE EXISTA EL ROUTE
    if (!_data?.route) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON LA RUTA DONDE SE REALIZARA LA ACION.' });
        return;
    }
    // VALIDAMOS QUE EXISTA EL ID
    if (!_data?.data?.id) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON EL IDENTIFICADOR DEL REGISTRO PARA REALIZAR LA EDICION.' });
        return;
    }
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    let _form = $(`${_data.form}`);

    ajax_function_object({
        route: _data.route,
        method: 'post',
        data: {
            form: _form,
            data: {
                id: _data.data.id
            }
        },
        function: (_response) => {
            if (_response.next) {
                // CREAMOS EL LOCALSTORAGE
                let _name_localstorage = `ls_${splitAfterSlash(_data.route)[0]}`;
                localstorage_function('set', _name_localstorage, _response.data);

                // Llenar automáticamente los campos del formulario
                $.each(_response.data, function (key, value) {
                    let field = _form.find(`[name="${key}"]`);

                    if (field.length) {
                        // Si es un select, activar Select2
                        if (field.is('select')) {
                            field.val(value).trigger('change'); // Cambiar el valor y disparar evento de cambio
                            // field.val(value).select2(); 
                            field.select2({
                                theme: 'bootstrap4'
                            });
                        } else if (field.is('textarea') && field.hasClass('textareapicker')) {
                            // Si es un textarea, asignar el valor correctamente
                            field.trumbowyg('html', value);
                        } else {
                            // Si es un input normal, solo asignar el valor
                            field.val(value);
                        }
                    }
                });

                btn_action_change({ action: 'update' });

                // Ejecutar callback de éxito si está definido
                if (typeof _data.onSuccess === 'function') {
                    _data.onSuccess(_response);
                }
            } else {
                // Ejecutar callback de error si está definido
                if (typeof _data.onError === 'function') {
                    _data.onError(_response);
                } else {
                    alert_toastr({ type: _response.response_message.type, message: _response.response_message.message });
                }
            }
        }
    });
}

const process_update = (_data = { form: '', route: '', fields: [], data: {}, datatable: {}, onSuccess: null, onError: null }) => {
    // VALIDAMOS QUE EXISTA EL FORM
    if (!_data?.form) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON EL FORMULARIO PARA EDITAR.' });
        return;
    }
    // VALIDAMOS QUE EXISTA EL ROUTE
    if (!_data?.route) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON LA RUTA DONDE SE REALIZARA LA ACION.' });
        return;
    }
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    let _form = $(`${_data.form}`);
    // OBTENEMO EL LOCALSTORAGE CREADO
    let _name_localstorage = `ls_${splitAfterSlash(_data.route)[0]}`;
    let _tmp = localstorage_function('get', _name_localstorage);

    ajax_function_object({
        route: _data.route,
        method: 'post',
        data: {
            form: _form,
            data: {
                id: _tmp.id
            }
        },
        function: (_response) => {
            if (_response.next) {

                if (!_data?.datatable?.id) {
                    alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON UN DATATABLE PARA VISUALIZAR LA INFORAMCION ACTUALIZADA.' });
                } else {
                    if (_data.datatable.id && _response.view) {
                        $(`${_data.datatable.id}_refresh`).html(_response.view);
                    }
                }

                btn_action_change({ action: 'store' });
                clearLocalStorageByPrefix(_name_localstorage);
                form_clean(`${_data.form}`);

                // Ejecutar callback de éxito si está definido
                if (typeof _data.onSuccess === 'function') {
                    _data.onSuccess(_response);
                }
            }
            // Ejecutar callback de error si está definido
            if (typeof _data.onError === 'function') {
                _data.onError(_response);
            } else {
                alert_toastr({ type: _response.response_message.type, message: _response.response_message.message });
            }
        }
    });
}

const procees_destroy = (_data = { form: '', route: '', fields: [], data: {}, datatable: {}, onSuccess: null, onError: null }) => {
    // VALIDAMOS QUE EXISTA EL FORM
    if (!_data?.form) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON EL FORMULARIO PARA EDITAR.' });
        return;
    }
    // VALIDAMOS QUE EXISTA EL ROUTE
    if (!_data?.route) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON LA RUTA DONDE SE REALIZARA LA ACION.' });
        return;
    }
    // VALIDAMOS QUE EXISTA EL ID
    if (!_data?.data?.id) {
        alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON EL IDENTIFICADOR DEL REGISTRO PARA REALIZAR LA EDICION.' });
        return;
    }
    // ------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------
    let _form = $(`${_data.form}`);

    ajax_function_object({
        route: _data.route,
        method: 'post',
        data: {
            form: _form,
            data: {
                id: _data.data.id
            }
        },
        function: (_response) => {
            if (_response.next) {
                if (!_data?.datatable?.id) {
                    alert_toastr({ type: 'error', message: 'ES NECESARIO CONTAR CON UN DATATABLE PARA VISUALIZAR LA INFORAMCION ACTUALIZADA.' });
                } else {
                    if (_data.datatable.id && _response.view) {
                        $(`${_data.datatable.id}_refresh`).html(_response.view);
                    }
                }

                // Ejecutar callback de éxito si está definido
                if (typeof _data.onSuccess === 'function') {
                    _data.onSuccess(_response);
                }
            }

            // Ejecutar callback de error si está definido
            if (typeof _data.onError === 'function') {
                _data.onError(_response);
            } else {
                alert_toastr({ type: _response.response_message.type, message: _response.response_message.message });
            }
        }
    });
}
// ------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------

const alert_toastr = (_data = { type: 'info', message: '' }) => {
    switch (_data.type) {
        case 'success':
            toastr.success(_data.message);
            break;
        case 'error':
            toastr.error(_data.message);
            break;
        case 'warning':
            toastr.warning(_data.message);
            break;
        case 'info':
        default:
            toastr.info(_data.message);
            break;
    }
}

const ajax_function_object = (data = { server: 'default', route: '', data: {}, method: '', async: true, function: function () { } }) => {

    switch (data.server) {
        case 'nodejs':
            $.ajax({
                cache: false,
                async: data.async,
                method: data.method.toUpperCase(),
                url: 'http://192.168.80.117:3000/' + data.route,
                // url: 'http://localhost:3000/' + data.route,
                data: JSON.stringify(data.data),
                headers: {
                    'Content-Type': 'application/json'
                },
                success: function (_result) {
                    data.function(_result);
                }, error: function (error) {
                    console.log('ERROR: ', error.responseJSON.message);
                    bootbox_alert('ERROR', error.responseJSON.message);
                }
            });
            break;

        default:
            let _csrfToken = $("meta[name='X-CSRF-TOKEN']").attr("content");
            let _newData = {};

            if (typeof data.data.form != "undefined") {
                $.each(data.data.form.serializeArray(), function (_, kv) {
                    _newData[kv.name] = kv.value;
                    switch (kv.name) {
                        case "csrf_test_name":
                            $("meta[name='X-CSRF-TOKEN']").attr("content", kv.value);
                            delete _newData[kv.name]; // 🔥 Elimina el campo CSRF del objeto
                            _csrfToken = kv.value; // ✅ Actualizar el token antes de eliminarlo
                            break;
                    }
                });

                if (typeof data.data.data != "undefined") _newData['data'] = data.data.data;
                // if (typeof data.data.image != "undefined") {
                //     // console.log('data.data.image.item: ', data.data.image.item);
                //     if (data.data.image.item != undefined) _newData['image'] = enviar_imagen(data.data.image.item, data.data.image.ruta);
                // }
                if (typeof data.data.blob != undefined) _newData['blob'] = data.data.blob;
            } else {
                // VARIABLE PARA OBTENER EL TOKEN, SIN FORMULARIO
                _csrfToken = $('input[name="csrf_test_name"]').val();
                if (_csrfToken != "") {
                    $("meta[name='X-CSRF-TOKEN']").attr("content", _csrfToken);
                    data.data.csrf_token = _csrfToken;
                }
                // OBJETO DE DATA
                _newData = data.data;
            }

            $.ajax({
                cache: false,
                async: data.async,
                method: data.method.toUpperCase(),
                // dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": _csrfToken
                },
                url: BASE_URL + data.route,
                data: { 'data': JSON.stringify(_newData) },
                // contentType: "application/json; charset=utf-8",
                success: function (_result) {
                    _result = $.parseJSON(_result);
                    // ✅ Si el backend devuelve un nuevo token, lo actualizamos en el formulario y meta
                    if (_result.csrf_token) {
                        $("meta[name='X-CSRF-TOKEN']").attr("content", _result.csrf_token);
                        $("input[name='csrf_test_name']").val(_result.csrf_token);
                    }

                    data.function(_result);
                }, error: function (error) {
                    console.log('ERROR: ', error);
                    alert_toastr({
                        type: 'error',
                        message: error.responseJSON.message
                    });
                }
            });
            break;
    }
}

const numeric_format = (value, decimals = 2, separators = [',', '.']) => {
    // Validar y preparar valores iniciales
    if (isNaN(value)) return '0';
    decimals = Math.max(0, parseInt(decimals));
    separators = separators || [',', '.'];

    // Redondear y convertir a string con decimales
    let number = parseFloat(value).toFixed(decimals);

    // Separar parte entera y decimal
    const [integer, fraction] = number.split('.');
    const isNegative = number.startsWith('-');
    let cleanInteger = isNegative ? integer.slice(1) : integer;

    // Formatear parte entera con separadores de miles
    let formattedInteger = '';
    for (let i = cleanInteger.length - 1, count = 0; i >= 0; i--, count++) {
        formattedInteger = cleanInteger[i] + formattedInteger;
        if (count % 3 === 2 && i > 0) {
            formattedInteger = separators[0] + formattedInteger;
        }
    }

    // Construir resultado final
    const formattedNumber = (isNegative ? '-' : '') + formattedInteger +
        (fraction ? separators[1] + fraction : '');

    return formattedNumber;
};

const parseAndRound = (value) => {
    const parsedValue = parseFloat(value);
    if (isNaN(parsedValue)) {
        return 0; // Devolver 0 si el valor no es un número
    }
    return parseFloat(parsedValue.toFixed(2)); // Redondear a 2 decimales y devolver como número
}

const calcularDiferenciaDias = (_data = { fecha_minima: null, fecha_maxima: null }) => {
    // Validar que _data tenga las propiedades requeridas
    if (!_data.fecha_minima && !_data.fecha_maxima) {
        console.error("DEBE PROPORCIONAL AL MENOS UNA FECHA MINIMA O MAXIMA.");
        return null;
    }

    const hoy = new Date(); // Fecha actual
    const fechaMin = _data.fecha_minima ? new Date(_data.fecha_minima) : null;
    const fechaMax = _data.fecha_maxima ? new Date(_data.fecha_maxima) : null;

    // Validar que las fechas sean válidas
    if (fechaMin && isNaN(fechaMin)) {
        console.error("LA FECHA MINIMA PROPORCIONADA NO ES VALIDA..");
        return null;
    }

    if (fechaMax && isNaN(fechaMax)) {
        console.error("LA FECHA MAXIMA PROPORCIONADA NO ES VALIDA.");
        return null;
    }

    // Determinar el punto de referencia para calcular la diferencia
    const referencia = fechaMin ? fechaMin : hoy; // Usar fecha mínima si está definida

    // Calcular la diferencia en milisegundos
    const diferenciaMs = fechaMax ? fechaMax - referencia : referencia - hoy;

    // Convertir la diferencia a días (1 día = 24 * 60 * 60 * 1000 ms)
    const diferenciaDias = Math.ceil(diferenciaMs / (1000 * 60 * 60 * 24));

    return diferenciaDias;
};

const getFecha = (fecha = "") => {
    if (fecha == "") {
        var today = new Date();
        return today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    } else {
        var today = new Date(fecha);
        return today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    }
    //return new Date().toJSON().slice(0,10).replace(/-/g,'/');
}

const validateEmail = (email) => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

const localstorage_function = (_tipo, _variable, _object = {}) => {
    switch (_tipo.toLowerCase()) {
        case 'get':
            return $.parseJSON(localStorage.getItem(_variable));
            break;
        case 'set':
            localStorage.setItem(_variable, JSON.stringify(_object));
            break;
        case 'remove':
            localStorage.removeItem(_variable);
            break;
    }
}

const split_datetime = (_date_time = '') => {
    if (_date_time != '') {
        // CONVERTIMOS LA CADENA A UN OBJETO DATE
        let fechaHora = new Date(_date_time);

        // OBTENEMOS LA FECHA Y HORA POR SEPARADOS
        data = {
            date: fechaHora.toISOString().slice(0, 10),
            time: fechaHora.toTimeString().slice(0, 8)
        };

        return data;
    }

    return false;
}

const form_clean = (element) => {
    $(element)[0].reset();
    // $('.selectpicker').val("").trigger("change");
    $(`${element}`).prop('disabled', false);
    $(`${element} .selectpicker`).prop('disabled', false);
    $(`${element} .selectpicker`).val("").select2({
        theme: 'bootstrap4'
    });

    $(`${element} textarea.textareapicker`).each(function () {
        $(this).trumbowyg('empty'); // Alternativamente, usar .trumbowyg('html', '')
    });
}

const clearLocalStorageByPrefix = (prefix) => {
    // Recorremos todas las claves en el localStorage
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);

        // Si la clave empieza con el prefijo, la eliminamos
        if (key && key.startsWith(prefix)) {
            localStorage.removeItem(key);
            // Reducimos el contador porque se eliminó un elemento
            i--;
        }
    }
}

const splitAfterSlash = (str, fromIndex = 0) => {
    if (typeof str !== 'string') {
        console.error('El argumento debe ser una cadena de texto.');
        return [];
    }

    // ✅ Dividir la cadena por "/"
    const parts = str.split('/');

    // ✅ Retornar las partes después del índice especificado
    return parts.slice(fromIndex);
}

const validateMatch = (_data = { field1: '', field2: '' }) => {
    $(_data.field2).on('input', function () {
        if ($(_data.field1).val() === $(this).val()) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
        }
    });
};

const tabactive = (callback) => {
    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        const tabId = $(e.target).attr('id');
        const tabHref = $(e.target).attr('href');
        const tabText = $(e.target).text().trim();
        const tabName = $(e.target).attr('href').replace('#tab-', '');

        if (typeof callback === 'function') {
            callback({ id: tabId, href: tabHref, text: tabText, name: tabName });
        }
    });
};