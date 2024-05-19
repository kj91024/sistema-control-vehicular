<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pantalla Secundaria de <?=$place->place_name?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Sans:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <style>
    *{
        font-family: "Ubuntu Sans", arial;
    }
    body{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .blu{
        width: 400px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0px 0px 32px -15px #000;
    }
    .logo{
        text-align: center;
    }
    .footer{
        text-align: center;
        font-size: 14px;
    }
    .content{
        width: 100%;
    }
    #qrcode img{
        margin: 0 auto;
    }
    #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #b61924;
        background-image: url("");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 50% 50%;
    }
    </style>
</head>
<body>
<div id="particles-js"></div>
<div class="blu">
    <div class="logo"><img src="https://s3.amazonaws.com/media.greatplacetowork.com/peru/best-workplaces-for-women-in-peru/2024/utp/Logo-UTP.jpg" height="60px"></div>
    <div class="content">

        <section id="step_1" style="text-align: center">
            <h1><?=$place->place_name?></h1>
            <div>Lugares disponibles</div>
            <h1 id="free" style="color: #d00b40;width: 60px;font-size: 50px;text-align: center;margin: 0 auto; margin-bottom:1.5rem;padding: 10px;background: #efefef;border-radius: 16px;margin-top: 1rem;"><?=$place->free?></h1>
            <p>Porfavor acerca tu vehículo a las cámaras para identificar tu placa y puedas ingresar.</p>
        </section>

        <section id="step_2" style="display:none;text-align:center">

            <div id="error" class="mt-3" style="display: none">
                <div style="padding: 1rem;background: #ffe7e7;border: 1px solid #ffd1d1;color: #8d2525;border-radius: 5px;">
                    <b>NO PUEDES INGRESAR</b>
                </div>
                <p>Tu vehículo no está registrado en el sistema. <br><br> <i>Para poder estacionar tu vehículo es necesario que te registres en nuestra plataforma.</i></p>
            </div>

            <div id="danger" class="mt-3" style="display: none">
                <p>Tu vehículo está como requisitoriado. <br><br> <i>Hemos dado aviso a las autoridades para que vengan a este punto para que recojan tu vehiculo, te recomiendo que corras TORETO</i></p>
                <div style="padding: 1rem;background: #cce9c7;border: 1px solid #bac7b7;color: #536e46;border-radius: 5px;">
                    <b>PUEDES INGRESAR</b>
                </div>
            </div>

            <div id="normal" style="display: none">
                <h3>Porfavor escanea este QR</h3>
                <div id="qrcode"></div>
                <p><i><span id="seconds">180</span> segundos</i></p>
            </div>
        </section>

        <section id="step_3" style="display:none;text-align:center">
            <h1 id="placa_registrada">ASD-123</h1>
            <p>Tu vehículo ha sido registrado satisfactoriamente en el sistema, puedes ingresar. <br><br><i>Te recomendamos que una vez hallas estacionado el carro, registres el codigo QR del lugar en donde has puesto tu vehículo, ya que este es necesario para que puedas salir del recinto</i></p>
        </section>

    </div>
    <div class="footer"><?=$place->place_address?></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/1.0.0/particles.min.js" integrity="sha512-zSXd15DNZUoXEVLbyfTa1XQFk33vi7CcJzPHdBh/7Y3NEEec+l/eBhg2RGgRutwQVfrt9EnBmrYzn6d3NxGG1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    async function getData() {
        const response = await fetch("http://localhost:8080/get-data/<?=$place->id?>");
        const data = await response.json();
        return data
    }

    (()=>{
        plate = '';
        setInterval( async () => {
            let data = await getData();
            console.log(data)
            free.setText = data.free;
            switch (data.step){
                case 1:
                    step_1.style.display = 'block'
                    step_2.style.display = 'none'
                    step_3.style.display = 'none'
                    break;
                case 2:
                    step_2.style.display = 'block'
                    step_1.style.display = 'none'
                    step_3.style.display = 'none'

                    switch(data.record_to_enter.status){
                        case 'error':
                            error.style.display = 'block'
                            danger.style.display = 'none'
                            normal.style.display = 'none'
                            break;
                        case 'danger':
                            danger.style.display = 'block'
                            error.style.display = 'none'
                            normal.style.display = 'none'
                            break;
                        default:
                            normal.style.display = 'block'
                            error.style.display = 'none'
                            danger.style.display = 'none'

                            created_at = data.record_to_enter.created_at.date
                            created_at = new Date(created_at).getTime()/1000;
                            now = Date.now()/1000
                            seconds.innerText = parseInt(180-(now-created_at))

                            if(plate != data.record_to_enter.plate){
                                id_place = data.record_to_enter.id_place;
                                plate = data.record_to_enter.plate;
                                let qrcode = new QRCode('qrcode');
                                qrcode.clear();
                                qrcode.makeCode(id_place + '/' + plate);
                            }

                            break;
                    }
                    break;
                case 3:
                    step_3.style.display = 'block'
                    step_1.style.display = 'none'
                    step_2.style.display = 'none'

                    placa_registrada.innerText = data.record_in.plate
                    break;
            }
        }, 1000)

        particlesJS("particles-js");
    })()
</script>
</body>
</html>