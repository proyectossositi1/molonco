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
            'razon_social', 'rfc'
        ],
        route: 'catalogos/organizaciones/store',
        datatable: {
            id: '#datatable'
        }
    });
}

const edit = (_id) => {
    process_edit({
        form: '#form',
        route: 'catalogos/organizaciones/edit',
        data: {
            id: _id
        }
    });
}

const update = () => {
    process_update({
        form: '#form',
        fields: [
            'razon_social', 'rfc'
        ],
        route: 'catalogos/organizaciones/update',
        datatable: {
            id: '#datatable'
        }
    });
}

function destroy(_id) {
    procees_destroy({
        form: '#form',
        route: 'catalogos/organizaciones/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}
