<?php
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
    <title>Inicio</title>
</head>
<body>

    <section class="Barra">
        <input type="checkbox" id="check">
        <header>
            <h2><a href="index.html" class="logo"><img class="imglogo" src="" alt="logo escuela">Escuela secundaria #4</a></h2>    
            <nav class="nav">
                <a href="../controlador_cerrar.php">Cerrar sesion</a>
                <a href="">Calendario Escolar 2024</a>
            </nav>
    
            <label for="check">
                <i class="fas fa-bars menu-btn"></i>
                <i class="fas fa-times close-btn"></i>
            </label>
        </header>
    </section>
    <hr>

    <aside>
        <div class="widget">
            <a class="opciones" href="">Inicio</a>
        </div>

        <div class="widget">
            <a class="opciones" href="">Reportes</a>
        </div>

        <div class="widget">
            <a class="opciones" href="">Calificaciones</a>
        </div>

        <div class="widget"><a href="" class="opciones">Biblioteca act.</a></div>
    </aside>
    
    <section class="main">
        <h1>Inicio</h1>
        <p>Bienvenido a la plataforma de la escuela secundaria #4</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam sapiente nobis ipsa, ut numquam eos aspernatur eveniet labore accusantium rerum illum facilis? Nobis deserunt animi, magnam soluta molestias commodi porro?Accusantium voluptates, placeat nisi repudiandae, voluptatum similique illum eligendi ipsum repellat maiores nesciunt temporibus earum doloribus laborum facilis quidem ut rerum fuga aliquam inventore. Minus voluptatem ipsum ut animi dolores!Totam inventore soluta nulla quod temporibus pariatur at qui sapiente porro eius quaerat doloremque, quos suscipit animi reiciendis a ipsum numquam veritatis quibusdam, cupiditate amet! Cupiditate impedit aut facilis dolorem?Vel voluptatibus dolorem delectus libero dignissimos aliquam quis, non alias, doloremque deleniti velit impedit sequi nam, sapiente ratione modi commodi necessitatibus? Sed sunt excepturi in! Libero amet unde hic tempora!
        </p>
    </section>

</body>
</html>