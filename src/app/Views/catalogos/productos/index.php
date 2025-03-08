<script src="<?= base_url('js/catalogos/productos/index.js?v='.time()); ?>"></script>

<div class="row">
    <div class="col-md-12">
        <!--begin::Quick Example-->
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">FORMULARIO PARA NUEVAS PRODUCTOS</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form id="form">
                <?= csrf_field() ?>
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="id_tipo_producto" class="form-label">TIPO PRODUCTO</label>
                                <select class="form-control selectpicker" name="id_tipo_producto" id="id_tipo_producto">
                                    <option value="">SELECIONE UNA OPCION</option>
                                    <? foreach ($list_tipos as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= strtoupper($value['nombre']); ?></option>
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
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="codigo_barras" class="form-label">CODIGO DE BARRAS</label>
                                <input type="text" class="form-control" name="codigo_barras" id="codigo_barras">
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
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">LISTADO DE ORGANIZACIONES</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="datatable_refresh">
                <table id="datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TIPO</th>
                            <th>NOMBRE</th>
                            <th>CODIGO DE BARRAS</th>
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
                            <td><?= esc($value['tipo_producto']); ?></td>
                            <td><?= esc($value['nombre']); ?></td>
                            <td><?= esc($value['codigo_barras']); ?></td>
                            <td><?= ($value['descripcion']); ?></td>
                            <td class="text-center">
                                <button class="btn btn-default btn-xs" onclick="edit(<?= $value['id'] ?>)"><i
                                        class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                                <button class="btn btn-<?=$btn_class;?> btn-xs"
                                    onclick="destroy(<?= $value['id'] ?>)"><i class="fa fa-<?=$btn_icon;?>"
                                        aria-hidden="true"></i></button>
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