$(document).ready(function () {
    init({
        datatable: {
            id: '#datatable'
        }
    });
});

const store = () => {
    let _next = false;
    let _permissions = $('#permission_id').val();

    if (_permissions != "") {
        _next = true;
    } else {
        alert_toastr({
            message: `ES NECESARIO SELECCIONAR ALMENOS UN PERMISO.`
        });
    }

    if (_next) {
        process_store({
            form: '#form',
            fields: [
                'role_id'
            ],
            route: 'admin/roles/asignar/store',
            data: {
                permission_ids: _permissions
            },
            datatable: {
                id: '#datatable'
            }
        });
    }
}

// const edit = (_id) => {
//     process_edit({
//         form: '#form-route',
//         route: 'roles/edit',
//         data: {
//             id: _id
//         }
//     });
// }

// const update = () => {
//     process_update({
//         form: '#form-route',
//         route: 'roles/store',
//         datatable: {
//             id: '#datatable'
//         }
//     });
// }

function destroy(_id) {
    procees_destroy({
        form: '#form',
        route: 'admin/roles/asignar/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}
