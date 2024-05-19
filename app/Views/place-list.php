<?php require_once "header.php"; ?>
<div class="container">
    <h1 class="text-center pt-5 pb-5">Estacionamiento</h1>
    <p class="text-center">Lugares disponibles para poder estacionar los autos</p>

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th class="text-center">Nombres</th>
                <th class="text-center" width="200px">Dirección</th>
                <th class="text-center">Espacio</th>
                <th class="text-center">Fecha de creación</th>
                <th class="text-center">Última actualización</th>
                <th class="text-center">Token de enlace</th>
                <th width="150px"></th>
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
                <td class="text-center align-middle"><?=encrypt($item->id)?></td>
                <td class="text-center align-middle">
                    <div style="display: flex; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                        <a target="_blank" href="<?=link_secondary_window($item)?>" class="btn btn-light" title="Ver pantalla externa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-window" viewBox="0 0 16 16">
                                <path d="M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                                <path d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm13 2v2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1M2 14a1 1 0 0 1-1-1V6h14v7a1 1 0 0 1-1 1z"/>
                            </svg>
                        </a>
                        <div class="dropdown">
                            <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
                                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
                                </svg>
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?=base_url("parking/view/{$item->id}")?>">Ver</a></li>
                                <li><a class="dropdown-item" href="<?=base_url("parking/edit/{$item->id}")?>">Actualizar</a></li>
                                <li><a class="dropdown-item" href="<?=base_url("parking/delete/{$item->id}")?>">Eliminar</a></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>
<?php require_once "footer.php"; ?>