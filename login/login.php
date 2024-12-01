<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Login Page</title>
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
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" id="correolog" name="correolog" placeholder="Usuario/correo">
                </div>
                <div class="container-input">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="passlog" name="passlog" placeholder="Contraseña">
                </div>
                <input type="submit" class="button" name="btningresar">
            </form>
        </div>

        <div class="container-form">
            <form class="sign-up" method="post" action="">
                <h2>Escuela Secundaria #4</h2>
                <div class="social-networks">
                    <img src="../images/logo2.png" width="50" height="50" alt="Logo escuela">
                </div>
                <div>
                    <p>
                        La Escuela Secundaria #4 es una institución educativa que se encuentra en la ciudad de Durango, Durango. 
                        Ofrece educación secundaria a jóvenes de entre 12 y 15 años de edad.
                    </p>
                </div>
            </form>
        </div>

        <div class="container-welcome">
            <div class="welcome-sign-up welcome">
                <h3>¡Bienvenido!</h3>
                <p>¡Conoce más sobre nosotros!</p>
                <button class="button" id="btn-sign-up">Continuar</button>
            </div>
            <div class="welcome-sign-in welcome">
                <h3>¡Hola!</h3>
                <p>Inicia sesión para usar todas las funciones del sitio</p>
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
