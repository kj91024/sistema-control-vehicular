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
                                    <div><b>Estacionamiento: </b> <span><?=$item->place_name?></span></div>
                                    <div><b>Lugar: </b> <span><?=place($item->floor, $item->letter, $item->number)?></span></div>
                                    <div><b>Ingreso: </b> <span><?=cute_date($item->created_at)?></span></div>
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
                                    <div><b>Estacionamiento: </b> <span><?=$item->place_name?></span></div>
                                    <div><b>Lugar: </b> <span><?=place($item->floor, $item->letter, $item->number)?></span></div>
                                    <div><b>Ingreso: </b> <span><?=cute_date($item->created_at)?></span></div>
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
                                    <div><b>Estacionamiento: </b> <span><?=$item->place_name?></span></div>
                                    <div><b>Lugar: </b> <span><?=place($item->floor, $item->letter, $item->number)?></span></div>
                                    <div><b>Ingreso: </b> <span><?=cute_date($item->created_at)?></span></div>
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

        <hr>

        <div class="row mt-5 mb-5 gap-5">
            <?php foreach ($places as $item): ?>
                <div class="col row mb-3">
                    <div class="col-1">
                        <svg viewBox="0 0 1024 1024" class="icon" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#000000" d="M512 512a192 192 0 100-384 192 192 0 000 384zm0 64a256 256 0 110-512 256 256 0 010 512z"></path><path fill="#000000" d="M512 512a32 32 0 0132 32v256a32 32 0 11-64 0V544a32 32 0 0132-32z"></path><path fill="#000000" d="M384 649.088v64.96C269.76 732.352 192 771.904 192 800c0 37.696 139.904 96 320 96s320-58.304 320-96c0-28.16-77.76-67.648-192-85.952v-64.96C789.12 671.04 896 730.368 896 800c0 88.32-171.904 160-384 160s-384-71.68-384-160c0-69.696 106.88-128.96 256-150.912z"></path></g></svg>
                    </div>
                    <div class="col-8">
                        <h3><?=$item->place_name?></h3>
                        <p><?=$item->place_address?></p>
                    </div>
                    <div class="col-2 pt-2 pb-2 text-center" style="background: #f1f1f1; border-radius: 5px">
                        <div>Espacios</div>
                        <div class="text-center"><b style="color:<?=color_free($item->free, $item->spaces)?>;font-size: 1.75rem;"><?=$item->free?></b>/<b style="color:#444; font-size: 16px"><?=$item->spaces?></b></div>
                    </div>
                    <div class="col-1">
                        <a href="<?=base_url("parking/view/{$item->id}")?>" title="Ver disposición" class="btn btn-light" height="100%" style="height: 82px;padding: 26px 9px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708"/>
                                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
<?php require_once "footer.php"; ?>