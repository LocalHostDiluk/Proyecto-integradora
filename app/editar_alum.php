<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
</html>

<?php
session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
} else if ($_SESSION["rol"] != "Tutor") {
    header("Location: ../admin/inicio.php");
    exit();
}

$id = $_GET['idAlumno'];
$int = (int)$id;

if (isset($_POST['submit'])) {
    include "../conexion.php";
    $desc = $_POST['desc'];
    $estatus = $_POST['estatus'];
    $sql = "UPDATE alumno SET descripcionAlumno = '$desc', estatus_alumno = '$estatus' WHERE idAlumno = $int";
    if (!empty($desc)) {
        
        if (mysqli_query($conn, $sql)) {
            header("Location: grupo.php?msg=Alumno actualizado correctamente");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }else{
        ?>
        <script>
            Swal.fire({
                title: '¡Alerta!',
                text: 'Completa todos los campos',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        </script>
        <?php
    }
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edicion de alumno</title>
    <link rel="stylesheet" href="estilos/grupo.css">
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
                <span>Esc Sec 4</span>
            </div>
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a class="seccion" href="index.php">
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
                    <a class="seccion" id="inbox" href="grupo.php">
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
                            <?php
                            echo $_SESSION["rol"];
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="container">
        <div class="text-center mb-4">
            <h3>Editar información alumno</h3>
            <p class="text-muted">Edita la información del alumno</p>
        </div>

        <?php
        include "../conexion.php";
        $id = $_GET['idAlumno'];
        $int = (int)$id;
        $sql = "SELECT * FROM alumno WHERE idAlumno = $int";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        ?>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;">
                <div class="row mb-3">
                    <div class="col">
                        <label style="font-weight: bold;" for="nm" class="form-label">Nombre:</label>
                        <?php echo $row['nombreAlumno']?>
                    </div>
                    <div class="col">
                        <label style="font-weight: bold;" for="ap" class="form-label">Apellido:</label>
                        <?php echo $row['apellidoAlumno']?>
                    </div>
                    <div class="col">
                        <label style="font-weight: bold;" for="ap" class="form-label">Estatus:</label>
                        <?php echo $row['estatus_alumno']?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="desc" class="form-label">Cambia la descripción del alumno</label>
                    <input id="desc" type="text" class="form-control" name="desc" value="<?php echo $row['descripcionAlumno'] ?>">
                </div>

                <div class="mb-3">
                    <label for="grupo" class="form-label">Estatus del alumno</label><br>
                    <select name="estatus" class="form-select">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button style="margin-right: 10px;" class="btn btn-primary" name="submit" type="submit">Actualizar</button>
                    <a href="grupo.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../app/script.js"></script>

</body>
</html>