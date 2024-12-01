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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Inicio</title>
    <link rel="stylesheet" href="styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="Js/modales.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

        <div class="modo-oscuro">
            
           
        </div>

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
            <div class="container py-5">
                <!-- Encabezado -->
                <div class="row mb-4">
                    <div class="col">
                        <h1>Bienvenido, <?php echo $usuario['nombreTutor']; ?> 👋</h1>
                        <p class="text-secondary">Aquí puedes gestionar y visualizar la información de tu sistema.</p>
                    </div>
                </div>

                <!-- Tarjetas informativas -->
                <div class="row">
                    <!-- Tarjeta 1 -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <ion-icon name="person-outline" style="font-size: 2rem;"></ion-icon>
                                <h5 class="card-title mt-3">Tutores</h5>
                                <p class="card-text">Gestión de tutores asignados.</p>
                                <a href="gestionar_tutores.php" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 2 -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <ion-icon name="people-outline" style="font-size: 2rem;"></ion-icon>
                                <h5 class="card-title mt-3">Grupos</h5>
                                <p class="card-text">Organización de grupos.</p>
                                <a href="gestionar_grupos.php" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 3 -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <ion-icon name="document-text-outline" style="font-size: 2rem;"></ion-icon>
                                <h5 class="card-title mt-3">Reportes</h5>
                                <p class="card-text">Consulta de reportes académicos.</p>
                                <a href="gestionar_reuniones.php" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Segunda fila de contenido -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <ion-icon name="person-add-outline" style="font-size: 2rem;"></ion-icon>
                                <h5 class="card-title mt-3">Usuarios</h5>
                                <p class="card-text">Gestión de usuarios y roles del sistema.</p>
                                <a href="gestionar_usuario.php" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <ion-icon name="log-out-outline" style="font-size: 2rem;"></ion-icon>
                                <h5 class="card-title mt-3">Cerrar sesión</h5>
                                <p class="card-text">Sal del sistema de manera segura.</p>
                                <button id="cerrar-sesion-btn" class="btn btn-danger">Cerrar sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal para perfil -->
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
        document.getElementById('cerrar-sesion').addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro de cerrar sesión?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../controlador_cerrar.php'; // Cambia esta URL si es necesario
                }
            });
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>

</body>
</html>
