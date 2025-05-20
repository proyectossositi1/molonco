$(document).ready(function () {
    init({
        datatable: {
            id: '#datatable'
        }
    });
});

const store = () => {
    let _next = false;
    let _route_id = $('#id_route').val();

    if (_route_id != "") {
        _next = true;
    } else {
        alert_toastr({
            message: `ES NECESARIO SELECCIONAR ALMENOS UNA RUTA.`
        });
    }

    if (_next) {
        process_store({
            form: '#form',
            fields: [
                'id_role'
            ],
            route: 'admin/routes/asignar/store',
            data: {
                route_ids: _route_id
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
//         route: 'routes/edit',
//         data: {
//             id: _id
//         }
//     });
// }

// const update = () => {
//     process_update({
//         form: '#form-route',
//         route: 'routes/store',
//         datatable: {
//             id: '#datatable'
//         }
//     });
// }

function destroy(_id) {
    procees_destroy({
        form: '#form',
        route: 'admin/routes/asignar/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}
