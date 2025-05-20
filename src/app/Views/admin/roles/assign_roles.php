<script src="<?= base_url('js/admin/roles/asignar/index.js?v='.time()); ?>"></script>

<div class="row">
    <div class="col-md-4">
        <!--begin::Quick Example-->
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">ASIGNACION DE PERMISOS</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form id="form">
                <?= csrf_field() ?>
                <!--begin::Body-->
                <div class="card-body">
                    <? if(role(['super admin'])): ?>
                    <div class="mb-3">
                        <label for="id_empresa" class="form-label">EMPRESAS</label>
                        <select class="form-control selectpicker" name="id_empresa" id="id_empresa"
                            onchange="onchange_empresa()">
                            <option value="">SELECCIONE UNA OPCION</option>
                            <? foreach($list_empresas as $key => $value): ?>
                            <option value="<?= $value['id']; ?>"><?= $value['nombre'];?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                    <? endif; ?>
                    <div class="mb-3">
                        <label for="id_role" class="form-label">ROLES</label>
                        <select id="id_role" name="id_role" class="form-control selectpicker">
                            <option value="">ES NECESARIO SELECCIONAR UNA OPCION.</option>
                            <?php foreach ($list_roles as $rol): ?>
                            <option value="<?= esc($rol['id']); ?>"><?= esc($rol['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_permission" class="form-label">PERMISOS</label>
                        <select id="id_permission" name="id_permission" class="form-control selectpicker" multiple>
                            <option value="">ES NECESARIO SELECCIONAR UNA OPCION.</option>
                            <?php foreach ($list_permissions as $permission): ?>
                            <option value="<?= esc($permission['id']); ?>"><?= esc($permission['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer text-right">
                    <? if(can('agregar')): ?>
                    <button type="button" class="btn btn-primary" id="btn_store" onclick="store()">AGREGAR</button>
                    <? endif; ?>
                    <? if(can('actualizar')): ?>
                    <button type="button" class="btn btn-primary" id="btn_update" onclick="update()">ACTUALIZAR</button>
                    <? endif; ?>
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
                <h3 class="card-title">LISTADO DE PERMISOS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="datatable_refresh">
                <table id="datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ROLE</th>
                            <th>PERMISSION</th>
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
                            <td><?= esc($value['permission']); ?></td>
                            <td class="text-center">
                                <!-- <button class="btn btn-default btn-xs" onclick="edit(<? // $value['id'] ?>)"><i
                                        class="fas fa-pencil-alt" aria-hidden="true"></i></button> -->

                                <? if(can('eliminar')): ?>
                                <button class="btn btn-<?=$btn_class;?> btn-xs"
                                    onclick="destroy(<?= $value['id'] ?>)"><i class="fa fa-<?=$btn_icon;?>"
                                        aria-hidden="true"></i></button>
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