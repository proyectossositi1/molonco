$(document).ready(function () {
    init({
        datatable: {
            id: '#datatable'
        }
    });
});

const store = () => {
    process_store({
        form: '#form',
        fields: [
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'email_primario',
            'telefono_primario'
        ],
        route: 'catalogos/clientes/store',
        datatable: {
            id: '#datatable'
        }
    });
}

const edit = (_id) => {
    process_edit({
        form: '#form',
        route: 'catalogos/clientes/edit',
        data: {
            id: _id
        }
    });
}

const update = () => {
    process_update({
        form: '#form',
        fields: [
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'email_primario',
            'telefono_primario'
        ],
        route: 'catalogos/clientes/update',
        datatable: {
            id: '#datatable'
        }
    });
}

function destroy(_id) {
    procees_destroy({
        form: '#form',
        route: 'catalogos/clientes/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}
