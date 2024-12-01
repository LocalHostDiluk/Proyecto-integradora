<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
</html>

<?php
session_start();
    if (empty($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit();
    } else if ($_SESSION["rol"] != "Administrador") {
        header("Location: ../app/index.php");
        exit();
    }

    include "../conexion.php";
    // Consulta para obtener la información del usuario
    $idUsuario = $_SESSION["id"];
    $sqlUsuario = "SELECT u.correoUsuario, t.nombreTutor, u.imagenPerfil, u.contraseña 
        FROM usuario u
        INNER JOIN tutor t ON u.idTutor = t.idTutor
        WHERE u.idUsuario = ?";
    $stmt = $conn->prepare($sqlUsuario);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    // Procesar cambios en el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Cambiar correo o contraseña
        if(!empty($_POST['correo'])){
            $nuevoCorreo = !empty($_POST['correo']) ? $_POST['correo'] : $usuario['correoUsuario'];
            if (!empty($_POST['contraseña']) && !empty($_POST["confirmar_contraseña"])) {
                if( $_POST['contraseña'] === $_POST['confirmar_contraseña']) {
                    $nuevaContraseña = $_POST['contraseña'];

                    echo "
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Datos actualizados!',
                                text: 'Tus datos se han actualizado correctamente.',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>";

                    $sqlActualizar = "UPDATE usuario SET correoUsuario = ?, contraseña = ? WHERE idUsuario = ?";
                    $stmt = $conn->prepare($sqlActualizar);
                    $stmt->bind_param("ssi", $nuevoCorreo, $nuevaContraseña, $idUsuario);
                    $stmt->execute();

                } else{
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Las contraseñas no coinciden.',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>";
                }
            }
            else{
                $nuevaContraseña = $usuario['contraseña'];
                echo "
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Datos actualizados!',
                                text: 'Tus datos se han actualizado correctamente.',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>";
                $sqlActualizar = "UPDATE usuario SET correoUsuario = ?, contraseña = ? WHERE idUsuario = ?";
                $stmt = $conn->prepare($sqlActualizar);
                $stmt->bind_param("ssi", $nuevoCorreo, $nuevaContraseña, $idUsuario);
                $stmt->execute();
            }
        }
        else{
            $nuevoCorreo = $usuario['correoUsuario'];
            if (!empty($_POST['contraseña']) && !empty($_POST["confirmar_contraseña"])) {
                if( $_POST['contraseña'] === $_POST['confirmar_contraseña']) {
                    $nuevaContraseña = $_POST['contraseña'];

                    echo "
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Datos actualizados!',
                                text: 'Tus datos se han actualizado correctamente.',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>";
                    $sqlActualizar = "UPDATE usuario SET correoUsuario = ?, contraseña = ? WHERE idUsuario = ?";
                    $stmt = $conn->prepare($sqlActualizar);
                    $stmt->bind_param("ssi", $nuevoCorreo, $nuevaContraseña, $idUsuario);
                    $stmt->execute();

                } else{
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Las contraseñas no coinciden.',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>";
                }
            }
            else{
                $nuevaContraseña = $usuario['contraseña'];
                echo "
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Datos actualizados!',
                                text: 'Tus datos se han actualizado correctamente.',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>";
                $sqlActualizar = "UPDATE usuario SET correoUsuario = ?, contraseña = ? WHERE idUsuario = ?";
                $stmt = $conn->prepare($sqlActualizar);
                $stmt->bind_param("ssi", $nuevoCorreo, $nuevaContraseña, $idUsuario);
                $stmt->execute();

            }
        }

        // Cambiar imagen de perfil
        if (isset($_FILES["imagen_perfil"]) && $_FILES["imagen_perfil"]["error"] == 0) {
            $imagenPerfil = $_FILES["imagen_perfil"];
            $extensionesPermitidas = ["jpg", "jpeg", "png"];
            $ext = strtolower(pathinfo($imagenPerfil["name"], PATHINFO_EXTENSION));
            $mime = mime_content_type($imagenPerfil["tmp_name"]);

            if (in_array($ext, $extensionesPermitidas) && ($mime === "image/jpeg" || $mime === "image/png")) {
                if ($imagenPerfil["size"] <= 2 * 1024 * 1024) {
                    $nombreImagen = uniqid() . "." . $ext;
                    $rutaDestino = __DIR__ . "/../uploads/" . $nombreImagen;

                    if (move_uploaded_file($imagenPerfil["tmp_name"], $rutaDestino)) {
                        // Eliminar imagen anterior si existe
                        if (!empty($usuario['imagenPerfil']) && file_exists(__DIR__ . "/../uploads/" . $usuario['imagenPerfil'])) {
                            unlink(__DIR__ . "/../uploads/" . $usuario['imagenPerfil']);
                        }

                        // Actualizar base de datos
                        $sqlActualizarImagen = "UPDATE usuario SET imagenPerfil = ? WHERE idUsuario = ?";
                        $stmt = $conn->prepare($sqlActualizarImagen);
                        $stmt->bind_param("si", $nombreImagen, $idUsuario);
                        $stmt->execute();

                        echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Imagen actualizada!',
                                text: 'Tu imagen de perfil se ha actualizado correctamente.',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.location = 'inicio.php';
                            });
                        </script>";
                    }
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'El tamaño de la imagen no debe superar los 2MB.',
                            confirmButtonText: 'Aceptar'
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Solo se permiten imágenes JPG, JPEG o PNG.',
                        confirmButtonText: 'Aceptar'
                    });
                </script>";
            }
        }
    }

    $filtro_grado = "";
    $filtro_tutor = "";
    $filtro_ciclo = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['grado_grupo'])) {
            $filtro_grado = htmlspecialchars($_POST['grado_grupo']);
        }
        if (isset($_POST['idTutor'])) {
            $filtro_tutor = htmlspecialchars($_POST['idTutor']);
        }
        if (isset($_POST['ciclo_escolar'])) {
            $filtro_ciclo = htmlspecialchars($_POST['ciclo_escolar']);
        }
    }

    $sql = "SELECT 
                reuniones.idReunion,
                reuniones.titulo,
                reuniones.fecha,
                reuniones.hora,
                reuniones.lugar,
                reuniones.descripcion,
                grupo.grado_grupo,
                grupo.ciclo_escolar,
                tutor.nombreTutor
            FROM reuniones
            LEFT JOIN tutor ON reuniones.idTutor = tutor.idTutor
            LEFT JOIN grupo ON reuniones.idGrupo = grupo.idGrupo
            WHERE 1=1";

    $params = [];
    $param_types = "";


    if (!empty($filtro_grado)) {
        $sql .= " AND grupo.grado_grupo = ?";
        $param_types .= "s";
        $params[] = $filtro_grado;
    }
    if (!empty($filtro_tutor)) {
        $sql .= " AND tutor.idTutor = ?";
        $param_types .= "i";
        $params[] = $filtro_tutor;
    }
    if (!empty($filtro_ciclo)) {
        $sql .= " AND grupo.ciclo_escolar = ?";
        $param_types .= "s";
        $params[] = $filtro_ciclo;
    }


    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }


    if (!empty($params)) {
        $stmt->bind_param($param_types, ...$params);
    }

    $stmt->execute();
    $resultReuniones = $stmt->get_result();


    $grados_grupos = $conn->query("SELECT DISTINCT grado_grupo FROM grupo")->fetch_all(MYSQLI_ASSOC);
    $ciclos_escolares = $conn->query("SELECT DISTINCT ciclo_escolar FROM grupo")->fetch_all(MYSQLI_ASSOC);
    $tutores = $conn->query("SELECT DISTINCT idTutor, nombreTutor FROM tutor")->fetch_all(MYSQLI_ASSOC);
