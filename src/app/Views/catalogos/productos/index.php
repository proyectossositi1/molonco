<script src="<?= base_url('js/catalogos/productos/index.js?v='.time()); ?>"></script>

<div class="row">
    <div class="col-md-12">

        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="a-tab-categorias" data-toggle="pill" href="#tab-categorias"
                            role="tab" aria-controls="tab-categorias" aria-selected="true">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="a-tab-subcategorias" data-toggle="pill" href="#tab-subcategorias"
                            role="tab" aria-controls="tab-subcategorias" aria-selected="false">Sub Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="a-tab-marcas" data-toggle="pill" href="#tab-marcas" role="tab"
                            aria-controls="tab-marcas" aria-selected="false">Marcas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="a-tab-tipos" data-toggle="pill" href="#tab-tipos" role="tab"
                            aria-controls="tab-tipos" aria-selected="false">Tipos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="a-tab-productos" data-toggle="pill" href="#tab-productos" role="tab"
                            aria-controls="tab-productos" aria-selected="false">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="a-tab-precios" data-toggle="pill" href="#tab-precios" role="tab"
                            aria-controls="tab-precios" aria-selected="false">Precios</a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="tab-categorias" role="tabpanel"
                        aria-labelledby="a-tab-categorias">
                        <form id="form-categorias">
                            <?= csrf_field() ?>
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">NOMBRE</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label">DESCRIPCION</label>
                                            <textarea name="descripcion" id="descripcion"
                                                class="form-control textareapicker"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->

                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" id="btn_store-categorias"
                                    onclick='store("categorias")'>AGREGAR</button>
                                <button type="button" class="btn btn-primary" id="btn_update-categorias"
                                    onclick='update("categorias")'>ACTUALIZAR</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="tab-subcategorias" role="tabpanel"
                        aria-labelledby="a-tab-subcategorias">
                        <form id="form-subcategorias">
                            <?= csrf_field() ?>
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                    <? if(role(['super admin'])): ?>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_empresa" class="form-label">EMPRESAS</label>
                                            <select class="form-control selectpicker" name="id_empresa" id="id_empresa">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_empresas as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <? endif; ?>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_categoria" class="form-label">CATEGORIAS</label>
                                            <select class="form-control selectpicker" name="id_categoria"
                                                id="id_categoria">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_categorias as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">NOMBRE</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label">DESCRIPCION</label>
                                            <textarea name="descripcion" id="descripcion"
                                                class="form-control textareapicker"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->

                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" id="btn_store-subcategorias"
                                    onclick='store("subcategorias")'>AGREGAR</button>
                                <button type="button" class="btn btn-primary" id="btn_update-subcategorias"
                                    onclick='update("subcategorias")'>ACTUALIZAR</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="tab-marcas" role="tabpanel" aria-labelledby="a-tab-marcas">
                        <form id="form-marcas">
                            <?= csrf_field() ?>
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                    <? if(role(['super admin'])): ?>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_empresa" class="form-label">EMPRESAS</label>
                                            <select class="form-control selectpicker" name="id_empresa" id="id_empresa">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_empresas as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <? endif; ?>
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">NOMBRE</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label">DESCRIPCION</label>
                                            <textarea name="descripcion" id="descripcion"
                                                class="form-control textareapicker"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->

                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" id="btn_store-marcas"
                                    onclick='store("marcas")'>AGREGAR</button>
                                <button type="button" class="btn btn-primary" id="btn_update-marcas"
                                    onclick='update("marcas")'>ACTUALIZAR</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="tab-tipos" role="tabpanel" aria-labelledby="a-tab-tipos">
                        <form id="form-tipos">
                            <?= csrf_field() ?>
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                    <? if(role(['super admin'])): ?>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_empresa" class="form-label">EMPRESAS</label>
                                            <select class="form-control selectpicker" name="id_empresa" id="id_empresa">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_empresas as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <? endif; ?>
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">NOMBRE</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label">DESCRIPCION</label>
                                            <textarea name="descripcion" id="descripcion"
                                                class="form-control textareapicker"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->

                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" id="btn_store-tipos"
                                    onclick='store("tipos")'>AGREGAR</button>
                                <button type="button" class="btn btn-primary" id="btn_update-tipos"
                                    onclick='update("tipos")'>ACTUALIZAR</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="tab-productos" role="tabpanel" aria-labelledby="a-tab-productos">
                        <form id="form-productos">
                            <?= csrf_field() ?>
                            <!--begin::Body-->
                            <div class="card-body">
                                <? if(role(['super admin'])): ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_empresa" class="form-label">EMPRESAS</label>
                                            <select class="form-control selectpicker" name="id_empresa" id="id_empresa">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_empresas as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <? endif; ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_categoria" class="form-label">CATEGORIAS</label>
                                            <select class="form-control selectpicker" name="id_categoria"
                                                id="id_categoria_producto" onchange="onchange_categorias()">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_categorias as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_subcategoria" class="form-label">SUB
                                                CATEGORIAS</label>
                                            <select class="form-control selectpicker" name="id_subcategoria"
                                                id="id_subcategoria">
                                                <option value="">SELECIONE UNA OPCION</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_tipo_producto" class="form-label">TIPOS</label>
                                            <select class="form-control selectpicker" name="id_tipo_producto"
                                                id="id_tipo_producto">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_tipos as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_marca" class="form-label">MARCAS</label>
                                            <select class="form-control selectpicker" name="id_marca" id="id_marca">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_marcas as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="codigo_barras" class="form-label">CODIGO DE BARRAS</label>
                                            <input type="text" class="form-control numeric-integer" name="codigo_barras"
                                                id="codigo_barras">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input type="text" class="form-control" name="sku" id="sku">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">NOMBRE</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="cantidad" class="form-label">CANTIDAD</label>
                                            <input type="text" class="form-control numeric-decimal" name="cantidad"
                                                id="cantidad">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label">DESCRIPCION</label>
                                            <textarea name="descripcion" id="descripcion"
                                                class="form-control textareapicker"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" id="btn_store-productos"
                                    onclick='store("productos")'>AGREGAR</button>
                                <button type="button" class="btn btn-primary" id="btn_update-productos"
                                    onclick='update("productos")'>ACTUALIZAR</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="tab-precios" role="tabpanel" aria-labelledby="a-tab-precios">
                        <form id="form-precios">
                            <?= csrf_field() ?>
                            <!--begin::Body-->
                            <div class="card-body">
                                <? if(role(['super admin'])): ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_empresa" class="form-label">EMPRESAS</label>
                                            <select class="form-control selectpicker" name="id_empresa" id="id_empresa">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_empresas as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <? endif; ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="id_producto" class="form-label">PRODUCTOS</label>
                                            <select class="form-control selectpicker" name="id_producto"
                                                id="id_producto_precio">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? foreach ($list_productos as $key => $value): ?>
                                                <option value="<?= $value['id']; ?>">
                                                    <?= strtoupper($value['nombre']); ?></option>
                                                <? endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="precio_compra" class="form-label">PRECIO COMPRA</label>
                                            <input type="text" class="form-control numeric-decimal" name="precio_compra"
                                                id="precio_compra">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="precio_venta" class="form-label">PRECIO VENTA</label>
                                            <input type="text" class="form-control numeric-decimal" name="precio_venta"
                                                id="precio_venta">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="precio_venta_mayoreo" class="form-label">PRECIO VENTA
                                                MAYOREO</label>
                                            <input type="text" class="form-control numeric-decimal"
                                                name="precio_venta_mayoreo" id="precio_venta_mayoreo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="anio" class="form-label">AÑO</label>
                                            <select class="form-control selectpicker" name="anio" id="anio">
                                                <option value="">SELECIONE UNA OPCION</option>
                                                <? 
                                                    $current = date('Y');
                                                    for ($i = date('Y'); $i <= (date('Y')+5);$i++): 
                                                ?>
                                                <option value="<?= $i ?>" <?= $i === $current ? 'selected' : '' ?>>
                                                    <?= $i; ?></option>
                                                <? endfor ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                            <div class="card-footer text-right">
                                <button type="button" class="btn btn-primary" id="btn_store-precios"
                                    onclick='store("precios")'>AGREGAR</button>
                                <button type="button" class="btn btn-primary" id="btn_update-precios"
                                    onclick='update("precios")'>ACTUALIZAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card -->

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">LISTADO DE <span id="table-title">CATEGORIAS</span></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="datatable_refresh">
                <table id="datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>DESCRIPCION</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($data as $key => $value): 
                                switch ($value['status_alta']) {
                                    case 1:
                                        $btn_class = 'danger';
                                        $btn_icon = 'times';
                                        break;
                                    case 0:
                                        $btn_class = 'success';
                                        $btn_icon = 'check';
                                        break;
                                }
                        ?>
                        <tr>
                            <td><?= esc($value['id']); ?></td>
                            <td><?= esc($value['nombre']); ?></td>
                            <td><?= ($value['descripcion']); ?></td>
                            <td class="text-center">
                                <? if(can('editar')): ?>
                                <button class="btn btn-default btn-xs"
                                    onclick="edit(<?= $value['id'] ?>, 'categorias')"><i class="fas fa-pencil-alt"
                                        aria-hidden="true"></i></button>
                                <? endif; ?>
                                <? if(can('eliminar')): ?>
                                <button class="btn btn-<?=$btn_class;?> btn-xs"
                                    onclick="destroy(<?= $value['id'] ?>, 'categorias')"><i
                                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
                                <? endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>