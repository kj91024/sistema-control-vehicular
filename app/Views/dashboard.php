<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div style="max-width: 1800px; margin: 0 auto;">
        <h1 class="text-center pt-5 pb-5">CENTRO DE CONTROL DEL ESTACIONAMIENTO</h1>
        <div class="row">
            <div class="col pb-3" style="background: #ecf6ff;">
                <h4 class="text-center mt-4">Placas Registradas</h4>
                <p class="text-center">Son las placas que están dentro de nuestra plataforma, y por lo tanto pueden acceder a nuestra infraestructura del estacionamiento.</p>
                <?php foreach($registered_plates as $item): ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title"><?=$item->plate?></h5>
                        <div><b>Propietario del vehículo: </b> <span><?=$item->first_names?> <?=$item->last_names?></span></div>
                        <div><b>DNI del Propietario: </b> <span><?=$item->dni?></span></div>
                        <div><b>Licencia vehicular: </b> <span><?=$item->license_number?></span></div>
                        <div><b>Color del vehículo: </b> <input type="color" value="<?=$item->color?>" style="width: 60px;height: 18px;" disabled></div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <div class="col pb-3">
                <h4 class="text-center mt-4">Carros Ingresando</h4>
                <p class="text-center">Son los últimos carros que han estado en el ingreso o que ya están ingresando en el lapso de 2 minutos.</p>
                <?php foreach($car_entering as $item) { ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title mb-0"><input type="color" value="<?=$item->color?>" style="width: 30px;height: 20px;" disabled> <?=$item->plate?></h5>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col pb-3">
                <h4 class="text-center mt-4">En el estacionamiento</h4>
                <p class="text-center">Son los carros que están dentro del recinto, tenemos prefijado que el vehículo solo puede estar 24 horas en el estacionamiento</p>
                <?php foreach($in_parking as $item): ?>

                    <?php if( $item->toomuch ): ?>
                    <div class="card text-bg-warning mt-3">
                    <?php else: ?>
                    <div class="card mt-3">
                    <?php endif;?>
                        <div class="card-header">
                            <?=$item->toago?> en el estacionamiento
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-0"><input type="color" value="<?=$item->color?>" style="width: 30px;height: 20px;" disabled> <?=$item->plate?></h5>
                            <?php if( $item->toomuch ): ?>
                            <div><b>Propietario del vehículo: </b> <span><?=$item->first_names?> <?=$item->last_names?></span></div>
                            <div><b>DNI: </b> <span><?=$item->dni?></span></div>
                            <div><b>Licencia vehicular: </b> <span><?=$item->first_names?></span></div>
                            <?php endif;?>
                            <div><b>Ingreso: </b> <span><?=$item->updated_at?></span></div>
                            <?php if( $item->toomuch ): ?>
                            <div class="mt-3 text-center">
                                <a href="tel:<?=$item->cellphone?>" class="btn btn-dark" style="width: 100%">Llamar al propietario</a>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>

                <?php endforeach ?>
            </div>
            <div class="col pb-3">
                <h4 class="text-center mt-4">Carros Saliendo</h4>
                <p class="text-center">Son los últimos carros que han estado en la salida o que ya están saliendo en el lapso de 2 minutos.</p>
                <?php foreach($car_leaving as $item): ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title mb-0"><input type="color" value="<?=$item->color?>" style="width: 30px;height: 20px;" disabled> <?=$item->plate?></h5>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="col pb-3" style="background: #fff5f5;">
                <h4 class="text-center mt-4">Placas no Registradas</h4>
                <p class="text-center">Son las placas que la IA ha detectado pero que no están dentro de nuestra plataforma y por lo tanto no pueden ingresar al estacionamiento.</p>

                <?php foreach($no_registered_plates as $item): ?>
                    <div class="card text-bg-danger mt-3">
                        <div class="card-body">
                            <h5 class="card-title"><?=$item->plate?></h5>
                            <div><b>Detectado: </b> <span><?=$item->created_at?></span></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>