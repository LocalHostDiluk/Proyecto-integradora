<?php
include "../conexion.php"; // Asegúrate de incluir la conexión a la base de datos

if (isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];

    // Consulta para obtener la información del tutor
    $sql = "SELECT u.idUsuario, t.nombreTutor, t.apellidoTutor, t.telefonoTutor, t.direccionTutor
            FROM usuario u
            INNER JOIN tutor t ON u.idTutor = t.idTutor
            WHERE u.idUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    // Retornar la información en formato JSON
    echo json_encode($usuario);
}
?>
