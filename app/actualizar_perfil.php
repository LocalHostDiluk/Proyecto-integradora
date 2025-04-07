<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
</html>

<?php
session_start();
require_once "../conexion.php"; // Asegúrate de que este archivo conecte correctamente a la base de datos.

$idUsuario = $_SESSION["id"];
$correo = $_POST["correo"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirm-password"];

// Validar que las contraseñas coinciden
if ($password !== $confirmPassword) {
    echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden.'
            }).then(() => window.history.back());
        </script>
    ";
    exit();
}

// Actualizar la contraseña
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Manejo de la subida de imagen
if (!empty($_FILES['imagen']['name'])) {
    $imagen = $_FILES['imagen'];
    $nombreImagen = time() . "_" . basename($imagen['name']);
    $rutaDestino = "../ruta/de/imagen/perfil/" . $nombreImagen;

    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
        // Actualizar imagen y demás campos en la base de datos
        $query = "UPDATE usuario SET correo = ?, password = ?, imagenPerfil = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $correo, $hashedPassword, $nombreImagen, $idUsuario);
    } else {
        echo "Error al subir la imagen.";
        exit();
    }
} else {
    // Actualizar solo correo y contraseña si no hay imagen
    $query = "UPDATE usuario SET correoUsuario = ?, contraseña = ? WHERE idUsuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $correo, $hashedPassword, $idUsuario);
}

if ($stmt->execute()) {
    echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Perfil actualizado correctamente.'
            }).then(() => window.location.href = 'inicio.php');
        </script>
    ";
} else {
    echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al actualizar el perfil.'
            });
        </script>
    ";
}
?>
