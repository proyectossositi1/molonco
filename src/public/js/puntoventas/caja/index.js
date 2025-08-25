$(document).ready(function () {
    init({
        datatable: {
            id: '#datatable'
        }
    });
});

const store = () => {
    let _monto_inicial = $('#monto_inicial').val();

    if (_monto_inicial != "") {
        bootbox_alert({
            type: 'confirm',
            message: `¿Está seguro que desea iniciar con un monto de <strong>$ ${numeric_format(_monto_inicial)}</strong>?`,
            callback: (_response) => {
                process_store({
                    form: '#form',
                    fields: [
                        'monto_inicial'
                    ],
                    route: 'puntodeventas/caja/store',
                    datatable: {
                        id: '#datatable'
                    },
                    onSuccess: (_response) => {
                        if (_response.next) {
                            setTimeout(() => {
                                window.location.href = '/puntodeventas/';
                            }, 2000);
                        }
                    }
                });
            }
        });
    } else {
        alert_toastr({
            type: 'warning',
            message: 'ES NECESARIO ESCRIBIR UN MONTO INICIAL PARA ABRIR CAJA.'
        });
    }
}