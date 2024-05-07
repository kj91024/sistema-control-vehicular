<?php require_once "header.php" ?>
<div class="container">
    <h1 class="text-center pt-5 pb-5">HISTORIAL DEL USUARIO</h1>
    <p class="text-center mb-5">Bienvenido, en esta sección vas a poder her un histórico de las actividades de ingreso, espera y salida de tu vehículo dentro de las instalación de la universidad. Ten en cuenta que este sistema es automátizado procura seguir las reglas de la universidad.</p>

    <?php $session = session()->get('user'); ?>
    <table class="table mb-5">
        <thead>
            <th class="text-center bg-light" colspan="4"><?=ucfirst($session['type'])?></th>
        </thead>
        <tbody>
            <tr>
                <td><b>Nombre y Apellido</b></td>
                <td><?=$session['first_names']?> <?=$session['last_names']?></td>
                <td><b>DNI</b></td>
                <td><?=$session['dni']?></td>
            </tr>
            <tr>
                <td><b>Celular</b></td>
                <td><?=$session['cellphone']?></td>
                <td><b>Licencia vehicular</b></td>
                <td><?=$session['license_number']?></td>
            </tr>
            <tr>
                <td><b>Número de placa</b></td>
                <td><?=$car->plate?></td>
                <td><b>Color del vehículo</b></td>
                <td><?=$car->color ?? '~'?></td>
            </tr>
        </tbody>
    </table>
    <?php if(count($historial) == 0): ?>
    <p class="alert alert-light text-center">Aún no hay un histórico relacionado con el número de placa registrado.</p>
    <?php else: ?>
    <table class="table">
        <thead>
            <th class="bg-light"></th>
            <th class="text-center bg-light">Ingreso</th>
            <th class="text-center bg-light">En el estacionamiento</th>
            <th class="text-center bg-light">Salida</th>
        </thead>
        <tbody>
            <?php foreach($historial as $index => $historia): ?>
            <tr>
                <td class="align-middle">
                    <svg height="30px" width="30px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M950.737933 503.088102l-60.504455-100.830179h14.076375c18.484202 0 33.606988-15.122786 33.606988-33.606988s-15.122786-33.606988-33.606988-33.606988h-44.808293c-0.394196 0-0.760747 0.104436-1.151871 0.117747l-37.640072-130.736846c-8.226919-28.617595-34.787528-48.616123-64.587711-48.616123H268.346009c-29.799158 0-56.360792 19.997504-64.58771 48.604861l-37.654407 130.74606c-0.386005-0.013311-0.74846-0.116723-1.137536-0.116723h-44.808294c-18.484202 0-33.606988 15.122786-33.606988 33.606988s15.122786 33.606988 33.606988 33.606988h14.071256l-60.499336 100.842466a67.12285 67.12285 0 0 0-9.583566 34.579679v154.861631c0 37.063625 30.149327 67.212952 67.212952 67.212953h22.404658v65.571664c0 22.678036 18.382837 41.060873 41.060874 41.060873h29.900523c22.678036 0 41.060873-18.382837 41.060873-41.060873v-65.571664H758.68162v61.18841c0 22.156878 17.96202 40.117875 40.116851 40.117875h31.787543c22.155855 0 40.116851-17.960996 40.116851-40.117875v-61.18841h22.404659c37.063625 0 67.212952-30.149327 67.212952-67.212953V537.679044a67.177116 67.177116 0 0 0-9.582543-34.590942z m-35.22575 189.452573c0 12.351129-10.042267 22.404659-22.404659 22.404659H131.360392c-12.361368 0-22.404659-10.05353-22.404659-22.404659V537.679044a22.515238 22.515238 0 0 1 3.194522-11.529973l83.163038-138.626905c2.953909-4.922841 5.273009-10.250116 6.935799-15.928584l44.567681-154.784841c2.734798-9.53954 11.596525-16.190699 21.529236-16.190698H756.121906c9.932712 0 18.794439 6.651159 21.529237 16.201961l44.56768 154.773578 0.021502 0.098293A68.716016 68.716016 0 0 0 829.176124 387.576431l83.141536 138.561378a22.585886 22.585886 0 0 1 3.194523 11.541235v154.861631z" fill="#22C67F"></path><path d="M789.923433 379.919817l-27.615212-112.879262c-4.906458-20.053818-22.878718-34.158862-43.524341-34.158862H304.507591c-20.756203 0-38.796039 14.254531-43.593965 34.448622l-26.825796 112.878238c-6.690067 28.151727 14.658966 55.168989 43.596013 55.168989h468.715248c29.057866 0 50.429424-27.231254 43.524342-55.457725zM223.302222 523.872974l-67.212952-7.013614c-13.220407-1.380197-24.728878 8.989713-24.728878 22.282816v19.945286c0 12.37263 10.029981 22.404659 22.404658 22.404659h67.212952c12.373654 0 22.404659-10.032028 22.404659-22.404659v-12.931671c0-11.472635-8.669237-21.093062-20.080439-22.282817zM868.379669 514.402035l-67.212952 7.013614c-11.411202 1.190779-20.079415 10.810181-20.079415 22.282817v12.931671c0 12.373654 10.029981 22.404659 22.404659 22.404659h67.212952c12.373654 0 22.404659-10.029981 22.404659-22.404659v-19.945286c-0.001024-13.293103-11.509495-23.66199-24.729903-22.282816zM707.583599 514.279169H316.885341c-14.576031 0-25.270514 13.697538-21.736062 27.837394l11.20233 44.808293a22.405683 22.405683 0 0 0 21.736061 16.971924h368.293599a22.405683 22.405683 0 0 0 21.736062-16.971924l11.202329-44.808293c3.534452-14.139856-7.161054-27.837394-21.736061-27.837394zM669.065033 626.301438H355.403907c-12.373654 0-22.404659 10.029981-22.404659 22.404659 0 12.37263 10.029981 22.404659 22.404659 22.404659h313.661126c12.373654 0 22.404659-10.032028 22.404658-22.404659-0.001024-12.374678-10.031005-22.404659-22.404658-22.404659z" fill="#74E8AE"></path></g></svg>
                    <b># Historia de ruta <?=($index+1)?></b>
                </td>
                <td class="text-center align-middle"><?=$historia['ra']?></td>
                <td class="text-center align-middle"><?=$historia['rb']?></td>
                <td class="text-center align-middle"><?=$historia['rc']?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<?php require_once "footer.php" ?>


