<?php

if(!empty($_POST["btnregistrar"])) {
    if (empty($_POST["nombrereg"]) || empty($_POST["apellido"]) || empty($_POST["telefono"]) || empty($_POST["direccion"]) || empty($_POST["user"]) || empty($_POST["passreg"])) {
        echo '<h4 style="color: red;">Todos los campos son obligatorios</h4>';
    } else {
        $nombre = $_POST["nombrereg"];
        $apellido = $_POST["apellido"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $usuario = $_POST["user"];
        $pass = $_POST["passreg"];
        $sql = $conn -> query("INSERT INTO tutor (nombreTutor,apellidoTutor,telefonoTutor,direccionTutor,fecha_creacionTutor,estatus_tutor) VALUES ('$nombre','$apellido','$telefono','$direccion',NOW(),'Activo')");
        $sql2 = $conn -> query("INSERT INTO usuario (correoUsuario,contraseña,rol,estatus_usuario,fecha_creacion) VALUES ('$usuario','$pass','Tutor','Activo',NOW())");
        if ($sql and $sql2) {
            ?>

            <script>
                Swal.fire({
                    title: '¡Registro exitoso!',
                    text: 'Ahora puedes iniciar sesión',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            </script>

            <?php
        } else {
            ?>

            <script>
                Swal.fire({
                    title: '¡Error!',
                    text: 'No se pudo registrar, intente de nuevo',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            </script>

            <?php
        }
    }
}
?>