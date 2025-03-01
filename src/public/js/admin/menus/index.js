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
            'name', 'icon', 'order'
        ],
        route: 'admin/menus/store',
        datatable: {
            id: '#datatable'
        }
    });
}

const edit = (_id) => {
    process_edit({
        form: '#form',
        route: 'admin/menus/edit',
        data: {
            id: _id
        }
    });
}

const update = () => {
    process_update({
        form: '#form',
        fields: [
            'name', 'icon', 'order'
        ],
        route: 'admin/menus/store',
        datatable: {
            id: '#datatable'
        }
    });
}

function destroy(_id) {
    procees_destroy({
        form: '#form',
        route: 'admin/menus/destroy',
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        }
    });
}
