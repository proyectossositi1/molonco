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
        route: 'catalogos/empresas/store',
        datatable: {
            id: '#datatable'
        }
    });
}

const edit = (_id) => {
    process_edit({
        form: '#form',
        route: 'catalogos/empresas/edit',
        data: {
            id: _id
        }
    });
}

const update = () => {
    process_update({
        form: '#form',
        route: 'catalogos/empresas/store',
        datatable: {
            id: '#datatable'
        }
    });
}

function destroy(_id) {
    procees_destroy({
        form: '#form',
        route: 'catalogos/empresas/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}
