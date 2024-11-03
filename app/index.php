<?php
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="estilos/barstyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>

    <div class="barra-lateral">

        <div>
            <div class="nombre-pagina">
                <ion-icon id="cloud" name="menu-outline"></ion-icon>
                <span></span>
            </div>
            <button data-bs-toggle="modal" data-bs-target="#reporteModal" class="boton">
                <ion-icon name="add-outline"></ion-icon>
                <span>Crear reporte</span>
            </button>
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a class="seccion" id="inbox" href="#">
                        <ion-icon title="Reportes" name="document-text-outline"></ion-icon>
                        <span>Reportes</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" href="calif.php">
                        <ion-icon title="Calificaciones" name="clipboard-outline"></ion-icon>
                        <span>Calificaciones</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" href="grupo.php">
                        <ion-icon title="Grupos" name="grid-outline"></ion-icon>
                        <span>Alumnos</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" href="biblioteca.php">
                        <ion-icon title="Biblioteca Virtual" name="book-outline"></ion-icon>
                        <span>Bilbioteca Virtual</span>
                    </a>
                </li>
                <li>
                    <div class="boton-modal" >
                        <label for="btn-modal">
                            <ion-icon title="Cerrar sesión" name="log-out-outline"></ion-icon>
                            <span>Cerrar Sesion</span>
                        </label>
                    </div>
                    <input type="checkbox" id="btn-modal">
                    <div class="container-modal">
                        <div class="content-modal">
                            <h2>¡ALERTA!</h2>
                            <p>¿Estás seguro de cerrar sesión?</p>
                            <div class="btn">
                                <a class="btn btn-success" href="../controlador_cerrar.php">Cerrar sesión</a>
                                <label class="btn btn-danger" for="btn-modal">Cancelar</label>
                            </div>
                        </div>
                        <label for="btn-modal" class="cerrar-modal"></label>
                    </div>
                </li>
            </ul>
        </nav>

        <div>
            <div class="linea"></div>

            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span>Modo Oscuro</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo"></div>
                    </div>
                </div>
            </div>
    
            <div class="usuario">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">
                            Usuario: 
                            <?php
                            echo $_SESSION["correoUsuario"];
                            ?>
                        </span>
                        <span class="email">
                            Rol: 
                            <?php
                            echo $_SESSION["rol"];
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <main>
        <?php
        include "../conexion.php";
        $idTutor = $_SESSION["id"];
        $sql = "SELECT * FROM reuniones WHERE idTutor = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idTutor);
        $stmt->execute();
        $result = $stmt->get_result();

        $reuniones = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reuniones[] = $row;
            }
        } else {
            $mensaje = "No tienes reuniones registradas.";
        }
        ?>

        <div class="container">
            <h1 style="text-align: center;">Reportes</h1>
            <hr>
            <div id="notesContainer" class="notes-grid">
                <?php if (!empty($reuniones)): ?>
                    <?php foreach ($reuniones as $reunion): ?>
                        <div class="note-card">
                            <h3 style="text-transform:uppercase; text-align: center;"><?php echo htmlspecialchars($reunion['titulo']); ?></h3>
                            <p><b>Descripcion:</b> <?php echo htmlspecialchars($reunion['descripcion']); ?></p>
                            <p><b>Fecha:</b> <?php echo htmlspecialchars($reunion['fecha']); ?></p>
                            <p><b>Hora:</b> <?php echo htmlspecialchars($reunion['hora']); ?></p>
                            <hr style="width: 80%; margin:auto;">
                            <div style="margin-top: 10px;">
                                <a style="text-decoration: none;" href="editar_alum.php?idAlumno=<?php echo $row['idAlumno']?>" class="link-dark">
                                    <i title="Editar" class="fa-solid fa-pen-to-square fs-5 me-3"></i>
                                </a>
                                <a style="text-decoration: none; cursor:pointer;" class="link-dark" onclick="alerta_eliminar(<?php echo $row['idAlumno']; ?>)">
                                    <fs-5 title="Eliminar" class="fa-solid fa-circle-xmark fs-5"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p><?php echo $mensaje; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>

</body>
</html>