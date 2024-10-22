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
        $sql = $conn -> query("INSERT INTO tutor (nombre,apellido,telefono,correo,direccion,pass) VALUES ('$nombre','$apellido','$telefono','$usuario','$direccion','$pass')");
        $sql2 = $conn -> query("INSERT INTO usuario (nombreUsuario,contraseña,rol) VALUES ('$usuario','$pass','Tutor')");
        if ($sql and $sql2) {
            echo '<script>alert("Usuario registrado correctamente")</script>';
        } else {
            echo '<script>alert("Error al registrar usuario")</script>';
        }
    }
}
?>