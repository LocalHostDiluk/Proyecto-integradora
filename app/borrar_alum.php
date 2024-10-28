<?php
include("../conexion.php");

$id = $_GET["idAlumno"];
$int = (int)$id;

$sql = "DELETE FROM alumno WHERE idAlumno = $int";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: grupo.php?msg=Alumno eliminado correctamente");
} else {
    header("Location: grupo.php?msg=Error al eliminar alumno");
}

?>