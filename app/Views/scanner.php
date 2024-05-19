<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>QR Code Scanner / Reader</title>
    <style>
        *{
            font-family: Arial;
        }
        body {
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            box-sizing: border-box;
            text-align: center;
        }
        .container {
            width: 100%;
            max-width: 500px;
            margin: 5px;
        }
        h1{
            margin-top: 0;
        }
        .section {
            padding: 1.5rem;
        }
        #my-qr-reader{
            border: 0 !important;
        }
        #my-qr-reader img[alt="Info icon"] {
            display: none;
        }

        #my-qr-reader img[alt="Camera based scan"] {
            width: 100px !important;
            height: 100px !important;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #b2b2b2;
            outline: none;
            border-radius: 0.25em;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;
            background-color: #008000ad;
            transition: 0.3s background-color;
        }

        button:hover {
            background-color: #008000;
        }

        #html5-qrcode-anchor-scan-type-change {
            text-decoration: none !important;
            color: #1d9bf0;
        }

        video {
            width: 100% !important;
            border: 1px solid #b2b2b2 !important;
            border-radius: 0.25em;
        }
    </style>
</head>

<body>
<div class="container">
    <div>
        <img width="300px" src="https://s3.amazonaws.com/media.greatplacetowork.com/peru/best-workplaces-for-women-in-peru/2024/utp/Logo-UTP.jpg" alt="">
    </div>
    <div class="section">
        <h1>Escanear QR</h1>
        <div id="my-qr-reader"></div>
        <div><a href="<?=base_url()?>">Regresar al dashboard</a></div>
    </div>
</div>
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="script.js"></script>
<script>
    <?php /*async function getData() {
        const response = await fetch("http://localhost:8080/get-data/<?=$place?>");
        const data = await response.json();
        return data;
    }*/ ?>

    (() => {
        let htmlscanner = new Html5QrcodeScanner("my-qr-reader", {fps: 10, qrbox: 250});
        htmlscanner.render((text) => {
            console.log(text);
            if(text.indexOf('/') != -1){
                url = '<?=base_url("update-do")?>/' + text
                window.location.href = url;
                html5QrcodeScanner.clear();
            }
        });
    })();
</script>
</body>

</html>