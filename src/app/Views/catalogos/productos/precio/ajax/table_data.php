<script src="<?= base_url('js/refresh/js_datatable.js?v='.time()); ?>"></script>

<table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>EMPRESA</th>
            <th>RPRODUCTO</th>
            <th>PRECIO COMPRA</th>
            <th>PRECIO VENTA</th>
            <th>PRECION VENTA MAYOREO</th>
            <th>AÑO</th>
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
            <td><?= esc($value['producto']); ?></td>
            <td>$ <?= number_format(esc($value['precio_compra']), 2); ?></td>
            <td>$ <?= number_format(esc($value['precio_venta']), 2); ?></td>
            <td>$ <?= number_format(esc($value['precio_venta_mayoreo']), 2); ?></td>
            <td><?= esc($value['anio']); ?></td>
            <td class="text-center">
                <? if(can('editar')): ?>
                <button class="btn btn-default btn-xs" onclick="edit(<?= $value['id'] ?>, 'precios')"><i
                        class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                <? endif; ?>
                <? if(can('eliminar')): ?>
                <button class="btn btn-<?=$btn_class;?> btn-xs" onclick="destroy(<?= $value['id'] ?>, 'precios')"><i
                        class="fa fa-<?=$btn_icon;?>" aria-hidden="true"></i></button>
                <? endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>