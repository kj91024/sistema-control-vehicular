<?php require_once "header.php"; ?>
<div class="container">
    <h1 class="text-center pt-5 pb-5">USUARIOS Y PLACAS</h1>
    <p class="text-center">Son las placas que están dentro de nuestra plataforma, y por lo tanto pueden acceder a nuestra infraestructura del estacionamiento.</p>

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th class="text-center">Placa vehicular</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">DNI</th>
                <th class="text-center">Licencia vehicular</th>
                <th class="text-center">Color</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Fecha de creación</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($registered_plates as $item): ?>
            <tr>
                <td class="text-center align-middle <?=$item->type == 'seguridad' ? 'bg-light' : ''?>"><b><?=$item->type != 'seguridad' ? $item->plate : '~'?></b></td>
                <td class="text-center align-middle <?=$item->type == 'seguridad' ? 'bg-light' : ''?>"><?=$item->first_names?> <?=$item->last_names?></td>
                <td class="text-center align-middle <?=$item->type == 'seguridad' ? 'bg-light' : ''?>"><?=$item->dni?></td>
                <td class="text-center align-middle <?=$item->type == 'seguridad' ? 'bg-light' : ''?>"><?=$item->type != 'seguridad' ? $item->license_number : '~'?></td>
                <td class="text-center align-middle <?=$item->type == 'seguridad' ? 'bg-light' : ''?>"><?=$item->type != 'seguridad' ? "<input type=\"color\" value=\"{$item->color}\" style=\"width: 60px;height: 30px;\" disabled>" : '~'?></td>
                <td class="text-center align-middle <?=$item->type == 'seguridad' ? 'bg-light' : ''?>"><b><?=strtoupper($item->type)?></b></td>
                <td class="text-center align-middle <?=$item->type == 'seguridad' ? 'bg-light' : ''?>"><?=$item->created_at?></td>
                <td class="text-center align-middle <?=$item->type == 'seguridad' ? 'bg-light' : ''?>">
                    <?php
                    $session = session()->get("user");
                    if($session['type'] == 'seguridad' && $item->type != 'seguridad'):
                    ?>
                    <a href="<?=base_url("user/history/{$item->id}")?>" class="btn btn-dark">Historial</a>
                    <?php elseif($session['type'] == 'administrador'): ?>
                    <a href="<?=base_url("user/history/{$item->id}")?>" class="btn btn-dark">Historial</a>
                    <a href="<?=base_url("user/create/{$item->id}")?>" class="btn btn-secondary">Actualizar</a>
                    <a href="<?=base_url("user/delete/{$item->id}")?>" class="btn btn-danger">Eliminar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>
<?php require_once "footer.php"; ?>