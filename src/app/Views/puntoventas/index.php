<script src="<?= base_url('js/puntoventas/index.js?v='.time()); ?>"></script>

<div class="row align-items-center">
    <div class="col">
        <!--begin::Quick Example-->
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">NO. FOLIO <strong><?=$data_caja['id']; ?></strong> CON UN MONTO DE <strong>$
                        <?= number_format($data_caja['monto_inicial'], 2); ?></strong>, USUARIO
                    <strong><?= session('username'); ?></strong>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form id="form">
                <?= csrf_field() ?>
                <input type="hidden" name="id_corte_caja" id="id_corte_caja" value="<?= $data_caja['id']; ?>">
                <input type="hidden" name="id_venta_producto" id="id_venta_producto"
                    value="<?= (!empty($data_venta)) ? $data_venta['id'] : ""; ?>">
                <!--begin::Body-->
                <div class="card-body">

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="form-label">LISTA DE CATEGORIAS</label>
                                <select class="form-control selectpicker" name="filte-categoria" id="filte-categoria"
                                    data-filter-key="categoria" onchange="filter(this)">
                                    <option value="">SELECCIONE UNA OPCION</option>
                                    <? foreach ($list_categorias as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nombre']; ?></option>
                                    <? endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="form-label">LISTA DE SUBCATEGORIAS</label>
                                <select class="form-control selectpicker" name="filter-subcategoria"
                                    id="filter-subcategoria" data-filter-key="subcategoria" onchange="filter(this)">
                                    <option value="">SELECCIONE UNA OPCION</option>
                                    <? foreach ($list_subcategorias as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nombre']; ?></option>
                                    <? endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="form-label">LISTA DE TIPOS</label>
                                <select class="form-control selectpicker" name="filter-tipo" id="filter-tipo"
                                    data-filter-key="tipo" onchange="filter(this)">
                                    <option value="">SELECCIONE UNA OPCION</option>
                                    <? foreach ($list_tipos as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nombre']; ?></option>
                                    <? endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="form-label">LISTA DE MARCAS</label>
                                <select class="form-control selectpicker" name="filter-marca" id="filter-marca"
                                    data-filter-key="marca" onchange="filter(this)">
                                    <option value="">SELECCIONE UNA OPCION</option>
                                    <? foreach ($list_marcas as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nombre']; ?></option>
                                    <? endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="id_producto" class="form-label">BUSCADOR DE PRODUCTOS</label>
                                <input type="text" class="form-control" name="codigo_barras" id="codigo_barras">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="id_producto" class="form-label">LISTA DE PRODUCTOS</label>
                                <select class="form-control selectpicker" name="id_producto" id="id_producto"
                                    onchange="onchange_productos(this)">
                                    <option value="">SELECCIONE UNA OPCION</option>
                                    <? foreach ($list_productos as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>" data-cantidad="<?= $value['cantidad']; ?>"
                                        data-precio="<?= $value['precio']; ?>" data-sku="<?= $value['sku']; ?>"
                                        data-codigo_barras="<?= $value['codigo_barras']; ?>">
                                        <?= $value['nombre']; ?></option>
                                    <? endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="precio" class="form-label">PRECIO</label>
                                <input type="text" class="form-control" name="precio" id="precio" readonly
                                    value="0.00" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">CANTIDAD</label>
                                <input type="text" class="form-control numeric-integer" name="cantidad" id="cantidad" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="subtotal" class="form-label">SUBTOTAL</label>
                                <input type="text" class="form-control" name="subtotal" id="subtotal" readonly
                                    value="0.00" />
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-primary" id="btn_store" onclick="store()">AGREGAR</button>
                    <button type="button" class="btn btn-primary" id="btn_update" onclick="update()">ACTUALIZAR</button>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Footer-->
    </div>
</div>

<div class="row">
    <div class="col-9">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">LISTADO DE VENTA PRODUCTOS LINEAS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="datatable_refresh">
                <table id="datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>FOLIO</th>
                            <th>PRODUCTO</th>
                            <th>PRECIO</th>
                            <th>CANTIDAD</th>
                            <th>SUBTOTAL</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $value): ?>
                        <tr>
                            <td><?= esc($value['id']); ?></td>
                            <td><?= esc($value['producto']); ?></td>
                            <td>$ <?= number_format($value['precio'], 2); ?></td>
                            <td><?= esc($value['cantidad']); ?></td>
                            <td>$ <?= number_format($value['subtotal'], 2); ?></td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-xs" onclick="destroy(<?= $value['id'] ?>)"><i
                                        class="fa fa-times" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">TOTAL DE VENTA</h3>
            </div>
            <!-- /.card-header -->
            <form id="form-finalizar">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="id_metodo_pago" class="form-label">METODO DE PAGOS</label>
                                <select class="form-control selectpicker" name="id_metodo_pago" id="id_metodo_pago"
                                    onchange="onchange_metodopagos(this)">
                                    <option value="">SELECCIONE UNA OPCION</option>
                                    <? foreach ($list_tipopagos as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nombre']; ?></option>
                                    <? endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="metodopago-efectivo">
                        <div class="row">
                            <div class="col">
                                <label for="pago_cliente" class="form-label">EFECTIVO RECIBIDO</label>
                                <input type="text" class="form-control numeric" name="pago_cliente" id="pago_cliente">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="cambio_cliente" class="form-label">CAMBIO</label>
                                <input type="text" class="form-control numeric" name="cambio_cliente"
                                    id="cambio_cliente" readonly value="0.00">
                            </div>
                        </div>
                    </div>
                    <div id="metodopago-tarjeta">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="tipo_tarjeta" class="form-label">TIPO DE TARJETA</label>
                                    <select class="form-control selectpicker" name="tipo_tarjeta" id="tipo_tarjeta"
                                        onchange="onchange_tipotarjeta(this)">
                                        <option value="">SELECCIONE UNA OPCION</option>
                                        <option value="DEBITO">DEBITO</option>
                                        <option value="CREDITO">CREDITO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="categoria_tarjeta" class="form-label">CATEGORIA DE TARJETA</label>
                                    <select class="form-control selectpicker" name="categoria_tarjeta"
                                        id="categoria_tarjeta">
                                        <option value="">SELECCIONE UNA OPCION</option>
                                        <option value="VISA">VISA</option>
                                        <option value="MASTERCARD">MASTERCARD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="cod_referencia" class="form-label">REFERENCIA</label>
                                <input type="text" class="form-control numeric" name="cod_referencia"
                                    id="cod_referencia">
                            </div>
                        </div>
                    </div>

                    <div class=" row">
                        <div class="col">
                            <label for="subtotal" class="form-label">SUBTOTAL</label>
                            <input type="text" class="form-control numeric" name="subtotal" id="total_subtotal" readonly
                                value="<?= (!empty($data_totales)) ? number_format($data_totales['subtotal'], 2): 0 ; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="iva" class="form-label">IVA</label>
                            <input type="text" class="form-control numeric" name="iva" id="iva" readonly
                                value="<?= (!empty($data_totales)) ? number_format($data_totales['iva'], 2): 0 ; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="total" class="form-label">TOTAL</label>
                            <input type="text" class="form-control numeric" name="total" id="total" readonly
                                value="<?= (!empty($data_totales)) ? number_format($data_totales['total'], 2): 0 ; ?>">
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-primary" id="btn_finalizar"
                    onclick="finalizar()">FINALIZAR</button>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>