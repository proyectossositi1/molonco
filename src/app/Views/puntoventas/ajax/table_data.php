<script src="<?= base_url('js/refresh/js_datatable.js?v='.time()); ?>"></script>

<table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>FOLIO</th>
            <th>PRODUCTO</th>
            <th>PRECIO</th>
            <th>CANTIDAD</th>
            <th>SUBTOTAL</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $key => $value): ?>
        <tr>
            <td><?= esc($value['id']); ?></td>
            <td><?= esc($value['producto']); ?></td>
            <td>$ <?= number_format($value['precio'], 2); ?></td>
            <td><?= esc($value['cantidad']); ?></td>
            <td>$ <?= number_format($value['subtotal'], 2); ?></td>
            <td class="text-center">
                <button class="btn btn-danger btn-xs" onclick="destroy(<?= $value['id'] ?>)"><i class="fa fa-times"
                        aria-hidden="true"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>