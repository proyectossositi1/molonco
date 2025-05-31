$(document).ready(function() {
    let carrito = [];
    const IVA = 0.16; // 16%

    // Función para buscar productos
    $('#btn_buscar').click(function() {
        const busqueda = $('#buscar_producto').val();
        if (busqueda) {
            $.post(BASE_URL + 'punto-venta/buscar-producto', { busqueda: busqueda }, function(response) {
                if (response.productos.length > 0) {
                    mostrarProductos(response.productos, response.pager);
                } else {
                    toastr.error('Producto no encontrado');
                }
            });
        }
    });

    // Función para mostrar productos
    function mostrarProductos(productos, pager) {
        const tbody = $('#tabla_productos tbody');
        tbody.empty();
        
        productos.forEach(producto => {
            tbody.append(`
                <tr>
                    <td>${producto.nombre}</td>
                    <td>${producto.codigo_barras}</td>
                    <td>$${parseFloat(producto.precio_venta).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-primary btn-sm agregar-carrito" 
                                data-id="${producto.id}"
                                data-nombre="${producto.nombre}"
                                data-precio="${producto.precio_venta}">
                            <i class="fas fa-cart-plus"></i> Agregar
                        </button>
                    </td>
                </tr>
            `);
        });

        // Actualizar paginación
        if (pager) {
            $('.pagination').replaceWith(pager);
        }
    }

    // Evento para agregar al carrito
    $(document).on('click', '.agregar-carrito', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const precio = parseFloat($(this).data('precio'));
        
        const existente = carrito.find(item => item.id === id);
        if (existente) {
            existente.cantidad += 1;
        } else {
            carrito.push({
                id: id,
                nombre: nombre,
                precio: precio,
                cantidad: 1
            });
        }
        actualizarTabla();
        calcularTotales();
        toastr.success('Producto agregado al carrito');
    });

    // Función para actualizar la tabla del carrito
    function actualizarTabla() {
        const tbody = $('#tabla_carrito tbody');
        tbody.empty();
        
        carrito.forEach(item => {
            const total = item.precio * item.cantidad;
            tbody.append(`
                <tr>
                    <td>${item.nombre}</td>
                    <td>
                        <input type="number" class="form-control cantidad" value="${item.cantidad}" 
                               data-id="${item.id}" min="1" style="width: 80px;">
                    </td>
                    <td>$${item.precio.toFixed(2)}</td>
                    <td>$${total.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger btn-sm eliminar" data-id="${item.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    // Función para calcular totales
    function calcularTotales() {
        const subtotal = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
        const iva = subtotal * IVA;
        const total = subtotal + iva;
        
        $('#subtotal').text('$' + subtotal.toFixed(2));
        $('#iva').text('$' + iva.toFixed(2));
        $('#total').text('$' + total.toFixed(2));
        
        // Calcular cambio si hay pago
        const pago = parseFloat($('#pago').val()) || 0;
        const cambio = pago - total;
        $('#cambio').text('$' + (cambio > 0 ? cambio.toFixed(2) : '0.00'));
    }

    // Evento para cambiar cantidad
    $(document).on('change', '.cantidad', function() {
        const id = $(this).data('id');
        const cantidad = parseInt($(this).val());
        const item = carrito.find(item => item.id === id);
        if (item) {
            item.cantidad = cantidad;
            actualizarTabla();
            calcularTotales();
        }
    });

    // Evento para eliminar producto
    $(document).on('click', '.eliminar', function() {
        const id = $(this).data('id');
        carrito = carrito.filter(item => item.id !== id);
        actualizarTabla();
        calcularTotales();
        toastr.info('Producto eliminado del carrito');
    });

    // Evento para calcular cambio
    $('#pago').on('input', function() {
        calcularTotales();
    });

    // Evento para finalizar venta
    $('#btn_finalizar').click(function() {
        if (carrito.length === 0) {
            toastr.error('El carrito está vacío');
            return;
        }
        
        const pago = parseFloat($('#pago').val()) || 0;
        const total = parseFloat($('#total').text().replace('$', ''));
        
        if (pago < total) {
            toastr.error('El pago es insuficiente');
            return;
        }
        
        $.post(BASE_URL + 'punto-venta/guardar-venta', { data: JSON.stringify(carrito) }, function(response) {
            if (response.success) {
                toastr.success('Venta realizada con éxito');
                carrito = [];
                actualizarTabla();
                calcularTotales();
                $('#pago').val('');
            } else {
                toastr.error('Error al guardar la venta');
            }
        });
    });

    // Permitir búsqueda al presionar Enter
    $('#buscar_producto').keypress(function(e) {
        if (e.which === 13) {
            $('#btn_buscar').click();
        }
    });
}); 