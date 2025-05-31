<?php
echo '<script src="' . base_url('js/punto_venta/index.js?v='.time()) . '"></script>';
?>

<div class="row">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Punto de Venta</h3>
            </div>
            <div class="card-body">
                <!-- Buscador de productos -->
                <div class="input-group mb-3">
                    <input type="text" id="buscar_producto" class="form-control" placeholder="Buscar por nombre">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="btn_buscar">Buscar</button>
                    </div>
                </div>

                <!-- Tabla de productos -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tabla_productos">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?= esc($producto['nombre']) ?></td>
                                <td><?= esc($producto['codigo_barras']) ?></td>
                                <td>$<?= number_format($producto['precio_venta'], 2) ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm agregar-carrito" 
                                            data-id="<?= $producto['id'] ?>"
                                            data-nombre="<?= esc($producto['nombre']) ?>"
                                            data-precio="<?= $producto['precio_venta'] ?>">
                                        <i class="fas fa-cart-plus"></i> Agregar
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-3">
                    <?= $pager->links() ?>
                </div>
                
                <!-- Tabla de productos agregados -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered" id="tabla_carrito">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se agregan los productos con JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Resumen</h3>
            </div>
            <div class="card-body">
                <p>Subtotal: <span id="subtotal">$0.00</span></p>
                <p>IVA: <span id="iva">$0.00</span></p>
                <p><b>Total: <span id="total">$0.00</span></b></p>
                <div class="form-group">
                    <label for="pago">Pago con:</label>
                    <input type="number" id="pago" class="form-control" min="0" step="0.01">
                </div>
                <p>Cambio: <span id="cambio">$0.00</span></p>
                <button class="btn btn-success btn-block" id="btn_finalizar">Finalizar venta</button>
            </div>
        </div>
    </div>
</div> 