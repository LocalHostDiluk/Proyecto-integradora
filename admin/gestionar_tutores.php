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

    // Agregar tutor
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['agregar_tutor'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];

            $sqlAgregar = "INSERT INTO tutor (nombreTutor, apellidoTutor, telefonoTutor, direccionTutor, estatus_tutor) 
            VALUES (?, ?, ?, ?, 'activo')";
            $stmt = $conn->prepare($sqlAgregar);
            $stmt->bind_param("ssss", $nombre, $apellido, $telefono, $direccion);
            if ($stmt->execute()) {
                echo "<script>Swal.fire('¡Éxito!', 'Tutor agregado correctamente', 'success');</script>";
            } else {
                echo "<script>Swal.fire('Error', 'No se pudo agregar el tutor', 'error');</script>";
            }
            $stmt->close();
        }

        if (isset($_POST['editar_tutor'])) {
            $idTutor = $_POST['idTutor'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];

            $sqlEditar = "UPDATE tutor SET nombreTutor = ?, apellidoTutor = ?, telefonoTutor = ?, direccionTutor = ? WHERE idTutor = ?";
            $stmt = $conn->prepare($sqlEditar);
            $stmt->bind_param("ssssi", $nombre, $apellido, $telefono, $direccion, $idTutor);
            if ($stmt->execute()) {
                echo "<script>Swal.fire('¡Éxito!', 'Tutor actualizado correctamente', 'success');</script>";
            } else {
                echo "<script>Swal.fire('Error', 'No se pudo actualizar el tutor', 'error');</script>";
            }
            $stmt->close();
        }
        

        if (isset($_POST['eliminar_tutor'])) {
            $idTutor = $_POST['idTutor'];

            $sqlCheck = "SELECT COUNT(*) AS total FROM usuario WHERE idTutor = ?";
            $stmt = $conn->prepare($sqlCheck);
            $stmt->bind_param("i", $idTutor);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row['total'] > 0) {
                echo "<script>Swal.fire('Error', 'No se puede eliminar el tutor porque está asociado con usuarios.', 'error');</script>";
            } else {
                $sqlEliminar = "DELETE FROM tutor WHERE idTutor = ?";
                $stmt = $conn->prepare($sqlEliminar);
                $stmt->bind_param("i", $idTutor);
                if ($stmt->execute()) {
                    echo "<script>Swal.fire('¡Éxito!', 'Tutor eliminado correctamente', 'success');</script>";
                } else {
                    echo "<script>Swal.fire('Error', 'No se pudo eliminar el tutor', 'error');</script>";
                }
                $stmt->close();
            }
        }
    }

    //// Consulta para listar tutores
    $sqlTutores = "SELECT * FROM tutor";
    $resultTutores = $conn->query($sqlTutores);

    $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

if (!empty($buscar)) {
    $sqlTutores = "SELECT * FROM tutor WHERE nombreTutor LIKE ?";
    $stmt = $conn->prepare($sqlTutores);
    $likeBuscar = "%$buscar%";
    $stmt->bind_param("s", $likeBuscar);
    $stmt->execute();
    $resultTutores = $stmt->get_result();
} else {
    $sqlTutores = "SELECT * FROM tutor";
    $resultTutores = $conn->query($sqlTutores);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/tutor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="Js/modales.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Panel de Inicio</title>
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
        <?php
            if (isset($_GET['msg'])) {
                $msg = $_GET['msg'];
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                '.$msg.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        ?>
        <div class="container">
            
            <h1>Gestión de tutores</h1>
            <button id="añadir" class="btn btn-primary" onclick="openAddModal()">Agregar Tutor</button>
            </div>
            <br>
    <div class="d-flex mb-3">
    <input type="text" id="search-input" class="form-control" placeholder="Buscar por nombre..." style="max-width: 250px;">
    <button id="clear-search" class="btn btn-secondary ms-2">Limpiar</button>
</div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($tutor = $resultTutores->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tutor['nombreTutor']); ?></td>
                            <td><?php echo htmlspecialchars($tutor['apellidoTutor']); ?></td>
                            <td><?php echo htmlspecialchars($tutor['telefonoTutor']); ?></td>
                            <td><?php echo htmlspecialchars($tutor['direccionTutor']); ?></td>
                            <td>
                                <button class="btn btn-dark" onclick="openEditModal(<?php echo $tutor['idTutor']; ?>, '<?php echo htmlspecialchars($tutor['nombreTutor']); ?>', '<?php echo htmlspecialchars($tutor['apellidoTutor']); ?>', '<?php echo htmlspecialchars($tutor['telefonoTutor']); ?>', '<?php echo htmlspecialchars($tutor['direccionTutor']); ?>')">Editar</button>
                                <a class="btn btn-danger" onclick="alerta_eliminar(<?php echo $tutor['idTutor']; ?>)">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
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
        
        function alerta_eliminar(codigo){
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
                        window.location.href = 'borrar_tutor.php?idTutor=' + codigo;
                    }
                });
        }

        function mandar_php(codigo){
            parametros = {id: codigo};
            $.ajax({
                data: parametros,
                url: 'borrar_tutor.php',
                type: 'POST',
                success: function(response){
                    if (response == 1) {
                        Swal.fire({
                            title: "¡Hecho!",
                            text: "El tutor ha sido eliminado",
                            icon: "success",
                            confirmButtonText: "Continuar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo eliminar el tutor",
                            icon: "error",
                            confirmButtonText: "Continuar"
                        });
                    }
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
        
        // Función para filtrar la tabla según la búsqueda
document.getElementById('search-input').addEventListener('input', function() {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        let name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
        if (name.includes(searchValue)) {
            row.style.display = '';  // Mostrar fila
        } else {
            row.style.display = 'none';  // Ocultar fila
        }
    });
});

// Función para limpiar la búsqueda
document.getElementById('clear-search').addEventListener('click', function() {
    document.getElementById('search-input').value = '';  // Limpiar campo de búsqueda
    let rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => row.style.display = '');  // Mostrar todas las filas
});
 
// Función para validar los campos del formulario
function validateForm() {
        // Obtener los valores de los campos
        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const direccion = document.getElementById('direccion').value.trim();

        // Referencia al botón de envío
        const submitButton = document.getElementById('editar');

        // Habilitar o deshabilitar el botón basado en si los campos están completos
        if (nombre && apellido && telefono && direccion) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    // Llamar a la función para inicializar el estado del botón
    validateForm();
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>
</body>
</html>
