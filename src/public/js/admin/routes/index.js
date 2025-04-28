$(document).ready(function () {
    $('#method').css('display', 'none');

    init({
        datatable: {
            id: '#datatable'
        }
    });
});

const store = () => {
    process_store({
        form: '#form-route',
        fields: [
            'id_empresa', 'id_menu', 'name', 'route', 'controller', 'method'
        ],
        route: 'admin/routes/store',
        data: {
            methods: $('#method').val()
        },
        datatable: {
            id: '#datatable'
        }
    });
}

const edit = (_id) => {
    process_edit({
        form: '#form-route',
        route: 'admin/routes/edit',
        data: {
            id: _id
        },
        onSuccess: () => {
            let _tmp = localstorage_function('get', 'ls_admin');

            $('#method, #id_menu').prop('disabled', true);
            $('#new_method').val(_tmp.method);
            $('#id_menu').val(_tmp.id_menu);
        }
    });
}

const update = () => {
    process_update({
        form: '#form-route',
        fields: [
            'id_empresa', 'id_menu', 'name', 'route', 'controller', 'method'
        ],
        route: 'admin/routes/store',
        datatable: {
            id: '#datatable'
        }
    });
}

function destroy(_id) {
    procees_destroy({
        form: '#form-route',
        route: 'admin/routes/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}

const onchange_empresa = () => {
    let _value = $('#id_empresa option:selected').val();

    if (_value != "") {
        ajax_function_object({
            route: 'admin/routes/ajax_empresas_menu',
            method: 'post',
            data: {
                id_empresa: _value
            },
            function: (_response) => {
                if (_response.next) {
                    $('#id_menu').html(_response.select);
                } else {
                    alert_toastr({
                        type: _response.response_message.type,
                        message: _response.response_message.message
                    });
                }


            }
        });
    } else {
        $('#id_menu').html('<option value="">SELECCIONE UNA OPCION</option>');
    }
}
