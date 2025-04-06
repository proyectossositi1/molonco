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
        route: 'catalogos/tipopagos/store',
        datatable: {
            id: '#datatable'
        }
    });
}

const edit = (_id) => {
    process_edit({
        form: '#form',
        route: 'catalogos/tipopagos/edit',
        data: {
            id: _id
        }
    });
}

const update = () => {
    process_update({
        form: '#form',
        route: 'catalogos/tipopagos/update',
        datatable: {
            id: '#datatable'
        }
    });
}

function destroy(_id) {
    procees_destroy({
        form: '#form',
        route: 'catalogos/tipopagos/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}
