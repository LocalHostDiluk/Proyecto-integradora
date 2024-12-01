<?php
include "../conexion.php"; // Incluye la conexión a la base de datos

session_start();

if (!isset($_SESSION["id"])) {
    http_response_code(401);
    echo json_encode(["error" => "No autorizado"]);
    exit();
}

$idUsuario = $_SESSION["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["imagen_perfil"])) {
    $imagen = $_FILES["imagen_perfil"];
    $nombreImagen = uniqid() . "_" . $imagen["name"];
    $rutaDestino = "../path_to_images/" . $nombreImagen;

    // Mover la imagen al directorio de destino
    if (move_uploaded_file($imagen["tmp_name"], $rutaDestino)) {
        // Actualizar la base de datos con la nueva imagen
        $query = "UPDATE usuario SET imagenPerfil = ? WHERE idUsuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $nombreImagen, $idUsuario);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "imagenPerfil" => $nombreImagen]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar la imagen en la base de datos."]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error al mover la imagen al servidor."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Solicitud inválida."]);
}
?>
