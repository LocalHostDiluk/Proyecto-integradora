<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
                <h2>Registrarse</h2>
                <div class="social-networks">
                    <?php
                    include("../conexion.php");
                    include("../controlador_reg.php");
                    ?>
                </div>
                <span>Ingrese sus datos para registrarse</span>
                <div class="container-input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="nombrereg" name="nombrereg" placeholder="Nombre">
                </div>
                <div class="container-input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido">
                </div>
                <div class="container-input">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" id="telefono" name="telefono" placeholder="Telefono">
                </div>
                <div class="container-input">
                    <i class="fa-solid fa-house"></i>
                    <input type="text" id="direccion" name="direccion" placeholder="Dirección">
                </div>
                <div class="container-input">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" id="user" name="user" placeholder="Usuario/Correo">
                </div>
                <div class="container-input">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="passreg" name="passreg" placeholder="Contraseña">
                </div>
                <input type="submit" class="button" name="btnregistrar" id="btnregistrar">
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
