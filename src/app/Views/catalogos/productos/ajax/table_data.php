<script src="<?= base_url('js/refresh/js_datatable.js?v='.time()); ?>"></script>

<table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>CATEGORIA</th>
            <th>SUBCATEGORIA</th>
            <th>MARCA</th>
            <th>TIPO</th>
            <th>SKU</th>
            <th>NOMBRE</th>
            <th>CODIGO DE BARRAS</th>
            <th>CANTIDAD</th>
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
            <td><?= esc($value['categoria']); ?></td>
            <td><?= esc($value['subcategoria']); ?></td>
            <td><?= esc($value['marca']); ?></td>
            <td><?= esc($value['tipo']); ?></td>
            <td><?= esc($value['sku']); ?></td>
            <td><?= esc($value['nombre']); ?></td>
            <td><?= esc($value['codigo_barras']); ?></td>
            <td><?= esc($value['cantidad']); ?></td>
            <td><?= ($value['descripcion']); ?></td>
            <td class="text-center">
                <button class="btn btn-default btn-xs" onclick="edit(<?= $value['id'] ?>, 'productos')"><i
                        class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                <button class="btn btn-<?=$btn_class;?> btn-xs" onclick="destroy(<?= $value['id'] ?>, 'productos')"><i
                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>