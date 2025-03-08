<script src="<?= base_url('js/refresh/js_datatable.js?v='.time()); ?>"></script>

<table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>RAZON SOCIAL</th>
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
            <td><?= esc($value['razon_social']); ?></td>
            <td><?= esc($value['direccion']); ?></td>
            <td><?= esc($value['moneda']); ?></td>
            <td><?= esc($value['email_primario']); ?></td>
            <td><?= esc($value['telefono_primario']); ?></td>
            <td><?= esc($value['regimen_fiscal']); ?></td>
            <td><?= esc($value['uso_cfdi']); ?></td>
            <td><?= esc($value['tipo_cfdi']); ?></td>
            <td><?= esc($value['forma_pago']); ?></td>
            <td class="text-center">
                <button class="btn btn-default btn-xs" onclick="edit(<?= $value['id'] ?>)"><i class="fas fa-pencil-alt"
                        aria-hidden="true"></i></button>
                <button class="btn btn-<?=$btn_class;?> btn-xs" onclick="destroy(<?= $value['id'] ?>)"><i
                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>