<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="styles/tutor.css">
</head>
</html>

<?php
include("../conexion.php");
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
} else if ($_SESSION["rol"] != "Administrador") {
    header("Location: ../app/index.php");
    exit();
}

$id = $_GET["idTutor"];
$int = (int)$id;
if (!empty($int)) {

    try {
        $sql = "DELETE FROM tutor WHERE idTutor = $int";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script src='https://cdn.jsdelivr.net/npm/promise-polyfill'></script>
            <script>
            Swal.fire({
                title: 'Tutor eliminado',
                text: 'El tutor ha sido eliminado correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(function() {
                window.location = 'gestionar_tutores.php';
            });
            </script>";
        }
    } catch (Exception $e) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='https://cdn.jsdelivr.net/npm/promise-polyfill'></script>
        <script>
        Swal.fire({
            title: 'Error',
            text: 'El tutor tiene grupo asignado, no se puede eliminar',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        }).then(function() {
            window.location = 'gestionar_tutores.php';
        });
        </script>";
    }

}
