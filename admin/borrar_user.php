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
} else if ($_SESSION["rol"] != "Administrador") {
    header("Location: ../app/index.php");
    exit();
}

$id = $_POST["id"];
$int = (int)$id;
if (!empty($int)) {
    $sql = "DELETE FROM usuario WHERE idUsuario = $int";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: gestionar_usuario.php?msg=Tutor eliminado correctamente");
    } else {
        header("Location: gestionar_usuario.php?msg=Error al eliminar el tutor");
    }
    ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>
    <?php
}
