<script src="<?= base_url('js/refresh/js_datatable.js?v='.time()); ?>"></script>

<table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>EMPRESA</th>
            <th>MENU</th>
            <th>NAME</th>
            <th>ROUTE</th>
            <th>CONTROLLER</th>
            <th>METHOD</th>
            <th>ICON</th>
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
            <td><?= esc($value['empresa']); ?></td>
            <td><?= esc($value['menu']); ?></td>
            <td><?= esc($value['name']); ?></td>
            <td><?= esc($value['route']); ?></td>
            <td><?= esc($value['controller']); ?></td>
            <td><?= esc($value['method']); ?></td>
            <td class="text-center"><i class="<?= esc($value['icon']); ?>"></i></td>
            <td class="text-center">
                <? if(can('editar')): ?>
                <button class="btn btn-default btn-xs" onclick="edit(<?= $value['id'] ?>)"><i class="fas fa-pencil-alt"
                        aria-hidden="true"></i></button>
                <? endif; ?>
                <? if(can('eliminar')): ?>
                <button class="btn btn-<?=$btn_class;?> btn-xs" onclick="destroy(<?= $value['id'] ?>)"><i
                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
                <? endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>