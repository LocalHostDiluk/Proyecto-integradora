<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
        
    <div class="container">
        <div class="container-form">
            <form class="sign-in" action="" method="post">
                <h2>Iniciar Sesión</h2>
                <div class="social-networks">
                    <?php
                    include("../conexion.php");
                    include("../controlador_login.php");
                    ?>
                </div>
                <span>Use su correo y contraseña</span>
                <div class="container-input">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" id="correolog" name="correolog" placeholder="Email">
                </div>
                <div class="container-input">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" id="passlog" name="passlog" placeholder="Password">
                </div>
                <input type="submit" class="button" name="btningresar" placeholder="INICIAR SESION">
            </form>
        </div>

        <div class="container-form">
            <form class="sign-up">
                <h2>Registrarse</h2>
                <div class="social-networks">
                    <ion-icon name="logo-twitch"></ion-icon>
                    <ion-icon name="logo-twitter"></ion-icon>
                    <ion-icon name="logo-instagram"></ion-icon>
                    <ion-icon name="logo-tiktok"></ion-icon>
                </div>
                <span>Use su correo electrónico para registrarse</span>
                <div class="container-input">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" id="nombrereg" name="nombrereg" placeholder="Nombre">
                </div>
                <div class="container-input">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" id="correoreg" placeholder="Email">
                </div>
                <div class="container-input">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" id="passreg" placeholder="Password">
                </div>
                <input type="submit" class="button" placeholder="REGISTRARSE" >
            </form>
        </div>

        <div class="container-welcome">
            <div class="welcome-sign-up welcome">
                <h3>¡Bienvenido!</h3>
                <p>Ingrese sus datos personales para usar todas las funciones del sitio</p>
                <button class="button" id="btn-sign-up">Registrarse</button>
            </div>
            <div class="welcome-sign-in welcome">
                <h3>¡Hola!</h3>
                <p>Regístrese con sus datos personales para usar todas las funciones del sitio</p>
                <button class="button" id="btn-sign-in">Iniciar Sesión</button>
            </div>
        </div>

    </div>


    <script src="script.js"></script>
    <script src="login.js" type="text/javascript"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
