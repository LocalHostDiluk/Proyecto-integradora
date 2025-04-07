<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</html>

<?php
    include "../conexion.php";

    session_start();
    if (empty($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit();
    } else if ($_SESSION["rol"] != "Administrador") {
        header("Location: ../app/index.php");
        exit();
    }

    $idUsuario = $_SESSION["id"];
    $sqlUsuario = "SELECT u.idUsuario, u.correoUsuario, t.nombreTutor, u.imagenPerfil 
        FROM usuario u
        INNER JOIN tutor t ON u.idTutor = t.idTutor
        WHERE u.idUsuario = ?";
    $stmt = $conn->prepare($sqlUsuario);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    $sql = "SELECT u.idUsuario, t.nombreTutor, t.apellidoTutor, t.telefonoTutor, t.direccionTutor, u.correoUsuario, u.rol, u.estatus_usuario FROM tutor t INNER JOIN usuario u ON t.idTutor = u.idTutor AND u.rol = 'Tutor'";
    $resultado = $conn->query($sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Cambiar correo o contraseña
        if (!empty($_POST['correo']) || !empty($_POST['contraseña'])) {
            $nuevoCorreo = !empty($_POST['correo']) ? $_POST['correo'] : $usuario['correoUsuario'];
            $nuevaContraseña = !empty($_POST['contraseña']) ? $_POST['contraseña'] : $usuario['contraseña'];

            $sqlActualizar = "UPDATE usuario SET correoUsuario = ?, contraseña = ? WHERE idUsuario = ?";
            $stmt = $conn->prepare($sqlActualizar);
            $stmt->bind_param("ssi", $nuevoCorreo, $nuevaContraseña, $idUsuario);
            $stmt->execute();
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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['agregar_admin'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];

            $agregar = "INSERT INTO admin (nombreAdmin, apellidoAdmin, telefonoAdmin, direccionAdmin, fecha_creacionAdmin, estatus_admin) VALUES ('$nombre', '$apellido', '$telefono', '$direccion', NOW(), 'Activo')";

            if ($conn->query($agregar) === TRUE) {
                echo "
                <script>
                    Swal.fire({
                        title: 'Inicio exitoso!',
                        text: 'Ahora puedes navegar por el sitio',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = 'gestionar_usuario.php';
                    });
                </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: '¡Fallo al añador!',
                        text: 'No se pudo crear',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = 'gestionar_usuario.php';
                    });
                </script>";
            }
            $stmt->close();
        }
    }
    if (!empty($_POST['contraseña'])) {
        $nuevaContraseña = $_POST['contraseña'];
        $confirmarContraseña = $_POST['confirmar_contraseña'];
    
        if ($nuevaContraseña !== $confirmarContraseña) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden.',
                    confirmButtonText: 'Aceptar'
                });
            </script>";
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="Js/modales.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Usuarios</title>
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
            <h1>Gestión de usuarios</h1>
            <button id="añadir" class="btn btn-primary" onclick="openAddAdmin()">Agregar administrador</button>
            <a id="ver-activos" class="btn btn-success mb-3" style="cursor:pointer;">Ver tutores</a>
            <a id="ver-inactivos" class="btn btn-dark mb-3" style="cursor:pointer;">Ver administradores</a>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $user['nombreTutor'], ' ', $user['apellidoTutor']; ?></td>
                            <td><?php echo htmlspecialchars($user['rol']); ?></td>
                            <td><?php echo htmlspecialchars($user['estatus_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($user['correoUsuario']); ?></td>
                            <td>
                            <button class="btn btn-dark abrir-modal-editar" data-id="<?php echo $user['idUsuario']; ?>">Editar Usuario</button>


                                <a class="btn btn-danger" style="text-decoration: none; cursor:pointer;" class="link-dark" onclick="alerta_eliminar(<?php echo $user['idUsuario']; ?>)">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <!-- Modal de edición -->
<div id="modal-editar" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Editar Usuario</h3>
        </div>
        <div class="modal-body">
            <form id="form-editar" method="POST" action="gestionar_usuario.php">
                <input type="hidden" name="idUsuario" id="idUsuario">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" id="telefono" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" id="direccion" required>
                </div>
                <button type="submit" class="btn btn-success">Guardar cambios</button>
            </form>
            <span class="cerrar-modal" id="cerrar-modal">Cerrar</span>
        </div>
    </div>
</div>


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
        
        function alerta_eliminarAdmin(codigo){
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Estás a punto eliminar el administrador",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, continuar"
                }).then((result) => {
                if (result.isConfirmed) {
                    eliminarAdmin(codigo);
                }
            });
        }

        function eliminarAdmin(codigo){
            parametros = {id: codigo};
            $.ajax({
                data: parametros,
                url: 'borrar_admin.php',
                type: 'POST',
                success: function(response){
                    Swal.fire({
                        title: "¡Hecho!",
                        text: "El usuario ha sido eliminado",
                        icon: "success",
                        confirmButtonText: "Continuar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            })
        }

        function alerta_eliminar(codigo){
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Estás a punto eliminar el usuario",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, continuar"
                }).then((result) => {
                if (result.isConfirmed) {
                    mandar_php(codigo);
                }
            });
        }

        function mandar_php(codigo){
            parametros = {id: codigo};
            $.ajax({
                data: parametros,
                url: 'borrar_user.php',
                type: 'POST',
                success: function(response){
                    Swal.fire({
                        title: "¡Hecho!",
                        text: "El usuario ha sido eliminado",
                        icon: "success",
                        confirmButtonText: "Continuar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            })
        }

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
                    window.location.href = '../controlador_cerrar.php';
                }
            });
        });

        $(document).ready(function() {
            // Initially set "Ver activos" as active
            $("#ver-activos").addClass("btn-success").removeClass("btn-dark");
            $("#ver-inactivos").addClass("btn-dark").removeClass("btn-success");

            // Function to toggle active/inactive buttons
            function toggleButtons(activeBtn, inactiveBtn) {
                $(activeBtn).addClass("btn-success").removeClass("btn-dark");
                $(inactiveBtn).addClass("btn-dark").removeClass("btn-success");
            }

            // Load active students
            $("#ver-activos").on("click", function() {
                toggleButtons("#ver-activos", "#ver-inactivos"); // Change button styles
                $.ajax({
                    url: 'gest_user.php', // Fetch active students
                    type: 'GET',
                    success: function(data) {
                        $("tbody").html(data); // Update table content
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error",
                            text: "No se pudieron cargar los alumnos activos.",
                            icon: "error",
                            confirmButtonText: "Continuar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                });
            });

            // Load inactive students
            $("#ver-inactivos").on("click", function() {
                toggleButtons("#ver-inactivos", "#ver-activos"); // Change button styles
                $.ajax({
                    url: 'gest_admin.php', // Fetch inactive students
                    type: 'GET',
                    success: function(data) {
                        $("tbody").html(data); // Update table content
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error",
                            text: "No se pudieron cargar los alumnos inactivos.",
                            icon: "error",
                            confirmButtonText: "Continuar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                });
            });
        });
        $(document).ready(function () {
    $('.abrir-modal-editar').on('click', function () {
        var idUsuario = $(this).data('id'); // Obtener el ID del usuario
        
        // Hacer una solicitud AJAX para obtener los datos del usuario
        $.ajax({
            url: 'obtener_usuario.php', // Archivo PHP que trae la info del usuario
            type: 'POST',
            data: { idUsuario: idUsuario },
            success: function (data) {
                // Suponiendo que el archivo PHP devuelve la información en formato JSON
                var usuario = JSON.parse(data);
                
                // Llenar el formulario con los datos del usuario
                $('#idUsuario').val(usuario.idUsuario);
                $('#nombre').val(usuario.nombreTutor);
                $('#apellido').val(usuario.apellidoTutor);
                $('#telefono').val(usuario.telefonoTutor);
                $('#direccion').val(usuario.direccionTutor);
                
                // Mostrar el modal
                $('#modal-editar').show();
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información del usuario.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });

    // Cerrar el modal cuando se hace clic en el botón de cerrar
    $('#cerrar-modal').on('click', function () {
        $('#modal-editar').hide();
    });

    // Cerrar el modal si se hace clic fuera del contenido
    $(window).on('click', function (event) {
        if (event.target == $('#modal-editar')[0]) {
            $('#modal-editar').hide();
        }
    });
});

</script>
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>
    
</body>
</html>