<script src="<?= base_url('js/catalogos/empresas/index.js?v='.time()); ?>"></script>

<div class="row">
    <div class="col-md-4">
        <!--begin::Quick Example-->
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">FORMULARIO PARA NUEVAS EMPRESAS</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form id="form">
                <?= csrf_field() ?>
                <!--begin::Body-->
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">NOMBRE</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" />
                    </div>
                    <div class="mb-3">
                        <label for="abreviacion" class="form-label">ABREVIACION</label>
                        <input type="text" class="form-control" id="abreviacion" name="abreviacion" />
                    </div>
                    <div class="mb-3">
                        <label for="razon_social" class="form-label">RAZON SOCIAL</label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social" />
                    </div>
                    <div class="mb-3">
                        <label for="rfc" class="form-label">RFC</label>
                        <input type="text" class="form-control" id="rfc" name="rfc" />
                    </div>
                    <div class="mb-3">
                        <label for="regimen" class="form-label">REGIMEN FISCAL</label>
                        <input type="text" class="form-control" id="regimen" name="regimen" />
                    </div>
                    <div class="mb-3">
                        <label for="codigo_postal" class="form-label">CODIGO POSTAL</label>
                        <input type="text" class="form-control number" id="codigo_postal" name="codigo_postal" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-MAIL</label>
                        <input type="text" class="form-control email" id="email" name="email" />
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
                <h3 class="card-title">LISTADO DE EMPRESAS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="datatable_refresh">
                <table id="datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>ABREVIACION</th>
                            <th>RAZON SOCIAL</th>
                            <th>RFC</th>
                            <th>REGIMEN FISCAL</th>
                            <th>CODIGO POSTAL</th>
                            <th>EMAIL</th>
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
                            <td><?= esc($value['abreviacion']); ?></td>
                            <td><?= esc($value['razon_social']); ?></td>
                            <td><?= esc($value['rfc']); ?></td>
                            <td><?= esc($value['regimen']); ?></td>
                            <td><?= esc($value['codigo_postal']); ?></td>
                            <td><?= esc($value['email']); ?></td>
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