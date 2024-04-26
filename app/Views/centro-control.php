<?php require_once "header.php"; ?>
    <div class="container">
        <h1 class="text-center pt-5 pb-5">CENTRO DE CONTROL DEL ESTACIONAMIENTO</h1>
        <div class="row">
            <div class="col pb-3">
                <h4 class="text-center mt-4">Carros Ingresando</h4>
                <p class="text-center">Son los últimos carros que han estado en el ingreso o que ya están ingresando en el lapso de 2 minutos.</p>
                <?php foreach($car_entering as $item) { ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?=base_url('assets/images/in.svg')?>" width="100%">
                                </div>
                                <div class="col">
                                    <h5 class="card-title mb-0"><input type="color" value="<?=$item->color?>" style="width: 30px;height: 20px;" disabled> <?=$item->plate?></h5>
                                    <div><b>Ingreso: </b> <span><?=date('Y-m-d h:i:s')?></span></div>
                                </div>
                                <div class="col-2 pt-1">
                                    <a href="<?=base_url("user/history/{$item->id}")?>" class="btn btn-light">
                                        <img src="<?=base_url('assets/images/path.svg')?>" alt="" width="100%">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col pb-3">
                <h4 class="text-center mt-4">En el estacionamiento</h4>
                <p class="text-center">Son los carros que están dentro del recinto, tenemos prefijado que el vehículo solo puede estar 24 horas en el estacionamiento.</p>
                <?php foreach($in_parking as $item): ?>

                    <?php if( $item->toomuch ): ?>
                    <div class="card text-bg-warning mt-3">
                    <?php else: ?>
                    <div class="card mt-3">
                    <?php endif;?>
                        <div class="card-header">
                            Está en el estacionamiento <i><?=strtolower($item->toago)?></i>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?=base_url('assets/images/stay.svg')?>" width="100%">
                                </div>
                                <div class="col">

                                    <h5 class="card-title mb-0"><input type="color" value="<?=$item->color?>" style="width: 20px;height: 20px;" disabled> <?=$item->plate?></h5>
                                    <?php if( $item->toomuch ): ?>
                                        <div><b>Propietario del vehículo: </b> <span><?=$item->first_names?> <?=$item->last_names?></span></div>
                                        <div><b>DNI: </b> <span><?=$item->dni?></span></div>
                                        <div><b>Licencia vehicular: </b> <span><?=$item->license_number?></span></div>
                                    <?php endif;?>
                                    <div><b>Ingreso: </b> <span><?=$item->updated_at?></span></div>
                                    <?php if( $item->toomuch ): ?>
                                        <div class="mt-3 text-center">
                                            <a href="tel:<?=$item->cellphone?>" class="btn btn-dark" style="width: 100%">Llamar al propietario</a>
                                        </div>
                                    <?php endif;?>

                                </div>
                                <div class="col-2 pt-1">
                                    <a href="<?=base_url("user/history/{$item->id_user}")?>" class="btn btn-light">
                                        <img src="<?=base_url('assets/images/path.svg')?>" alt="" width="100%">
                                    </a>
                                </div>
                            </div>
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
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?=base_url('assets/images/in.svg')?>" width="100%">
                                </div>
                                <div class="col">
                                    <h5 class="card-title mb-0"><input type="color" value="<?=$item->color?>" style="width: 30px;height: 20px;" disabled> <?=$item->plate?></h5>
                                    <div><b>Ingreso: </b> <span><?=date('Y-m-d h:i:s')?></span></div>
                                </div>
                                <div class="col-2 pt-1">
                                    <a href="<?=base_url("user/history/{$item->id}")?>" class="btn btn-light">
                                        <img src="<?=base_url('assets/images/path.svg')?>" alt="" width="100%">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
<?php require_once "footer.php"; ?>