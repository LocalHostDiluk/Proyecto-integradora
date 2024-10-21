<?php

session_start();
if (!empty($_POST["btningresar"])){
    if (empty($_POST["correolog"]) || empty($_POST["passlog"])) {
        echo 'RELLENA LOS CAMPOS';
    } else {
        $usuario = $_POST["correolog"];
        $pass = $_POST["passlog"];
        $sql = $conn -> query("SELECT * FROM usuario WHERE nombreUsuario = '$usuario' AND contraseña = '$pass'");

        if ($datos = $sql -> fetch_object()){
            $_SESSION["id"] = $datos -> idUsuario;
            $_SESSION["nombre"] = $datos -> nombreUsuario;

            header("Location: ../app/index.php");
        }else {
            echo 'ACCESO DENEGADO';
        }
    }
    
}

?>