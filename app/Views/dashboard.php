<?php require_once "header.php"; ?>
    <div class="container">
    <h1 class="text-center pt-5 pb-5">Dashboard</h1>

    <?php if(!$out): ?>
    <div class="row" style="max-width:600px; margin: 10px auto;">
        <div>
            <h3 class="mb-5 text-center">Disponibilidad de estacionamiento</h3>
            <?php foreach ($places as $item): ?>
                <div class="col-12 row mb-3">
                    <div class="col-1">
                        <svg viewBox="0 0 1024 1024" class="icon" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#000000" d="M512 512a192 192 0 100-384 192 192 0 000 384zm0 64a256 256 0 110-512 256 256 0 010 512z"></path><path fill="#000000" d="M512 512a32 32 0 0132 32v256a32 32 0 11-64 0V544a32 32 0 0132-32z"></path><path fill="#000000" d="M384 649.088v64.96C269.76 732.352 192 771.904 192 800c0 37.696 139.904 96 320 96s320-58.304 320-96c0-28.16-77.76-67.648-192-85.952v-64.96C789.12 671.04 896 730.368 896 800c0 88.32-171.904 160-384 160s-384-71.68-384-160c0-69.696 106.88-128.96 256-150.912z"></path></g></svg>
                    </div>
                    <div class="col">
                        <h3><?=$item->place_name?></h3>
                        <p><?=$item->place_address?></p>
                    </div>
                    <div class="col-3 pt-2 pb-2 text-center" style="background: #f1f1f1; border-radius: 5px">
                        <div>Espacios</div>
                        <div class="text-center"><b style="color:<?=color_free($item->free, $item->spaces)?>;font-size: 1.75rem;"><?=$item->free?></b>/<b style="color:#444; font-size: 16px"><?=$item->spaces?></b></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if($read_qr):?>
        <div id="qr" style="width: 100%">
            <a href="<?=base_url("scan-qr/{$record->id}")?>" class="btn btn-primary btn-lg" style="width:100%;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                    <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z"/>
                    <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z"/>
                    <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z"/>
                    <path d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z"/>
                    <path d="M12 9h2V8h-2z"/>
                </svg>
                <span>Escanear QR</span>
            </a>
        </div>
        <?php endif; ?>

        <hr class="mt-3">

        <div class="col-12 mt-3">
            <h5>Para poder ingresar sigue estos pasos:</h5>
            <ol>
                <li>Verifica en la parte de arriba la disponibilidad que hay en el estacionamiento.</li>
                <li>Lleva tu auto al estacionamiento que te convenga.</li>
                <li>Cuando estes frente al ingreso o salida del estacionamiento procura estacionar el carro tangencialmente, porque la IA identificará el número de placa de tu vehículo.</li>
                <li>Actualiza esta pantalla y examina el QR que te permitirá el acceso al estacionamiento</li>
                <li>Cuando ya estés dentro del estacionamiento y hallas estacionado el vehículo, <b>ingresa la ubicación en donde lo has colocado, porque sino el sistema no te dejara salir.</b></li>
            </ol>
            <p class="alert alert-secondary">Nota: Si no hay espacio el sistema no te permitirá ingresar al estacionamiento, te recomendamos revisar la plataforma para saber que estacionamiento esta más disponible.</p>
        </div>
    </div>
    <?php else: ?>
    <div style="max-width:600px; margin: 10px auto;">
        <h3 class="text-center mb-4">Bienvenido al estacionamiento</h3>
        <?php if($is_save == false): ?>
            <p class="alert mb-4 alert-danger text-center">Si no colocas en donde estacionaste el carro no podrás salir del estacionamiento, puedes escanear la ubicacion mediante el QR que esta en el suelo.</p>
        <?php endif; ?>
        <form class="row" action="<?=base_url("record/update/place/{$last_history['id_record']}")?>" method="POST">
            <div class="col-12 mb-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center bg-light" colspan="4">Vehículo</th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr>
                                <td><b>Número de placa</b></td>
                                <td><?=$car->plate?></td>
                                <td><b>Color del vehículo</b></td>
                                <td><input type="color" value="<?=$car->color?>" disabled></td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center bg-light" colspan="2">Estacionamiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="190px"><b>Ubicación</b></td>
                            <td><?=$last_history['place_name']?></td>
                        </tr>
                        <tr>
                            <td><b>Dirección</b></td>
                            <td><?=$last_history['place_address']?></td>
                        </tr>
                        <tr>
                            <td><b>Ingreso</b></td>
                            <td><?=cute_date($last_history['ra'])?></td>
                        </tr>
                        <tr>
                            <td><b>Tiempo de espera</b></td>
                            <td><?=str_replace('Está en el estacionamiento h','H',$last_history['rb'])?></td>
                        </tr>
                        <tr>
                            <td><b>Lugar</b></td>
                            <td>
                                <select class="form-select" name="place" required>
                                    <option selected="true" disabled="disabled">¿Donde estacionaste tu vehículo?</option>
                                    <?php foreach($places_available as $value => $data){
                                        if($data == 'disabled'){
                                            echo '<option disabled>-</option>';
                                        } else {
                                            echo '<option value="'.$value.'" '.($data['status'] == false ? 'disabled' : '').' '.($value == $code ? 'selected' : '').' >'.$data['name'].'</option>';
                                        }
                                        ?>
                                    <?php } ?>
                                </select>
                                <span class="form-text text-danger"><?=validation_show_error('place')?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-grid gap-2 mt-3">

                <?php if($is_save == false): ?>
                    <button class="btn btn-primary btn-lg">Guardar lugar de estacionamiento</button>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg">Editar lugar de estacionamiento</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <?php endif; ?>
<?php require_once "footer.php"; ?>