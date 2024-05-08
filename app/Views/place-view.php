<?php require_once "header.php"; ?>
<div class="container">
    <h1 class="text-center pt-5 pb-5">Estacionamiento</h1>
    <p class="text-center">Lugares disponibles para poder estacionar los autos</p>

    <div class="row mt-5 gap-5">
        <div class="col row mb-3">
            <div class="col-1">
                <svg viewBox="0 0 1024 1024" class="icon" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#000000" d="M512 512a192 192 0 100-384 192 192 0 000 384zm0 64a256 256 0 110-512 256 256 0 010 512z"></path><path fill="#000000" d="M512 512a32 32 0 0132 32v256a32 32 0 11-64 0V544a32 32 0 0132-32z"></path><path fill="#000000" d="M384 649.088v64.96C269.76 732.352 192 771.904 192 800c0 37.696 139.904 96 320 96s320-58.304 320-96c0-28.16-77.76-67.648-192-85.952v-64.96C789.12 671.04 896 730.368 896 800c0 88.32-171.904 160-384 160s-384-71.68-384-160c0-69.696 106.88-128.96 256-150.912z"></path></g></svg>
            </div>
            <div class="col-9">
                <h3><?=$place_available->place_name?></h3>
                <p><?=$place_available->place_address?></p>
            </div>
            <div class="col-2 pt-2 pb-2 text-center" style="background: #f1f1f1; border-radius: 5px">
                <div>Espacios</div>
                <div class="text-center"><b style="color:<?=color_free($place_available->free, $place_available->spaces)?>;font-size: 1.75rem;"><?=$place_available->free?></b>/<b style="color:#444; font-size: 16px"><?=$place_available->spaces?></b></div>
            </div>
            <div class="col-12">
                <?php foreach ($place_available->floor as $floor => $letters): ?>
                    <h6 class="mt-4"><?=place_floor($floor)?></h6>
                    <?php foreach ($letters as $letter => $places): ?>
                        <div style="padding: 0.1rem">
                            <div class="row gap-2">
                            <?php foreach ($places as $number => $place):?>
                                <a class="col text-center btn <?=(!$place['status']) ? 'btn-secondary' : ''?>" <?=(!$place['status']) ? 'href="'.base_url("user/history/{$place['id_user']}").'"' : ''?> <?=(!$place['status']) ? 'title="'.$letter.$number.' ya esta ocupada por '.$place['plate'].'"' : ''?> style="border:1px solid #ccc; border-radius: 5px"><?=($place['status']) ? $letter.$number : $place['plate']?></a>
                            <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
<?php require_once "footer.php"; ?>