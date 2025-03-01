$(document).ready(function () {
    init({
        datatable: {
            id: '#datatable'
        }
    });
});

const FORM = {
    data: {
        form: '#form-route',
        route: '',
        data: {},
        datatable: {},
        onSuccess: (reponse) => { },
        onError: (reponse) => { },
    },
    store: () => {
        process_store({
            ...this.data,
            route: 'routes/store',
            datatable: { id: '#datatable' }
        });
    },
    edit: (_id) => {
        process_edit({
            ...this.data,
            route: 'routes/edit',
            data: { id: _id }
        });
    },
    update: () => {
        process_update({
            ...this.data,
            route: 'routes/store',
            datatable: { id: '#datatable' }
        });
    },
    destroy: (_id) => {
        procees_destroy({
            ...this.data,
            route: 'routes/destroy',
            datatable: { id: '#datatable' },
            data: { id: _id }
        });
    },
};

// const store = () => {
//     process_store({
//         form: '#form-route',
//         route: 'routes/store',
//         datatable: {
//             id: '#datatable'
//         }
//     });
// }

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

// function destroy(_id) {
//     procees_destroy({
//         form: '#form-route',
//         route: 'routes/destroy',
//         datatable: {
//             id: '#datatable'
//         },
//         data: {
//             id: _id
//         }
//     });
// }
