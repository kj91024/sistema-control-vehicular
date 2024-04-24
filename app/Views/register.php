<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        form {
            width: 400px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
<form action="<?=base_url('register')?>" method="POST">
    <div class="row">
        <div class="col-12 mb-3">
            <img src="https://s3.amazonaws.com/media.greatplacetowork.com/peru/best-workplaces-for-women-in-peru/2024/utp/Logo-UTP.jpg" width="100%">
            <div class="text-center"><b class="fs-3">ESTACIONAMIENTO</b></div>
        </div>

        <?php if(!is_null(session()->get('error'))): ?>
        <div class="col-12">
            <p class="alert alert-danger text-center"><?=session()->get('error')?></p>
        </div>
        <?php endif ?>
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
            <input type="text" class="form-control text-center" id="username" name="username" value="<?= set_value('username') ?>" minlength="5" maxlength="11" required>
            <span class="form-text text-danger"><?=validation_show_error('username')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control text-center" id="password" name="password" value="<?= set_value('password') ?>" minlength="5" maxlength="20" required>
            <span class="form-text text-danger"><?=validation_show_error('password')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="re_password" class="form-label">Repite contraseña</label>
            <input type="password" class="form-control text-center" id="re_password" name="re_password" value="<?= set_value('re_password') ?>" minlength="5" maxlength="20" required>
        </div>
        <div class="col-5 mb-3">
            <label for="license_number" class="form-label">Número de <br>licencia</label>
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
        <div class="col-12 mt-2 text-center">
            <a href="<?=base_url('login')?>">Iniciar Sesión</a>
        </div>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>