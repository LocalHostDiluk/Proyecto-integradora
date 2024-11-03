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

            <div lass="modal fade" id="reporteModal" tabindex="-1" aria-labelledby="reporteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reporteModalLabel">Crear nuevo reporte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="titulo">Título</label>
                                <input type="text" id="titulo" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" class="form-control" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="fecha">Fecha</label>
                                <input type="date" id="fecha" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="hora">Hora</label>
                                <input type="time" id="hora" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="guardarReporte()">Crear reporte</button>
                            <script>
                                function guardarReporte() {
                                    const titulo = document.getElementById('titulo').value;
                                    const descripcion = document.getElementById('descripcion').value;
                                    const fecha = document.getElementById('fecha').value;
                                    const hora = document.getElementById('hora').value;

                                    if( titulo && descripcion && fecha && hora ) {
                                        fetch('crear_reporte.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify({ titulo, descripcion, fecha, hora })}).then(response => response.json()).then(data => {
                                                if (data.success) {
                                                    Swal.fire('¡Reporte creado!', '', 'success');
                                                    document.getElementById('reporteModal').modal('hide');
                                                } else {
                                                    Swal.fire('¡Error al crear el reporte!', '', 'error');
                                                }
                                            }).catch(error => {
                                                Swal.fire('¡Error al crear el reporte!', '', 'error');
                                        })
                                    } else{
                                        Swal.fire('¡Todos los campos son requeridos!', '', 'error');
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
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
            <h1>Reportes</h1>
            <div id="notesContainer" class="notes-grid">
                <?php if (!empty($reuniones)): ?>
                    <?php foreach ($reuniones as $reunion): ?>
                        <div class="note-card">
                            <h3><?php echo htmlspecialchars($reunion['descripcion']); ?></h3>
                            <p>Fecha: <?php echo htmlspecialchars($reunion['fecha']); ?></p>
                            <p>Hora: <?php echo htmlspecialchars($reunion['hora']); ?></p>
                            <p>Lugar: <?php echo htmlspecialchars($reunion['lugar']); ?></p>
                            <p>ID Alumno: <?php echo htmlspecialchars($reunion['idAlumno']); ?></p>
                            <p>ID Tutor: <?php echo htmlspecialchars($reunion['idTutor']); ?></p>
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