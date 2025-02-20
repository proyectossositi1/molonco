$(document).ready(function () {
    $('#btn_update').css('display', 'none');
    remove_localstorage();
});

function remove_localstorage() {
    localstorage_function('remove', 'LS_FORM');
}

function item_changes(_data = { action: '' }) {
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

function store() {
    let _form = $('#form-route');

    if (form_validate({
        form: _form
    })) {
        ajax_function_object({
            route: 'routes/store',
            method: 'post',
            data: {
                form: _form
            },
            function: (_response) => {
                if (_response.next) {
                    $("#datatable_refresh").html(_response.view);
                    form_clean('form-route');
                }

                alert_toastr({ type: _response.response_message.type, message: _response.response_message.message });
            }
        });
    }
}

function edit(_id) {
    let _form = $('#form-route');

    ajax_function_object({
        route: 'routes/edit',
        method: 'post',
        data: {
            form: _form,
            data: {
                id: _id
            }
        },
        function: (_response) => {
            if (_response.next) {
                localstorage_function('set', 'LS_FORM', _response.data);

                $('#name').val(_response.data.name);
                $('#route').val(_response.data.route);
                $('#icon').val(_response.data.icon);

                item_changes({ action: 'update' });
            } else {
                alert_toastr({ type: _response.response_message.type, message: _response.response_message.message });
            }
        }
    });
}

function update() {
    let _form = $('#form-route');
    let _tmp = localstorage_function('get', 'LS_FORM');

    ajax_function_object({
        route: 'routes/store',
        method: 'post',
        data: {
            form: _form,
            data: {
                id: _tmp.id
            }
        },
        function: (_response) => {
            if (_response.next) {
                $("#datatable_refresh").html(_response.view);

                item_changes({ action: 'store' });
                remove_localstorage();
                form_clean('form-route');
            }

            alert_toastr({ type: _response.response_message.type, message: _response.response_message.message });
        }
    });
}

function destroy(_id) {
    let _form = $('#form-route');

    ajax_function_object({
        route: 'routes/destroy',
        method: 'post',
        data: {
            form: _form,
            data: {
                id: _id
            }
        },
        function: (_response) => {
            if (_response.next) {
                $("#datatable_refresh").html(_response.view);
            }

            alert_toastr({ type: _response.response_message.type, message: _response.response_message.message });
        }
    });
}