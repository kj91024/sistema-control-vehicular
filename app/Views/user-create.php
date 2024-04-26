<?php require_once "header.php" ?>
<style>
    form {
        width: 600px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<form action="<?=base_url('register')?>" method="POST">

    <div class="row">
        <div class="col-12 mb-3">
            <div class="text-center"><b class="fs-3">REGISTRAR USUARIO</b></div>
        </div>

        <?php if(!is_null(session()->get('error'))): ?>
            <div class="col-12">
                <p class="alert alert-danger text-center"><?=session()->get('error')?></p>
            </div>
        <?php endif ?>
        <div class="col-12 mb-3">
            <label for="first_names" class="form-label">Tipo</label>
            <select class="form-control text-center" name="type" onchange="check(this)">
                <option value="profesor">Profesor</option>
                <option value="administrativo">Administrativo</option>
                <option value="seguridad">Seguridad</option>
                <option value="alumno">Alumno</option>
            </select>
            <ul class="mt-3">
                <li><i>Profesor y Alumno</i>, solo tienen histórico de sus propias actividades, tienen una tolerancia de 24 horas</li>
                <li><i>Administrativo</i>, solo tienen histórico de sus propias actividades</li>
                <li><i>Seguridad</i>, pueden revisar el centro de control y ver el histórico de la actividad de todos</li>
            </ul>
        </div>
        <div class="col-6 mb-3">
            <label for="first_names" class="form-label">Nombres</label>
            <input type="text" class="form-control text-center" id="first_names" name="first_names" value="<?= set_value('first_names') ?>"  maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('first_names')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="last_names" class="form-label">Apellidos</label>
            <input type="text" class="form-control text-center" id="last_names" name="last_names" value="<?= set_value('last_names') ?>" maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('last_names')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control text-center" id="dni" name="dni" value="<?= set_value('dni') ?>" minlength="8" required>
            <span class="form-text text-danger"><?=validation_show_error('dni')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="cellphone" class="form-label">Celular</label>
            <input type="number" class="form-control text-center" id="cellphone" name="cellphone" value="<?= set_value('cellphone') ?>" minlength="8" required>
            <span class="form-text text-danger"><?=validation_show_error('cellphone')?></span>
        </div>
        <div class="col-12 mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" class="form-control text-center" id="username" name="username" value="<?= set_value('username') ?>" minlength="5" maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('username')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control text-center" id="password" name="password" value="<?= set_value('password') ?>" minlength="5" maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('password')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="re_password" class="form-label">Repite contraseña</label>
            <input type="password" class="form-control text-center" id="re_pass
            word" name="re_password" value="<?= set_value('re_password') ?>" minlength="5" maxlength="30" required>
        </div>
        <div class="col-5 mb-3">
            <label for="license_number" class="form-label">Número de licencia</label>
            <input type="number" class="form-control text-center" id="license_number" name="license_number" value="<?= set_value('license_number') ?>" size="11" maxlength="11" required>
            <span class="form-text text-danger"><?=validation_show_error('license_number')?></span>
        </div>
        <div class="col-4 mb-3">
            <label for="plate" class="form-label">Número de placa</label>
            <input type="text" class="form-control text-center" id="plate" name="plate" maxlength="7" value="<?= set_value('plate') ?>" required>
            <span class="form-text text-danger"><?=validation_show_error('plate')?></span>
        </div>
        <div class="col-3 mb-3">
            <label for="color" class="form-label">Color del vehículo</label>
            <input style="height: 38px" type="color" class="form-control text-center" id="color" name="color" value="<?= set_value('color') ?>" maxlength="7" required>
            <span class="form-text text-danger"><?=validation_show_error('color')?></span>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary">Registrarse</button>
        </div>
    </div>
</form>
<script>
    function check(select){
        e = select.value;
        if(e == 'seguridad') {
            license_number.disabled = true;
            plate.disabled = true;
            color.disabled = true;
        } else {
            license_number.disabled = false;
            plate.disabled = false;
            color.disabled = false;
        }
    }
</script>
<?php require_once "footer.php" ?>