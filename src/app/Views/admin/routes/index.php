<script src="<?= base_url('js/admin/routes/index.js?v='.time()); ?>"></script>

<div class="row">
    <div class="col-md-4">
        <!--begin::Quick Example-->
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">FORMULARIO PARA NUEVA RUTA</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form id="form-route">
                <?= csrf_field() ?>
                <!--begin::Body-->
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">NOMBRE</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" />
                        <!-- <div id="nameHelp" class="form-text">
                            We'll never share your email with anyone else.
                        </div> -->
                    </div>
                    <div class="mb-3">
                        <label for="route" class="form-label">URL</label>
                        <input type="text" class="form-control" id="route" name="route" aria-describedby="routeHelp" />
                        <!-- <div id="routeHelp" class="form-text">
                            We'll never share your email with anyone else.
                        </div> -->
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">ICONO</label>
                        <input type="text" class="form-control" id="icon" name="icon" aria-describedby="iconHelp" />
                        <!-- <div id="urlHelp" class="form-text">
                            We'll never share your email with anyone else.
                        </div> -->
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
    <!--end::Quick Example-->
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">LISTADO DE RUTAS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="datatable_refresh">
                <table id="datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>ROUTE</th>
                            <th>ICON</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($rutas as $ruta): 
                                switch ($ruta['status_alta']) {
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
                            <td><?= esc($ruta['name']); ?></td>
                            <td><?= esc($ruta['route']); ?></td>
                            <td class="text-center"><i class="<?= esc($ruta['icon']); ?>"></i></td>
                            <td class="text-center">
                                <button class="btn btn-default btn-xs" onclick="edit(<?= $ruta['id'] ?>)"><i
                                        class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                                <button class="btn btn-<?=$btn_class;?> btn-xs" onclick="destroy(<?= $ruta['id'] ?>)"><i
                                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
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