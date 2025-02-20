$(document).ready(function () {

    $(`#datatable`).DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": ["print", "excel", "colvis"]
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');

});

window.alert_toastr = function (_data = { type: 'info', message: '' }) {
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

window.form_validate = function (_data = { form: '' }) {
    let isValid = true;
    let formSelector = _data.form;
    let form = $(formSelector);

    if (form.length === 0) {
        console.error("EL FORMULARIO ESPECIFICADO NO EXISTE: " + formSelector);
        return false;
    }

    // Eliminar clases de error previas
    form.find(".form-control").removeClass("is-invalid");

    // Recorrer todos los inputs del formulario
    form.find("input").each(function () {
        let input = $(this);
        let value = input.val().trim();
        let fieldName = input.attr("name") || "CAMPO SIN NOMBRE";

        // Validar campo vacío
        if (value === "") {
            input.addClass("is-invalid");
            alert_toastr({
                message: `EL CAMPO <strong>${fieldName.toUpperCase()} </strong> ES OBLIGATORIO.`
            });
            isValid = false;
            return false; // Detiene el `each` en el primer error
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
        }
    });

    return isValid;
}

window.ajax_function_object = function (data = { server: 'default', route: '', data: {}, method: '', async: true, function: function () { } }) {

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

window.numeric_format = function (value, decimals = 2, separators = [',', '.']) {
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

window.parseAndRound = function (value) {
    const parsedValue = parseFloat(value);
    if (isNaN(parsedValue)) {
        return 0; // Devolver 0 si el valor no es un número
    }
    return parseFloat(parsedValue.toFixed(2)); // Redondear a 2 decimales y devolver como número
}

window.calcularDiferenciaDias = function (_data = { fecha_minima: null, fecha_maxima: null }) {
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

window.getFecha = function (fecha = "") {
    if (fecha == "") {
        var today = new Date();
        return today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    } else {
        var today = new Date(fecha);
        return today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    }
    //return new Date().toJSON().slice(0,10).replace(/-/g,'/');
}

window.validateEmail = function (email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

window.localstorage_function = function (_tipo, _variable, _object = {}) {
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

window.split_datetime = function (_date_time = '') {
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

window.form_clean = function (element) {
    $('#' + element)[0].reset();
    // $('.selectpicker').val("").trigger("change");
    $('#' + element + ' .selectpicker').val("").select2();
}