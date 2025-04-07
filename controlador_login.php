<?php
session_start();

if (!empty($_POST["btningresar"])) {
    if (empty($_POST["correolog"]) || empty($_POST["passlog"])) {
        echo '<h4 style="color: red;">Rellena todos los campos</h4>';
    } else {
        $usuario = $_POST["correolog"];
        $pass = $_POST["passlog"];

        // Consulta preparada para prevenir inyecciones SQL
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE correoUsuario = ? AND estatus_usuario = 'Activo'");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($datos = $result->fetch_object()) {
            // Comparamos el password ingresado con el hash almacenado
            if (password_verify($pass, $datos->contraseña)) {
                // Iniciar sesión y redirigir
                $_SESSION["id"] = $datos->idUsuario;
                $_SESSION["correoUsuario"] = $datos->correoUsuario;
                $_SESSION["rol"] = $datos->rol;

                if ($datos->rol == "Administrador") {
                    header("Location: ../admin/inicio.php");
                } else {
                    header("Location: ../app/inicio.php");
                }
                exit();
            } else {
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Contraseña incorrecta.'
                        }).then(() => window.history.back());
                    </script>
                ";
            }
        } else {
            echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Usuario no encontrado.'
                    }).then(() => window.history.back());
                </script>
            ";
        }
    }
}