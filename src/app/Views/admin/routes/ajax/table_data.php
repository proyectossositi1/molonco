<script src="<?= base_url('js/refresh/js_datatable.js?v='.time()); ?>"></script>

<table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
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
            <td><?= esc($ruta['id']); ?></td>
            <td><?= esc($ruta['menu']); ?></td>
            <td><?= esc($ruta['name']); ?></td>
            <td><?= esc($ruta['route']); ?></td>
            <td><?= esc($ruta['controller']); ?></td>
            <td><?= esc($ruta['method']); ?></td>
            <td class="text-center"><i class="<?= esc($ruta['icon']); ?>"></i></td>
            <td class="text-center">
                <button class="btn btn-default btn-xs" onclick="edit(<?= $ruta['id'] ?>)"><i class="fas fa-pencil-alt"
                        aria-hidden="true"></i></button>
                <button class="btn btn-<?=$btn_class;?> btn-xs" onclick="destroy(<?= $ruta['id'] ?>)"><i
                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>