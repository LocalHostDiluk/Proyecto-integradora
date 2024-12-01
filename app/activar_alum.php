<html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>

<?php
include("../conexion.php");
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
} else if ($_SESSION["rol"] != "Tutor") {
    header("Location: ../admin/inicio.php");
    exit();
}

$id = $_POST["id"];
$int = (int)$id;
if (!empty($int)) {
    $sql = "UPDATE alumno SET estatus_alumno= 'Activo' WHERE idAlumno = $int";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: grupo.php?msg=Alumno activado correctamente");
    } else {
        header("Location: grupo.php?msg=Error al activar el alumno");
    }
    ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>
    <?php
}
