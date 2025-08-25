<script src="<?= base_url('js/puntoventas/caja/index.js?v='.time()); ?>"></script>

<div class="container">
    <div class="row align-items-center">
        <div class="col">
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">FORMULARIO PARA NUEVOS CLIENTES</div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form id="form">
                    <?= csrf_field() ?>
                    <!--begin::Body-->
                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                <label for="nombres" class="form-label">MONTO INICIAL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control numeric-integer" name="monto_inicial"
                                        id="monto_inicial">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary" id="btn_store" onclick="store()">AGREGAR</button>
                        <button type="button" class="btn btn-primary" id="btn_update"
                            onclick="update()">ACTUALIZAR</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Footer-->
        </div>
    </div>
</div>