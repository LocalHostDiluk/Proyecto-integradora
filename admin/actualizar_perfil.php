<?php
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
} else if ($_SESSION["rol"] != "Administrador") {
    header("Location: ../app/index.php");
    exit();
}
include "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario = $_SESSION['id'];
    $correo = $_POST['correo'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $imagenPerfil = $_FILES['imagen_perfil']['name'];
    $imagenTmp = $_FILES['imagen_perfil']['tmp_name'];
    $rutaImagen = '../uploads/' . basename($imagenPerfil);

    // Actualizar los datos del usuario en la base de datos
    if (move_uploaded_file($imagenTmp, $rutaImagen)) {
        $query = "UPDATE usuario SET correoUsuario = ?, imagenPerfil = ? WHERE idUsuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $correo, $imagenPerfil, $idUsuario);

        // Si se actualizó el correo y la imagen, se actualiza también la contraseña si es proporcionada
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE usuario SET correoUsuario = ?, imagenPerfil = ?, password = ? WHERE idUsuario = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssi', $correo, $imagenPerfil, $hashedPassword, $idUsuario);
        }

        // Ejecutar la actualización
        if ($stmt->execute()) {
            // Redirigir al panel de inicio
            header("Location: inicio.php");
            exit();
        } else {
            echo "Error al actualizar los datos.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
}
?>
