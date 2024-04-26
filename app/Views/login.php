<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar sesión</title>
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
<form action="<?=base_url('login')?>" method="POST">
    <div class="row">
        <div class="col-12 mb-3">
            <img src="https://s3.amazonaws.com/media.greatplacetowork.com/peru/best-workplaces-for-women-in-peru/2024/utp/Logo-UTP.jpg" width="100%">
            <div class="text-center"><b class="fs-3">ESTACIONAMIENTO</b></div>
        </div>

        <?php if(!is_null(session()->get('success'))): ?>
        <div class="col-12">
            <p class="alert alert-success text-center"><?=session()->get('success')?></p>
        </div>
        <?php endif ?>

        <?php if(!is_null(session()->get('error'))): ?>
            <div class="col-12">
                <p class="alert alert-danger text-center"><?=session()->get('error')?></p>
            </div>
        <?php endif ?>

        <div class="col-12 mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" class="form-control text-center" id="username" name="username" minlength="5" maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('username')?></span>
        </div>
        <div class="col-12 mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control text-center" id="password" name="password" minlength="5" maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('password')?></span>
        </div>
        <div class="col-12 d-grid gap-2">
            <button class="btn btn-primary">Iniciar Sesión</button>
        </div>
        <div class="col-12 mt-2 text-center">
            <a href="<?=base_url('register')?>">Registrarse</a>
        </div>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>