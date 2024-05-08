<?php require_once "header.php"; ?>
<div class="container">
    <h1 class="text-center pt-5 pb-5">PLACAS NO REGISTRADAS</h1>
    <p class="text-center">Son las placas que la IA ha detectado pero que no están dentro de nuestra plataforma y por lo tanto no pueden ingresar al estacionamiento.</p>

    <table class="table" id="datatable">
        <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Placa vehicular</th>
            <th class="text-center">Estacionamiento</th>
            <th class="text-center">Primera vez detectado</th>
            <th class="text-center">Última vez detectado</th>
            <th class="text-center">Cantidad de veces</th>
            <th class="text-center">RQ</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($no_registered_plates as $item): ?>
            <tr>
                <td class="text-center align-middle"><b><?=$item->id?></b></td>
                <td class="text-center align-middle"><b><?=$item->plate?></b></td>
                <td class="text-center align-middle"><b><?=$item->place_name?></b></td>
                <td class="text-center align-middle"><?=cute_date($item->created_at)?></td>
                <td class="text-center align-middle"><?=cute_date($item->updated_at)?></td>
                <td class="text-center align-middle"><?=$item->count?></td>
                <td class="text-center align-middle">
                    <?php if($item->rq): ?>
                        <i class="text-danger">Tiene RQ, ya se le ha notificado a la policía</i>
                    <?php else: ?>
                        <i class="text-secondary">Solo no esta registrado en la plataforma</i>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php require_once "footer.php"; ?>