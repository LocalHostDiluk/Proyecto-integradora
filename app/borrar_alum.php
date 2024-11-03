<html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>

<?php
include("../conexion.php");

$id = $_POST["id"];
$int = (int)$id;
if (!empty($int)) {
    $sql = "UPDATE alumno SET estatus_alumno= 'Inactivo' WHERE idAlumno = $int";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: grupo.php?msg=Alumno desactivado correctamente");
    } else {
        header("Location: grupo.php?msg=Error al desactivar el alumno");
    }
    ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>
    <?php
}

