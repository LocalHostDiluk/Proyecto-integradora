<?php
session_start();
include "../conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['titulo']) && !empty($data['descripcion']) && !empty($data['fecha']) && !empty($data['hora'])) {
    $titulo = $data['titulo'];
    $descripcion = $data['descripcion'];
    $fecha = $data['fecha'];
    $hora = $data['hora'];
    $idTutor = $_SESSION["id"];  // Suponiendo que el ID del tutor está en la sesión

    $sql = "INSERT INTO reportes (titulo, descripcion, fecha, hora, idTutor) VALUES ('$titulo', '$descripcion', '$fecha', '$hora', '$idTutor')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>