?>
    
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/reunion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="Js/modales.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Gestionar Reuniones</title>
</head>
<body>

<div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon id="cloud" name="menu-outline"></ion-icon>
                <span>Esc. Sec 4</span>
            </div>
        </div>
        <nav class="navegacion">
            <ul>
                <li><ion-icon title="Inicio" name="home-outline"></ion-icon><a href="inicio.php" class="seccion">Inicio</a></li>
                <li><ion-icon title="Tutores" name="person-outline"></ion-icon><a href="gestionar_tutores.php" class="seccion">Tutores</a></li>
                <li><ion-icon title="Grupos" name="people-outline"></ion-icon><a href="gestionar_grupos.php" class="seccion">Grupos</a></li>
                <li><ion-icon title="Reportes" name="document-text-outline"></ion-icon><a href="gestionar_reuniones.php" class="seccion">Reportes</a></li>
                <li><ion-icon title="Usuarios" name="person-add-outline"></ion-icon><a href="gestionar_usuario.php" class="seccion">Usuarios</a></li>
                <li><ion-icon title="Cerrar sesión" name="log-out-outline"></ion-icon><a href="#" id="cerrar-sesion" class="seccion">Cerrar Sesión</a></li>
            </ul>
        </nav>

        <!-- Separación del modo oscuro -->
        <hr class="separador">

     

        <div class="usuario">
            <img 
                src="<?php echo !empty($usuario['imagenPerfil']) ? '../uploads/' . $usuario['imagenPerfil'] : 'https://via.placeholder.com/50'; ?>" 
                alt="Perfil" 
                class="perfil-imagen" 
                id="perfil-imagen">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">
                            Usuario: 
                            <?php
                            echo $_SESSION["correoUsuario"];
                            ?>
                        </span>
                        <span class="email">
                            <?php
                            echo $_SESSION["rol"];
                            ?>
                        </span>
                    </div>
                </div>
        </div>
    </div>


    <main>
        <div class="container">
            <h1>Gestión de reportes</h1>
            <form method="POST" action="" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="grado_grupo" class="form-label">Grado/Grupo:</label>
                    <select name="grado_grupo" id="grado_grupo" class="form-select">
                        <option value="">Todos</option>
                        <?php foreach ($grados_grupos as $grado): ?>
                            <option value="<?= htmlspecialchars($grado['grado_grupo']) ?>" <?= $filtro_grado === $grado['grado_grupo'] ? "selected" : "" ?>>
                                <?= htmlspecialchars($grado['grado_grupo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="ciclo_escolar" class="form-label">Ciclo Escolar:</label>
                    <select name="ciclo_escolar" id="ciclo_escolar" class="form-select">
                        <option value="">Todos</option>
                        <?php foreach ($ciclos_escolares as $ciclo): ?>
                            <option value="<?= htmlspecialchars($ciclo['ciclo_escolar']) ?>" <?= $filtro_ciclo === $ciclo['ciclo_escolar'] ? "selected" : "" ?>>
                                <?= htmlspecialchars($ciclo['ciclo_escolar']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="idTutor" class="form-label">Tutor:</label>
                    <select name="idTutor" id="idTutor" class="form-select">
                        <option value="">Todos</option>
                        <?php foreach ($tutores as $tutor): ?>
                            <option value="<?= htmlspecialchars($tutor['idTutor']) ?>" <?= $filtro_tutor == $tutor['idTutor'] ? "selected" : "" ?>>
                                <?= htmlspecialchars($tutor['nombreTutor']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
                <div class="col-6">
                    <a href="gestionar_reuniones.php" class="btn btn-secondary w-100">Limpiar</a>
                </div>
            </form>

            <h3>Lista de reuniones</h3>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Lugar</th>
                        <th>Descripción</th>
                        <th>Grado/Grupo</th>
                        <th>Ciclo Escolar</th>
                        <th>Tutor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultReuniones->num_rows > 0): ?>
                        <?php while ($reunion = $resultReuniones->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($reunion['idReunion']) ?></td>
                                <td><?= htmlspecialchars($reunion['titulo']) ?></td>
                                <td><?= htmlspecialchars($reunion['fecha']) ?></td>
                                <td><?= htmlspecialchars($reunion['hora']) ?></td>
                                <td><?= htmlspecialchars($reunion['lugar']) ?></td>
                                <td><?= htmlspecialchars($reunion['descripcion']) ?></td>
                                <td><?= htmlspecialchars($reunion['grado_grupo']) ?></td>
                                <td><?= htmlspecialchars($reunion['ciclo_escolar']) ?></td>
                                <td><?= htmlspecialchars($reunion['nombreTutor']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No se encontraron resultados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="modal-ajustar-perfil" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ajustes del Perfil</h3>
        </div>
        <div class="modal-body">
            <form action="inicio.php" method="POST" enctype="multipart/form-data" id="form-ajustar-perfil">
                <!-- Cambiar correo -->
                <div class="form-group">
                    <label for="correo">Usuario:</label>
                    <input type="text" placeholder="Ingrese el nuevo usuario (opcional)" name="correo" id="correo" value="<?php echo htmlspecialchars($usuario['correoUsuario']); ?>">
                </div>
                <!-- Cambiar contraseña -->
                <div class="form-group">
                    <label for="contraseña">Nueva Contraseña:</label>
                    <input type="password" placeholder="Ingrese la nueva contraseña (opcional)" name="contraseña" id="contraseña">
                </div>
                <div class="form-group">
                    <label for="confirmar-contraseña">Confirmar Contraseña:</label>
                    <input type="password" placeholder="Confirme la nueva contraseña" name="confirmar_contraseña" id="confirmar-contraseña">
                </div>
                <!-- Cambiar imagen -->
                <div class="form-group">
                    <label for="imagen-perfil">Subir nueva imagen:</label>
                    <input type="file" name="imagen_perfil" id="imagen-perfil" accept="image/*">
                </div>
                <div class="modal-f">
                    <button type="submit">Guardar Cambios</button>
                </div>
            </form>
            <span class="cerrar-modal" id="cerrar-modal">Cerrar</span>
        </div>
    </div>
</div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const perfilImagen = document.getElementById('perfil-imagen');
            const modal = document.getElementById('modal-ajustar-perfil');
            const cerrarModal = document.getElementById('cerrar-modal');

            perfilImagen.addEventListener('click', function () {
                modal.style.display = 'flex';
            });

            cerrarModal.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    
        function confirmarCerrarSesion() {
            Swal.fire({
                title: '¿Cerrar Sesión?',
                text: '¿Deseas cerrar tu sesión actual?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../controlador_cerrar.php";
                }
            });
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>

</body>
</html>