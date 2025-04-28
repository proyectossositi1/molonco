$(document).ready(function () {
    init({
        datatable: {
            id: '#datatable'
        }
    });

    action_bottons();

    tabactive((_tab) => {
        let _route = `catalogos/productos/${_tab.name}/ajax_refresh_table`;

        switch (_tab.name) {
            case 'productos':
                _route = `catalogos/productos/ajax_refresh_table`;
                break;
        }

        ajax_function_object({
            route: _route,
            method: 'post',
            data: {
                type: _tab.name
            },
            function: (_response) => {
                if (_response.next) {
                    $('#table-title').html(_tab.name.toUpperCase());
                    $('#datatable_refresh').html(_response.view);
                }
            }
        });
    });
});

const action_bottons = (_data = { type: '', action: '' }) => {
    const _types = ['categorias', 'subcategorias', 'marcas', 'tipos', 'productos', 'precios'];

    switch (_data.action) {
        case 'store':
            _types.forEach(type => {
                const show = (type === _data.type);
                $(`#btn_store-${type}`).css('display', show ? 'inline' : 'none');
                $(`#btn_update-${type}`).css('display', 'none');
            });
            break;

        case 'update':
            _types.forEach(type => {
                const show = (type === _data.type);
                $(`#btn_update-${type}`).css('display', show ? 'inline' : 'none');
                $(`#btn_store-${type}`).css('display', 'none');
            });
            break;

        default:
            _types.forEach(type => {
                $(`#btn_store-${type}`).css('display', 'inline');
                $(`#btn_update-${type}`).css('display', 'none');
            });
            break;
    }
};

const onchange_categorias = () => {
    let _id = $('#id_categoria_producto option:selected').val();

    if (_id != "") {
        ajax_function_object({
            route: 'catalogos/productos/ajax_onchange_categorias',
            method: 'post',
            data: {
                id: _id
            },
            function: (_response) => {
                if (_response.next) {
                    $('#id_subcategoria').html(_response.select);
                }
            }
        });
    } else {
        $('#id_subcategoria').html('<option value="">SELECIONE UNA OPCION</option>');
    }

}

const store = (_type) => {
    let _fields = [];
    let _route = 'catalogos/productos';

    $('#table-title').html(_type.toUpperCase());

    switch (_type) {
        case 'categorias':
        case 'subcategorias':
        case 'marcas':
        case 'tipos':
            _route += '/' + _type;
            _fields = [
                'nombre'
            ];
            break;
        case 'productos':
            _fields = [
                'id_categoria_producto', 'id_subcategoria_producto', 'id_tipo_producto', 'id_marca_producto', 'nombre', 'descripcion'
            ];
            break;
        case 'precios':
            _route += '/' + _type;
            _fields = [
                'id_producto', 'precio_compra', 'preico_venta', 'anio'
            ];
            break;
    }

    process_store({
        form: `#form-${_type}`,
        fields: _fields,
        route: `${_route}/store`,
        datatable: {
            id: '#datatable'
        }
    });
}

const edit = (_id, _type) => {
    let _route = 'catalogos/productos';

    $('#table-title').html(_type.toUpperCase());

    switch (_type) {
        case 'categorias':
        case 'subcategorias':
        case 'marcas':
        case 'tipos':
        case 'precios':
            _route += '/' + _type;
            break;
    }

    process_edit({
        form: `#form-${_type}`,
        route: `${_route}/edit`,
        data: {
            id: _id
        },
        onSuccess: () => {
            let _tmp = localstorage_function('get', 'ls_catalogos');
            action_bottons({ action: 'update', type: _type });

            // FUNCIONALIDAD PARA AGREGAR VALUES RESTANTES
            switch (_type) {
                case 'productos':
                    setTimeout(() => {
                        $('#id_subcategoria').val(_tmp.id_subcategoria).select2({
                            theme: 'bootstrap4'
                        });
                    }, 2000);
                    break;
            }
        }
    });
}

const update = (_type) => {
    let _fields = [];
    let _route = 'catalogos/productos';

    $('#table-title').html(_type.toUpperCase());

    switch (_type) {
        case 'categorias':
        case 'subcategorias':
        case 'marcas':
        case 'tipos':
            _route += '/' + _type;
            _fields = [
                'nombre'
            ];
            break;
        case 'productos':
            _fields = [
                'nombre', 'descripcion', 'codigo_barras'
            ];
            break;
        case 'precios':
            _route += '/' + _type;
            _fields = [
                'id_producto', 'precio_compra', 'preico_venta', 'anio'
            ];
            break;
    }

    process_update({
        form: `#form-${_type}`,
        fields: _fields,
        route: `${_route}/update`,
        datatable: {
            id: '#datatable'
        },
        onSuccess: () => {
            action_bottons({ action: 'store', type: _type });
        }
    });
}

function destroy(_id, _type) {
    let _route = 'catalogos/productos';

    $('#table-title').html(_type.toUpperCase());

    switch (_type) {
        case 'categorias':
        case 'subcategorias':
        case 'marcas':
        case 'tipos':
        case 'precios':
            _route += '/' + _type;
            break;
    }

    procees_destroy({
        form: `#form-${_type}`,
        route: `${_route}/destroy`,
        datatable: {
            id: '#datatable'
        },
        data: {
            id: _id
        },
        onSuccess: () => {
            action_bottons({ action: 'store', type: _type });
        }
    });
}
