$(document).ready(function () {
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
            'name', 'route', 'controller', 'method'
        ],
        route: 'admin/routes/store',
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
        }
    });
}

const update = () => {
    process_update({
        form: '#form-route',
        fields: [
            'name', 'route', 'controller', 'method'
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
