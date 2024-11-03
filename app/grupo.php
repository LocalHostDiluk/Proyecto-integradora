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
    <title>Alumnos</title>
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
                <span>Esc. Sec 4</span>
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

    <main class="cont">
        <?php
        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            '.$msg.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        ?>
        <?php
        include "../conexion.php";
        $sql = "SELECT alumno.idAlumno, alumno.nombreAlumno, alumno.apellidoAlumno, alumno.estatus_alumno, grupo.grado_grupo FROM alumno INNER JOIN grupo ON alumno.idGrupo = grupo.idGrupo AND alumno.estatus_alumno = 'Activo' AND grupo.idTutor = $_SESSION[id]";
        $resultado = $conn->query($sql);
        if ($resultado->num_rows > 0){
            ?>
            <a href="crear_alum.php" class="btn btn-info mb-3">Nuevo</a>
            <a href="grupo_inactivos.php" class="btn btn-dark mb-3">Ver inactivos</a>
    
            <table class="table table-hover table-responsive text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Grupo</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        ?>
                        <tr>
                            <th><?php echo $row['idAlumno']?></th>
                            <td><?php echo $row['nombreAlumno']?></td>
                            <td><?php echo $row['apellidoAlumno']?></td>
                            <td><?php echo $row['grado_grupo']?></td>
                            <td><?php echo $row['estatus_alumno']?></td>
                            <td>
                                <a class="link-dark" style="text-decoration: none; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalinfo<?php echo $row['idAlumno'] ?>">
                                    <i title="Información" class="fa-solid fa-circle-info fs-5 me-3"></i>
                                </a>
                                <a style="text-decoration: none;" href="editar_alum.php?idAlumno=<?php echo $row['idAlumno']?>" class="link-dark">
                                    <i title="Editar" class="fa-solid fa-pen-to-square fs-5 me-3"></i>
                                </a>
                                <a style="text-decoration: none; cursor:pointer;" class="link-dark" onclick="alerta_eliminar(<?php echo $row['idAlumno']; ?>)">
                                    <fs-5 title="Desactivar" class="fa-solid fa-circle-xmark fs-5"></i>
                                </a>
                            </td>
                                <?php
                                include "info_alum.php";
                                ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
        }else{
            ?>
            <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                <symbol id="check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
                <symbol id="info-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </symbol>
                <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </symbol>
            </svg>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                <h2 style="text-align: center;">No cuentas con alumnos y/o grupo asignado</h2>
                </div>
            </div>
            <div>
                <h2 style="text-align: center;" class="alert alert-primary" role="alert">Revisa con dirección para solucionar la situación</h2>
            </div>
            <?php
        }
        ?>
    </main>

    <script>
        function alerta_eliminar(codigo){
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Estás a punto de desactivar al alumno",
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
                url: 'borrar_alum.php',
                type: 'POST',
                success: function(response){
                    Swal.fire({
                        title: "¡Hecho!",
                        text: "El alumno ha sido desactivado",
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
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../app/script.js"></script>

</body>
</html>