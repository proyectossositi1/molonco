<script src="<?= base_url('js/refresh/js_datatable.js?v='.time()); ?>"></script>

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
                <button class="btn btn-default btn-xs" onclick="edit(<?= $value['id'] ?>)"><i class="fas fa-pencil-alt"
                        aria-hidden="true"></i></button>
                <button class="btn btn-<?=$btn_class;?> btn-xs" onclick="destroy(<?= $value['id'] ?>)"><i
                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>