<?php
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
} else if ($_SESSION["rol"] != "Tutor") {
    header("Location: ../admin/inicio.php");
    exit();
}

include "../conexion.php";

// Verifica si se recibieron los datos del formulario
if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['fecha'], $_POST['hora'], $_POST['lugar'])) {
    // Sanitizar y asignar los datos recibidos
    $idTutor = $_SESSION["id"];
    $titulo = htmlspecialchars($_POST['titulo']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $fecha = htmlspecialchars($_POST['fecha']);
    $hora = htmlspecialchars($_POST['hora']);
    $lugar = htmlspecialchars($_POST['lugar']);

    $sql = "INSERT INTO reuniones (idTutor, titulo, descripcion, fecha, hora, lugar) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $idTutor, $titulo, $descripcion, $fecha, $hora, $lugar);

    if ($stmt->execute()) {
        // Redirecciona a la página de reportes si la inserción fue exitosa
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Por favor, completa todos los campos.";
}
