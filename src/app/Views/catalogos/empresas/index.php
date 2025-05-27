<script src="<?= base_url('js/catalogos/empresas/index.js?v='.time()); ?>"></script>

<div class="row">
    <div class="col-md-12">
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
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="id_sat_regimen_fiscal" class="form-label">REGIMEN FISCAL</label>
                                <select class="form-control selectpicker" name="id_sat_regimen_fiscal"
                                    id="id_sat_regimen_fiscal">
                                    <option value="">SELECIONE UNA OPCION</option>
                                    <? foreach ($list_regimen as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= strtoupper($value['descripcion']); ?>
                                    </option>
                                    <? endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="id_sat_tipo_cfdi" class="form-label">TIPO CFDI</label>
                                <select class="form-control selectpicker" name="id_sat_tipo_cfdi" id="id_sat_tipo_cfdi">
                                    <option value="">SELECIONE UNA OPCION</option>
                                    <? foreach ($list_tipocfdi as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= strtoupper($value['descripcion']); ?>
                                    </option>
                                    <? endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="id_sat_uso_cfdi" class="form-label">USO CFDI</label>
                                <select class="form-control selectpicker" name="id_sat_uso_cfdi" id="id_sat_uso_cfdi">
                                    <option value="">SELECIONE UNA OPCION</option>
                                    <? foreach ($list_usocfdi as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= strtoupper($value['descripcion']); ?>
                                    </option>
                                    <? endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="id_sat_forma_pago" class="form-label">FORMA DE PAGO</label>
                                <select class="form-control selectpicker" name="id_sat_forma_pago"
                                    id="id_sat_forma_pago">
                                    <option value="">SELECIONE UNA OPCION</option>
                                    <? foreach ($list_formapago as $key => $value): ?>
                                    <option value="<?= $value['id']; ?>"><?= strtoupper($value['descripcion']); ?>
                                    </option>
                                    <? endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">NOMBRE</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="abreviacion" class="form-label">ABREVIACION</label>
                                <input type="text" class="form-control" id="abreviacion" name="abreviacion"
                                    minlength="3" maxlength="3" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="razon_social" class="form-label">RAZON SOCIAL</label>
                                <input type="text" class="form-control" id="razon_social" name="razon_social" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="rfc" class="form-label">RFC</label>
                                <input type="text" class="form-control" id="rfc" name="rfc" minlength="13"
                                    maxlength="13" />
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
                                <input type="text" class="form-control numeric-integer" id="codigo_postal"
                                    name="codigo_postal" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
<<<<<<< HEAD
                                <label for="moneda" class="form-label">MONEDA</label>
=======
                                <label for="moneda" class="form-label">MOENDA</label>
>>>>>>> af4c69ae568a200e9234b72a0cb8ebf08eadd320
                                <input type="text" class="form-control numeric-integer" id="moneda" name="moneda" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email_primario" class="form-label">E-MAIL</label>
                                <input type="email" class="form-control email" id="email_primario"
                                    name="email_primario" />
                            </div>
                        </div>
                        <div class="col-md-4">
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
                <h3 class="card-title">LISTADO DE EMPRESAS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="datatable_refresh">
                <table id="datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>ABREV</th>
                            <th>RAZON SOCIAL</th>
                            <th>RFC</th>
                            <th>DIRECCION</th>
                            <th>MONEDA</th>
                            <th>EMAIL</th>
                            <th>TELEFONO</th>
                            <th>REGIMEN FISCAL</th>
                            <th>USO CFDI</th>
                            <th>TIPO CFDI</th>
                            <th>FORMA DE PAGO</th>
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
                            <td><?= esc($value['direccion']); ?></td>
                            <td><?= esc($value['moneda']); ?></td>
                            <td><?= esc($value['email_primario']); ?></td>
                            <td><?= esc($value['telefono_primario']); ?></td>
                            <td><?= esc($value['regimen_fiscal']); ?></td>
                            <td><?= esc($value['uso_cfdi']); ?></td>
                            <td><?= esc($value['tipo_cfdi']); ?></td>
                            <td><?= esc($value['forma_pago']); ?></td>
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