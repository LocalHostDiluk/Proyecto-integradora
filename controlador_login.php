<?php

session_start();
if (!empty($_POST["btningresar"])){
    if (empty($_POST["correolog"]) || empty($_POST["passlog"])) {
        echo '<h4 style="color: red;">Rellena los campos</h4>';
    } else {
        $usuario = $_POST["correolog"];
        $pass = $_POST["passlog"];
        $sql = $conn -> query("SELECT * FROM usuario WHERE correoUsuario = '$usuario' AND contraseña = '$pass'");

        if ($datos = $sql -> fetch_object()){
            $_SESSION["id"] = $datos -> idUsuario;
            $_SESSION["correoUsuario"] = $datos -> correoUsuario;
            $_SESSION["rol"] = $datos -> rol;

            header("Location: ../app/index.php");
        }else {
            echo '<h4 style="color: red;">No tienes acceso, verifica tu información</h4>';
        }
    }
    
}

?>