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

if (isset($_GET["idReunion"])) {
    $idReunion = $_GET["idReunion"];

    $sql = "DELETE FROM reuniones WHERE idReunion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idReunion);

    if ($stmt->execute()) {
        echo "
        <script>
            Swal.fire({
                title: 'Hecho!',
                text: 'Reunión eliminada correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>";
    } else {
        echo "
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'No se pudo eliminar la reunión',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
    }
}
