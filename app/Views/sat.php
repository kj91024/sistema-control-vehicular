<?php require_once "header.php"; ?>
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
<?php require_once "footer.php"; ?>