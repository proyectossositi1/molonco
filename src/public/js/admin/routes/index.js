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
            'name', 'route', 'controller', 'method'
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

            $('#method').prop('disabled', true);
            $('#new_method').val(_tmp.method);
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
