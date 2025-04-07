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
                <span>Esc. Sec 4</span>
            </div>
        </div>
        
        <nav class="navegacion">
            <ul>
                <li>
                    <a class="seccion" href="inicio.php">
                        <ion-icon title="Inicio" name="clipboard-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" id="inbox" href="index.php">
                        <ion-icon title="Calificaciones" name="clipboard-outline"></ion-icon>
                        <span>Reportes</span>
                    </a>
                </li>
                <li>
                    <a class="seccion" href="calif.php">
                        <ion-icon title="Reportes" name="document-text-outline"></ion-icon>
                        <span>Filtrado de Grupos</span>
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

            <div class="usuario-contenido">
    <div class="imagen-perfil" onclick="document.getElementById('modal-perfil').style.display='flex'">
        <img src="ruta/de/imagen/perfil/<?php echo $_SESSION['imagenPerfil'] ?? 'default.png'; ?>" alt="Imagen de Perfil">
    </div>
    <div class="usuario">
        <div class="info-usuario">
            <div class="nombre-email">
                <span class="nombre">
                    Usuario: <?php echo $_SESSION["correoUsuario"]; ?>
                </span>
                <span class="email">
                    <?php echo $_SESSION["rol"]; ?>
                </span>
            </div>
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
        <h1 class="text-center my-4">Reportes</h1>

        <!-- Botón para abrir el modal de crear reporte -->
        <div class="text-center mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearReunionModal">
                <ion-icon name="add-outline"></ion-icon>
                Crear reunion
            </button>
        </div>

        <div class="container">
                <?php if (!empty($reuniones)): ?>
                    <?php foreach ($reuniones as $reunion): ?>
                        <div class="note-card">
                            <h3 style="text-transform:uppercase; text-align: center;">
                                <?php echo htmlspecialchars($reunion['titulo']); ?>
                            </h3>
                            <p><b>Descripción:</b> <?php echo htmlspecialchars($reunion['descripcion']); ?></p>
                            <p><b>Fecha:</b> <?php echo htmlspecialchars($reunion['fecha']); ?></p>
                            <p><b>Hora:</b> <?php echo htmlspecialchars($reunion['hora']); ?></p>
                            <hr style="width: 80%; margin:auto;">
                            <div style="margin-top: 10px;">
                                <!-- Botón para mostrar más información -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#infoModal<?php echo $reunion['idReunion']; ?>" class="link-dark">
                                    <i title="Más Información" class="fa-solid fa-info-circle fs-5 me-3"></i>
                                </a>
                                <!-- Botón Editar -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $reunion['idReunion']; ?>" class="link-dark">
                                    <i title="Editar" class="fa-solid fa-pen-to-square fs-5 me-3"></i>
                                </a>
                                <!-- Botón Eliminar -->
                                <a href="#" onclick="eliminarReunion(<?php echo $reunion['idReunion']; ?>)" class="link-dark">
                                    <i title="Eliminar" class="fa-solid fa-circle-xmark fs-5"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Modal para más información -->
                        <div class="modal fade" id="infoModal<?php echo $reunion['idReunion']; ?>" tabindex="-1" aria-labelledby="infoModalLabel<?php echo $reunion['idReunion']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="infoModalLabel<?php echo $reunion['idReunion']; ?>">Información de la Reunión</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><b>ID Reunión:</b> <?php echo htmlspecialchars($reunion['idReunion']); ?></p>
                                        <p><b>Grupo:</b> <?php echo htmlspecialchars($reunion['idGrupo']); ?></p>
                                        <p><b>Lugar:</b> <?php echo htmlspecialchars($reunion['lugar']); ?></p>
                                        <p><b>Fecha:</b> <?php echo htmlspecialchars($reunion['fecha']); ?></p>
                                        <p><b>Hora:</b> <?php echo htmlspecialchars($reunion['hora']); ?></p>
                                        <p><b>Descripción:</b> <?php echo htmlspecialchars($reunion['descripcion']); ?></p>
                                        <!-- Añadir otros campos según la base de datos -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Editar -->
                        <div class="modal fade" id="editarModal<?php echo $reunion['idReunion']; ?>" tabindex="-1" aria-labelledby="editarModalLabel<?php echo $reunion['idReunion']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel<?php echo $reunion['idReunion']; ?>">Editar Reunión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="editar_reunion.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="idReunion" value="<?php echo $reunion['idReunion']; ?>">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" value="<?php echo htmlspecialchars($reunion['titulo']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" required><?php echo htmlspecialchars($reunion['descripcion']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" value="<?php echo htmlspecialchars($reunion['fecha']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="hora" class="form-label">Hora</label>
                        <input type="time" class="form-control" name="hora" value="<?php echo htmlspecialchars($reunion['hora']); ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

                    <?php endforeach; ?>
                <?php else: ?>
                <p><?php echo $mensaje; ?></p>
                <?php endif; ?>
            </div>

        <!-- Modal para Crear Reunión -->
        <div class="modal fade" id="crearReunionModal" tabindex="-1" aria-labelledby="crearReunionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearReunionModalLabel">Crear Nuevo Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="crearReunionForm" action="crear_reunion.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="hora" class="form-label">Hora</label>
                        <input type="time" class="form-control" id="hora" name="hora" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="lugar" class="form-label">Lugar</label>
                        <input type="text" class="form-control" id="lugar" name="lugar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="crearReunionBtn" type="submit" class="btn btn-primary" disabled>Crear Reunión</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Modal para actualizar perfil -->
    <div id="modal-perfil" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modal-perfil').style.display='none'">&times;</span>
            <h2>Actualizar Perfil</h2>
            <form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" id="correo" name="correo" value="<?php echo $_SESSION['correoUsuario']; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Nueva Contraseña</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirmar Contraseña</label>
                    <input type="password" id="confirm-password" name="confirm-password">
                </div>
                <div class="form-group">
                    <label for="imagen">Cambiar Imagen de Perfil</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script>
        // Al abrir el modal, establecer fecha y hora actuales
        document.getElementById('crearReunionModal').addEventListener('shown.bs.modal', function () {
            // Obtener la fecha actual y establecerla en el campo de fecha
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('fecha').value = today;

            // Obtener la hora actual y establecerla en el campo de hora
            var time = new Date().toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('hora').value = time;
        });
    </script>


        <script>

            function eliminarReunion(idReunion) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esta acción",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'eliminar_reunion.php?idReunion=' + idReunion;
                    }
                });
            }

            // Selección de elementos del formulario
            const form = document.getElementById('crearReunionForm');
            const inputs = form.querySelectorAll('input, textarea');
            const submitButton = document.getElementById('crearReunionBtn');

            // Verifica si todos los campos están llenos
            function verificarCampos() {
                const todosLlenos = Array.from(inputs).every(input => input.value.trim() !== '');
                submitButton.disabled = !todosLlenos;
                if (todosLlenos) {
                    submitButton.classList.remove('btn-secondary');
                    submitButton.classList.add('btn-primary');
                } else {
                    submitButton.classList.remove('btn-primary');
                    submitButton.classList.add('btn-secondary');
                }
            }

            // Escucha cambios en los campos del formulario
            inputs.forEach(input => {
                input.addEventListener('input', verificarCampos);
            });
        </script>

        <style>
            .note-card {
                background: #AFEEEE; /* Color amarillo post-it */
                box-shadow: 2px 4px 10px #fcb7af; /* Sombra suave */
                border-radius: 12px;
                padding: 20px 30px;
                margin: 20px auto;
                max-width: 800px; /* Ancho alargado */
                font-family: 'Arial', sans-serif;
                position: relative;
                text-align: left; /* Alineación izquierda */
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }

            .note-card:before {
                content: "";
                position: absolute;
                top: -10px;
                right: -10px;
                width: 40px;
                height: 40px;
                background: #fff48f;
                box-shadow: -4px 4px 10px rgba(0, 0, 0, 0.15);
                transform: rotate(45deg); /* Simula una esquina levantada */
                border-top-right-radius: 10px;
            }

            .note-card:hover {
                transform: rotate(0deg); /* Quita inclinación al hacer hover */
                box-shadow: 4px 8px 15px rgba(0, 0, 0, 0.25); /* Aumenta la sombra */
            }

            .note-card h3 {
                font-size: 1.8em;
                margin-bottom: 15px;
                color: #333;
            }

            .note-card p {
                font-size: 1.2em;
                color: #444;
                margin-bottom: 10px;
            }

            .note-card hr {
                border: 1px dashed #666;
            }

            .note-card .link-dark {
                text-decoration: none;
                font-weight: bold;
                margin-right: 15px;
            }

            .note-card .link-dark:hover {
                color: #ff8800;
            }

            /* Estilo para el botón deshabilitado */
            .btn-secondary:disabled {
                background-color: #d6d6d6;
                border-color: #d6d6d6;
                color: #8c8c8c;
                cursor: not-allowed;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </main>



</body>
</html>
 <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>