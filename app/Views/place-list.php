<?php require_once "header.php"; ?>
<div class="container">
    <h1 class="text-center pt-5 pb-5">Estacionamiento</h1>
    <p class="text-center">Lugares disponibles para poder estacionar los autos</p>

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th class="text-center">Nombres</th>
                <th class="text-center">Dirección</th>
                <th class="text-center">Espacio</th>
                <th class="text-center">Fecha de creación</th>
                <th class="text-center">Última actualización</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list as $item): ?>
            <tr>
                <td class="text-center align-middle"><?=$item->place_name?></td>
                <td class="text-center align-middle"><?=$item->place_address?></td>
                <td class="text-center align-middle"><?=$item->spaces?></td>
                <td class="text-center align-middle"><?=cute_date($item->created_at)?></td>
                <td class="text-center align-middle"><?=cute_date($item->updated_at)?></td>
                <td class="text-center align-middle">
                    <a href="<?=base_url("parking/view/{$item->id}")?>" class="btn btn-primary">Ver</a>
                    <a href="<?=base_url("parking/edit/{$item->id}")?>" class="btn btn-secondary">Actualizar</a>
                    <a href="<?=base_url("parking/delete/{$item->id}")?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>
<?php require_once "footer.php"; ?>