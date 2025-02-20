<h2>Asignar Permisos</h2>
<form action="<?= site_url('/route/asignar/store'); ?>" method="post">
    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="rol_id" class="form-control">
            <?php foreach ($roles as $rol): ?>
            <option value="<?= esc($rol['id']); ?>"><?= esc($rol['nombre']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Rutas</label>
        <?php foreach ($rutas as $ruta): ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ruta_id[]" value="<?= esc($ruta['id']); ?>">
            <label class="form-check-label"><?= esc($ruta['nombre']); ?></label>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>