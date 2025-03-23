<script src="<?= base_url('js/admin/users/index.js?v='.time()); ?>"></script>

<div class="row">
    <div class="col-md-12">
        <!--begin::Quick Example-->
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">FORMULARIO PARA NUEVOS USUARIOS</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form id="form">
                <?= csrf_field() ?>
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="id_role" class="form-label">ROLES</label>
                                <select class="form-control selectpicker" name="id_role" id="id_role">
                                    <option value="">SELECIONE UNA OPCION</option>
                                    <? foreach($list_role as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">NOMBRE COMPLETO</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email_primario" class="form-label">E-MAIL</label>
                                <input type="email" class="form-control email" id="email" name="email" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="pwd" class="form-label">CONTRASEÑA</label>
                                <input type="password" class="form-control" id="pwd" name="pwd" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="confirm_pwd" class="form-label">CONFIRMAR CONTRASEÑA</label>
                                <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" />
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
                <h3 class="card-title">LISTADO DE CLIENTES</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="datatable_refresh">
                <table id="datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ROLE</th>
                            <th>USER</th>
                            <th>NOMBRE COMPLETO</th>
                            <th>E-MAIL</th>
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
                            <td><?= esc($value['role']); ?></td>
                            <td><?= esc($value['usr']); ?></td>
                            <td><?= esc($value['nombre']); ?></td>
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