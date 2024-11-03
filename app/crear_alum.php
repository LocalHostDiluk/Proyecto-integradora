<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
</html>

<?php
use function PHPSTORM_META\type;

session_start();
if (empty($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit();
}

if (isset($_POST["submit"])) {
    require_once "../conexion.php";
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $desc = $_POST["desc"];
    $id = "SELECT idGrupo FROM grupo WHERE idTutor= $_SESSION[id]";
    $result = mysqli_query($conn, $id);
    $row = mysqli_fetch_assoc($result);
    $int = (int)$row["idGrupo"];

    if (empty($nombre) || empty($apellido) || empty($desc)) {
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
    } else {
        $sql = "INSERT INTO alumno (idAlumno, nombreAlumno, apellidoAlumno, descripcionAlumno, idGrupo) VALUES (null,'$nombre', '$apellido', '$desc', $int)";
        
        $result = mysqli_query($conn,$sql);
        if ($result) {
            header("Location: grupo.php?msg=Alumno registrado exitosamente");
        } else {
            echo "Error al registrar alumno" . $mysqli->error($conn);
        
        } 
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de alumno</title>
    <link rel="stylesheet" href="estilos/grupo.css">
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
            <button class="boton">
                <ion-icon name="add-outline"></ion-icon>
                <span>Crear reporte</span>
            </button>
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a class="seccion" href="index.php">
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
                    <a class="seccion" id="inbox" href="#">
                        <ion-icon title="Grupos" name="grid-outline"></ion-icon>
                        <span>Grupo</span>
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

    <main class="container">
        <div class="text-center mb-4">
            <h3>Registrar alumno</h3>
            <p class="text-muted">Completa para registrar al alumno</p>
        </div>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;">
                <div class="row">
                    <div class="col">
                        <label for="nm" class="form-label">Nombre</label>
                        <input id="nm" type="text" class="form-control" name="nombre" placeholder="Nombre alumno">
                    </div>
                    <div class="col">
                        <label for="ap" class="form-label">Apellido</label>
                        <input id="ap" type="text" class="form-control" name="apellido" placeholder="Apellido alumno">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="desc" class="form-label">Descripcion</label>
                    <textarea id="desc" type="text" class="form-control" name="desc" placeholder="Descipción del alumno (enfermedades, carácter, etc)"></textarea>
                </div>

                <div>
                    <button class="btn btn-success" name="submit" type="submit">Añadir</button>
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