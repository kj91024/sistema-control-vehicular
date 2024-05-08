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
<form action="<?=current_url()?>" method="POST">

    <div class="row">
        <div class="col-12 mb-3">
            <div class="text-center"><b class="fs-3">AÑADIR ESTACIONAMIENTO</b></div>
        </div>

        <?php if(!is_null(session()->get('error'))): ?>
            <div class="col-12">
                <p class="alert alert-danger text-center"><?=session()->get('error')?></p>
            </div>
        <?php endif ?>

        <div class="col-6 mb-3">
            <label for="place_name" class="form-label">Nombre</label>
            <input type="text" class="form-control text-center" id="place_name" name="place_name" value="<?= input_value($place, 'place_name') ?>"  maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('place_name')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="spaces" class="form-label">Total de lugares</label>
            <input type="number" class="form-control text-center" id="spaces" name="spaces" value="<?= input_value($place, 'spaces') ?>" minlength="8" required>
            <span class="form-text text-danger"><?=validation_show_error('spaces')?></span>
        </div>
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center bg-light"></th>
                        <th class="text-center bg-light" width="80px">Niveles</th>
                        <th class="text-center bg-light" width="250px">Lugares</th>
                        <th class="text-center bg-light" width="80px">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach(['Pisos superiores', 'Sótanos'] as $index => $name): ?>
                    <tr class="align-middle">
                        <td>
                            <?=$name?>
                        </td>
                        <td>
                            <input type="number" class="form-control text-center" name="floor[<?=$index?>][levels]" value="<?=!empty($place->floor) ? $place->floor[$index]->levels : ''?>" min="0" max="10">
                        </td>
                        <td>
                            <div class="row">
                                <?php foreach(['A', 'B', 'C', 'D', 'E', 'F'] as $char){ ?>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="floor[<?=$index?>][place_letter][]" value="<?=$char?>" <?=in_array($char, (!empty($place->floor) ? $place->floor[$index]->place_letter : [])) ? 'checked' : ''?> id="<?=$index.$char?>">
                                        <label class="form-check-label" for="<?=$index.$char?>"><?=$char?></label>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </td>
                        <td>
                            <input type="number" class="form-control text-center"  name="floor[<?=$index?>][places_quantity]" value="<?=!empty($place->floor) ? $place->floor[$index]->places_quantity : ''?>" min="0" max="20">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div>
                <span>Leyenda de tabla</span>
                <ol>
                    <li>Niveles: Es la cantidad de pisos que tiene el estacionamiento, ya sean superiores o de sotanos.</li>
                    <li>Lugares: Las letras por las que se dividen cada sección del piso.</li>
                    <li>Cantidad: Cantidad de espacios que hay para cada sección del piso.</li>
                </ol>
            </div>
        </div>
        <div class="col-12 mb-3">
            <label for="place_address" class="form-label">Dirección</label>
            <textarea class="form-control text-center" id="place_address" name="place_address" required><?= input_value($place, 'place_address') ?></textarea>
            <span class="form-text text-danger"><?=validation_show_error('place_address')?></span>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary">Enviar</button>
        </div>
    </div>
</form>
<?php require_once "footer.php" ?>