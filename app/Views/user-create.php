<?php
require_once "header.php";
function input_value(\CodeIgniter\Entity\Entity $entity, string $attribute, $default = ''){
    return empty($entity->{$attribute}) ? ( !empty(old($attribute)) ? old($attribute) : $default )
        : $entity->{$attribute};
}
?>
<style>
    form {
        width: 600px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<form action="<?=base_url(is_null($user->type) ? 'register' : "user/edit/{$id_user}")?>" method="POST">

    <div class="row">
        <div class="col-12 mb-3">
            <div class="text-center"><b class="fs-3">REGISTRAR USUARIO</b></div>
        </div>

        <?php if(!is_null(session()->get('error'))): ?>
            <div class="col-12">
                <p class="alert alert-danger text-center"><?=session()->get('error')?></p>
            </div>
        <?php endif ?>

        <?php

        $session = session()->get("user");
        if( $session['type'] == 'seguridad' ){ ?>
        <div class="col-12 mb-3">
            <label for="first_names" class="form-label">Tipo</label>
            <select class="form-control text-center" name="type" onchange="check(this)">
                <option value="profesor" <?= input_value($user, 'type') == 'profesor'? 'selected' : '' ?>>Profesor</option>
                <option value="administrativo" <?= input_value($user, 'type') == 'administrativo'? 'selected' : '' ?>>Administrativo</option>
                <option value="seguridad" <?= input_value($user, 'type') == 'seguridad' ? 'selected' : ''?>>Seguridad</option>
                <option value="alumno" <?= input_value($user, 'type') == 'alumno' ? 'selected' : ''?>>Alumno</option>
            </select>
            <span class="form-text text-danger"><?=validation_show_error('type')?></span>
            <ul class="mt-3">
                <li><i>Profesor y Alumno</i>, solo tienen histórico de sus propias actividades, tienen una tolerancia de 24 horas</li>
                <li><i>Administrativo</i>, solo tienen histórico de sus propias actividades</li>
                <li><i>Seguridad</i>, pueden revisar el centro de control y ver el histórico de la actividad de todos</li>
            </ul>
        </div>
        <?php } else {?>
            <input type="hidden" name="type" value="<?=$session['type']?>">
        <?php } ?>

        <div class="col-6 mb-3">
            <label for="first_names" class="form-label">Nombres</label>
            <input type="text" class="form-control text-center" id="first_names" name="first_names" value="<?= input_value($user, 'first_names') ?>"  maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('first_names')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="last_names" class="form-label">Apellidos</label>
            <input type="text" class="form-control text-center" id="last_names" name="last_names" value="<?= input_value($user, 'last_names') ?>" maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('last_names')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control text-center" id="dni" name="dni" value="<?= input_value($user, 'dni') ?>" minlength="8" required>
            <span class="form-text text-danger"><?=validation_show_error('dni')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="cellphone" class="form-label">Celular</label>
            <input type="number" class="form-control text-center" id="cellphone" name="cellphone" value="<?= input_value($user, 'cellphone') ?>" minlength="8" required>
            <span class="form-text text-danger"><?=validation_show_error('cellphone')?></span>
        </div>
        <div class="col-4 mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" class="form-control text-center" id="username" name="username" value="<?= input_value($user, 'username') ?>" minlength="5" maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('username')?></span>
        </div>
        <div class="col-4 mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control text-center" id="password" name="password" minlength="5" maxlength="30" required>
            <span class="form-text text-danger"><?=set_value('password')?></span>
        </div>
        <div class="col-4 mb-3">
            <label for="re_password" class="form-label">Repite contraseña</label>
            <input type="password" class="form-control text-center" id="re_password" id="re_password" name="re_password" value="<?= set_value('re_password') ?>" minlength="5" maxlength="30" required>
        </div>
        <div class="col-4 mb-3">
            <label for="license_number" class="form-label">Número de licencia</label>
            <input type="number" class="form-control text-center" id="license_number" name="license_number" value="<?= input_value($user, 'license_number') ?>" size="11" maxlength="11" required>
            <span class="form-text text-danger"><?=validation_show_error('license_number')?></span>
        </div>

        <div class="col-4 mb-3">
            <label for="plate" class="form-label">Número de placa</label>
            <input type="text" class="form-control text-center" id="plate" name="plate" maxlength="7" value="<?= input_value($user, 'plate') ?>" required>
            <span class="form-text text-danger"><?=validation_show_error('plate')?></span>
        </div>
        <div class="col-4 mb-3">
            <label for="color" class="form-label">Color del vehículo</label>
            <input style="height: 38px" type="color" class="form-control text-center" id="color" name="color" value="<?= input_value($user, 'color') ?>" maxlength="7" required>
            <span class="form-text text-danger"><?=validation_show_error('color')?></span>
        </div>
        <div class="col">
            <p class="alert alert-secondary text-center"> Si el tipo de usuario es de "Seguridad" entonces no es necesario llenar el número de placa, ni el el color del vehículo.</p>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary">Enviar</button>
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