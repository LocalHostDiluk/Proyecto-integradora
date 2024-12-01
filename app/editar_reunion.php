<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="estilos/barstyle.css">
</head>
</html>

<?php
include "../conexion.php";
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
} else if ($_SESSION["rol"] != "Tutor") {
    header("Location: ../admin/inicio.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idReunion = $_POST["idReunion"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    $sql = "UPDATE reuniones SET titulo = ?, descripcion = ?, fecha = ?, hora = ? WHERE idReunion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $titulo, $descripcion, $fecha, $hora, $idReunion);

    if ($stmt->execute()) {
        echo "
            <script>
                swal.fire({
                    title: 'Hecho!',
                    text: 'Reunión actualizada correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
    } else {
        echo "
            <script>
                swal.fire({
                    title: 'Error!',
                    text: 'No se pudo actualizar la reunión',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
    }
}
