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
            <div class="text-center"><b class="fs-3">AÑADIR PARKING</b></div>
        </div>

        <?php if(!is_null(session()->get('error'))): ?>
            <div class="col-12">
                <p class="alert alert-danger text-center"><?=session()->get('error')?></p>
            </div>
        <?php endif ?>

        <div class="col-6 mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control text-center" id="name" name="name" value="<?= input_value($place, 'name') ?>"  maxlength="30" required>
            <span class="form-text text-danger"><?=validation_show_error('name')?></span>
        </div>
        <div class="col-6 mb-3">
            <label for="spaces" class="form-label">Cantidad de espacio</label>
            <input type="number" class="form-control text-center" id="spaces" name="spaces" value="<?= input_value($place, 'spaces') ?>" minlength="8" required>
            <span class="form-text text-danger"><?=validation_show_error('spaces')?></span>
        </div>
        <div class="col-12 mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea class="form-control text-center" id="address" name="address" required><?= input_value($place, 'address') ?></textarea>
            <span class="form-text text-danger"><?=validation_show_error('address')?></span>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary">Enviar</button>
        </div>
    </div>
</form>
<?php require_once "footer.php" ?>