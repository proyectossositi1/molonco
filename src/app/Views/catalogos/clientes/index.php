<script src="<?= base_url('js/catalogos/clientes/index.js?v='.time()); ?>"></script>

<div class="row">
    <div class="col-md-12">
        <!--begin::Quick Example-->
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">FORMULARIO PARA NUEVOS CLIENTES</div>
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
                                <label for="id_organizacion" class="form-label">ORGANIZACION</label>
                                <select class="form-control selectpicker" name="id_organizacion" id="id_organizacion">
                                    <option value="">SELECIONE UNA OPCION</option>
                                    <? foreach ($list_organizacion as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= strtoupper($value['razon_social']); ?>
                                    </option>
                                    <? endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">NOMBRE(S)</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="apellido_paterno" class="form-label">APELLIDO PATERNO</label>
                                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="apellido_materno" class="form-label">APELLIDO MATERNO</label>
                                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="direccion" class="form-label">DIRECCION</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="codigo_postal" class="form-label">CODIGO POSTAL</label>
                                <input type="text" class="form-control number" id="codigo_postal"
                                    name="codigo_postal" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email_primario" class="form-label">E-MAIL</label>
                                <input type="email" class="form-control email" id="email_primario"
                                    name="email_primario" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="telefono_primario" class="form-label">TELEFONO</label>
                                <input type="text" class="form-control numeric-integer" id="telefono_primario"
                                    name="telefono_primario" minlength="10" maxlength="10" />
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
                            <th>ORGANIZACION</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>DIRECCION</th>
                            <th>CODIGO POSTAL</th>
                            <th>EMAIL</th>
                            <th>TELEFONO</th>
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
                            <td><?= esc($value['organizacion']); ?></td>
                            <td><?= esc($value['nombres']); ?></td>
                            <td><?= esc($value['apellido_paterno']); ?></td>
                            <td><?= esc($value['apellido_materno']); ?></td>
                            <td><?= esc($value['direccion']); ?></td>
                            <td><?= esc($value['codigo_postal']); ?></td>
                            <td><?= esc($value['email_primario']); ?></td>
                            <td><?= esc($value['telefono_primario']); ?></td>
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