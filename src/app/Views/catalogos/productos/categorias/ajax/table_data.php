<script src="<?= base_url('js/refresh/js_datatable.js?v='.time()); ?>"></script>

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
                <button class="btn btn-default btn-xs" onclick="edit(<?= $value['id'] ?>, 'categorias')"><i
                        class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                <? endif; ?>
                <? if(can('eliminar')): ?>
                <button class="btn btn-<?=$btn_class;?> btn-xs" onclick="destroy(<?= $value['id'] ?>, 'categorias')"><i
                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
                <? endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>