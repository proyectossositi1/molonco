$(document).ready(function () {
    init({
        datatable: {
            id: '#datatable'
        }
    });

    validateMatch({
        field1: $('#pwd'),
        field2: $('#confirm_pwd')
    });
});

const store = () => {
    let _next = false;

    if ($('#pwd').val() === $('#confirm_pwd').val()) _next = true;

    if (_next) {
        process_store({
            form: '#form',
            fields: [
                'id_role',
                'nombre',
                'email',
                'pwd',
                'confirm_pwd'
            ],
            route: 'admin/users/store',
            datatable: {
                id: '#datatable'
            }
        });
    } else {
        alert_toastr({
            message: 'ES NECESARIO VALIDAR QUE LAS CONTRASEÑAS COINCIDAD.'
        });
    }
}

const edit = (_id) => {
    process_edit({
        form: '#form',
        route: 'admin/users/edit',
        data: {
            id: _id
        }
    });
}

const update = () => {
    process_update({
        form: '#form',
        fields: [
            'id_role',
            'nombre',
            'email'
        ],
        route: 'admin/users/store',
        datatable: {
            id: '#datatable'
        }
    });
}

function destroy(_id) {
    procees_destroy({
        form: '#form',
        route: 'admin/users/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}
